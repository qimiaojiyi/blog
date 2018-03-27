<?php

/* 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 */

class RoleController extends UController{
    //添加角色组
    public function actionAddrole(){
        if(isset($_POST['subtn'])){
            $ctrlpanel = Yii::app()->request->getParam('ctrlpanel');
            $rolename = Yii::app()->request->getParam('rolename');
            $groupid = Yii::app()->session['userinfo']['groupid'];
            //禁止角色名重复
            $exists = RoleInfo::model()->exists('groupid=:groupid AND rolename=:rolename',array(':groupid'=>$groupid,':rolename'=>$rolename));
            if($exists){
                die("<script>alert('角色名:[".$rolename."]已经被占用！');history.back();</script>");
            }
            if(empty($rolename)) die('rolename not allow empty');
            //处理$ctrlpanel数组
            if(!empty($ctrlpanel)){
                $_ids = '';
                foreach($ctrlpanel as $v){
                    $_ids .=$v.',';
                }
                $ids = rtrim($_ids,',');
                try{
                    $transaction = Yii::app()->db->beginTransaction();
                    //写入角色记录
                    $r_model = new RoleInfo();
                    $r_model->groupid = $groupid;
                    $r_model->rolename = $rolename;
                    $r_model->addtime = time();
                    $r_model->addby = Yii::app()->session['userinfo']['uid'];
                    $r_model->save();
                    $saveid = Yii::app()->db->getLastInsertID();
                    //写入角色对应的权限表
                    $rc_model = new RoleCtrlpanel();
                    $rc_model->roleid = $saveid;
                    $rc_model->ctrlpanelid = $ids;
                    $rc_model->save();
                    $transaction->commit();
                    Yii::app()->user->setFlash('success','角色添加成功！');
                    $this->redirect('/ucenter/role/rolelist');
                }catch (Exception $e){
                    echo $e->getMessage(),$e->getLine();
                    $transaction->rollback();
                }
                
            }else{
                die("<script>alert('权限分配不可为空，请至少选择一项！');history.back();</script>");
            }
        }else{
            $groupid = Yii::app()->session['userinfo']['groupid'];
            $roleid = Util::getRoleID();
            //分别取出组管理和普通用户拥有的权限
            $group_ctrlpanel = $roleid ==0 ? GroupCtrlPanel::model()->getCtrlPanel($groupid,false,false) : RoleCtrlpanel::model()->getCtrlPanel($roleid);
            $this->render('addrole',array('group_ctrlpanel'=>$group_ctrlpanel));
        }
    }
    public function actionRolelist(){
        $groupid = Yii::app()->session['userinfo']['groupid'];
        $roleinfo  = RoleInfo::model()->getRoleinfo($groupid);
        $this->render('rolelist',array('roleinfo'=>$roleinfo));
    }
    public function actionDelrole(){
        $groupid = Yii::app()->session['userinfo']['groupid'];
        $roleid = Yii::app()->request->getParam('rid');
        //只允许添加者或者组管理删除
        //是否是添加者
        $addby = RoleInfo::model()->findByPk($roleid);
        if(empty($addby)){
            die("<script>alert('非法操作');history.back();</script>");
        }
        $optid = $addby->getAttributes(array('addby'));
        $current_uid = Yii::app()->session['userinfo']['uid'];
        //是否是管理员
        $isAdmin = User::model()->findByAttributes(array('groupid'=>$groupid,'uid'=>$current_uid,'roleid'=>0),'isdeleted=0');
        
        if($optid['addby']==$current_uid || $isAdmin){
            //查询角色下是否有用户
            $has_user = User::model()->findByAttributes(array('roleid'=>$roleid),'isdeleted=0');
            if($has_user){
                die("<script>alert('当前角色下存在用户，不允许删除！');history.back();</script>");
            }
            try{
                $transaction = Yii::app()->db->beginTransaction();
                //删除角色基本信息表记录
                RoleInfo::model()->updateByPk($roleid,array('isdeleted'=>1));
                //删除角色模块表记录
                RoleCtrlpanel::model()->updateAll(array('isdeleted'=>1),'roleid = :roleid',array(':roleid'=>$roleid));
                $transaction->commit();
                Yii::app()->user->setFlash('success','角色删除成功！');
                $this->redirect('/ucenter/role/rolelist');
            }catch(Exception $e){
                echo $e->getMessage(),$e->getLine();
                $transaction->rollback();
            }
        }else{
            die('no privileges');
        }
    }
    public function actionEditrole(){
        $groupid = Yii::app()->session['userinfo']['groupid'];
        if(isset($_POST['subtn'])){
            $roleid = intval(Yii::app()->request->getParam('rid'));
            $rolename = Yii::app()->request->getParam('rolename');
            $ctrlpanel = Yii::app()->request->getParam('ctrlpanel');
            if(empty($rolename) || empty($ctrlpanel)) die("<script>alert('角色名、权限分配不可为空，请完善！');history.back();</script>");
            //var_dump($ctrlpanel);
            //处理ids数组
            $_ids = '';
            foreach($ctrlpanel as $v){
                $_ids .=$v.',';
            }
            $ids = rtrim($_ids,',');
            //echo $ids;
            try{
                $transaction = Yii::app()->db->beginTransaction();
                //修改角色基本信息表
                RoleInfo::model()->updateByPk($roleid,array('rolename'=>$rolename));
                //修改角色权限表
                RoleCtrlpanel::model()->updateAll(array('ctrlpanelid'=>$ids),'roleid = :roleid',array(':roleid'=>$roleid));
                $transaction->commit();
                Yii::app()->user->setFlash('success','角色修改成功！');
                $this->redirect('/ucenter/role/rolelist');
            }catch(Exception $e){
                echo $e->getMessage(),$e->getLine();
                $transaction->rollback();
            }
        }else{
            $rid = Yii::app()->request->getParam('rid');
            //管理员只能管理当前组里的用户
            $is_admin = Util::CheckRight('',array(),true);
            if($is_admin){
                //角色基本信息
                $base = RoleInfo::model()->getBaseRoleinfoByID($rid);
                //当前角色拥有的权限
                $role_ctrlpanel = RoleCtrlpanel::model()->getRoleCtrlPanel($rid);
                //当前组拥有的权限
                $group_ctrlpanel = GroupCtrlPanel::model()->getCtrlPanel($groupid,false,false);
            }
            $this->render('editrole',array('info'=>array('panelinfo'=>$role_ctrlpanel,'rolebase'=>$base,'group_ctrlpanel'=>$group_ctrlpanel)));
        }
        
    }
    public function actionAdduser(){
        $groupid = Yii::app()->session['userinfo']['groupid'];
        if(isset($_POST['subtn'])){
            $roleid = Yii::app()->request->getParam('roleid');
            $username = Yii::app()->request->getParam('username');
            //禁止用户名重复
            $exists = User::model()->exists('groupid=:groupid AND uname=:username',array(':groupid'=>$groupid,':username'=>$username));
            if($exists){
                die("<script>alert('用户名:[".$username."]已经被占用！');history.back();</script>");
            }
            $userpassword = Yii::app()->request->getParam('userpassword');
            if(empty($username) || empty($userpassword) || empty($roleid)){
                die("<script>alert('所填选项不可留空，请完善！');history.back();</script>");
            }
            $u_model = new User();
            $u_model->roleid = $roleid;
            $u_model->groupid = $groupid;
            $u_model->uname = $username;
            $u_model->upwd = md5($userpassword);
            $u_model->addby = Yii::app()->session['userinfo']['uid'];
            $rs = $u_model->save();
            if($rs){
                Yii::app()->user->setFlash('success','用户添加成功！');
                $this->redirect('/ucenter/role/userlist');
            }
            
        }else{
            $roles = RoleInfo::model()->getBaseRoleinfo($groupid);
            $this->render('adduser',array('roles'=>$roles));
        }
    }
    public function actionUserlist(){
        $groupid = Yii::app()->session['userinfo']['groupid'];
        $list = User::model()->getUserList($groupid);
        $roleinfo  = RoleInfo::model()->getBaseRoleinfo($groupid);
        $this->render('userlist',array('list'=>$list,'roleinfo'=>$roleinfo));
    }
    public function actionEdituser(){
        $groupid = Yii::app()->session['userinfo']['groupid'];
        $uid = intval(Yii::app()->request->getParam('uid'));
        //修改自己的账号
        $current_uid = intval(Yii::app()->session['userinfo']['uid']);
        //Ajax修改密码
        $password = Yii::app()->request->getParam('password');
        $isAjax = Yii::app()->request->getParam('ajax');
        if($isAjax){
            if($password=='******'){
                echo 'fail';
            }
            $uid = intval(Yii::app()->session['userinfo']['uid']);
            $rs = User::model()->updateByPk($uid,array('upwd'=>md5($password)));
            if($rs>0){
                echo 'ok';
            }else{
                echo 'fail';
            }
            die;
        }
        if($uid == $current_uid){
            $userinfo = User::model()->getUserInfo($uid);
            $roleinfo = RoleInfo::model()->getBaseRoleinfo($groupid);
            $this->render('editaccount',array('userinfo'=>$userinfo[0],'roleinfo'=>$roleinfo));
            die;
        }
        
        if(isset($_POST['subtn'])){
            $roleid = Yii::app()->request->getParam('roleid');
            $username = Yii::app()->request->getParam('username');
            $uid = Yii::app()->request->getParam('uid');
            //是否是添加者
            $addby = User::model()->findByPk($uid);
            if(empty($addby)){
                die("<script>alert('非法操作');history.back();</script>");
            }
            $optid = $addby->getAttributes(array('addby'));
            $isAdmin = User::model()->findByAttributes(array('groupid'=>$groupid,'uid'=>$current_uid,'roleid'=>0),'isdeleted=0');
            
            if($optid['addby']==$current_uid || $isAdmin){
                //禁止用户名重复
                $exists = User::model()->exists('groupid=:groupid AND uname=:username',array(':groupid'=>$groupid,':username'=>$username));
                if($exists){
                    die("<script>alert('用户名:[".$username."]已经被占用！');history.back();</script>");
                }
                $userpassword = Yii::app()->request->getParam('userpassword');
                if(empty($roleid)){
                    die("<script>alert('所填选项不可留空，请完善！');history.back();</script>");
                }
                if(empty($userpassword)){
                    $updatedate = array('roleid'=>$roleid);
                }else{
                    $updatedate = array('roleid'=>$roleid,'upwd'=>md5($userpassword));
                }
                $rs = User::model()->updateByPk($uid,$updatedate);
                if($rs>0){
                    Yii::app()->user->setFlash('success','用户修改成功！');
                    $this->redirect('/ucenter/role/userlist');
                }else{
                    Yii::app()->user->setFlash('success','没有变动任何信息！');
                    $this->redirect('/ucenter/role/userlist');
                }
            }
        }else{
            $userinfo = User::model()->getUserInfo($uid);
            $roleinfo = RoleInfo::model()->getBaseRoleinfo($groupid);
            $this->render('edituser',array('userinfo'=>$userinfo[0],'roleinfo'=>$roleinfo));
        }
    }
    public function actionSetProfile(){
        $uid = Yii::app()->session['userinfo']['uid'];
        //设置用户图像文件夹名称规则
        $avatardir = substr(md5($uid),-15);
        //设置用户图像名称规则
        $avatarname = substr(md5($uid),0,10);
        //保存图片
        if(isset($_FILES['thumb'])){
            //创建用户图像目录
            $virtualdir = dirname(Yii::app()->basePath).'/uploads/avatar/'.$avatardir.'/';
            if(!file_exists($virtualdir)){
                mkdir($virtualdir,0777);
            }
            //保存图像的完整路径
            $virtualpath = '/uploads/avatar/'.$avatardir.'/';
            $filename = uniqid();
            $rs = Image::picUpload($virtualpath, $filename);
            //裁剪图片源地址
            $imgsrc = dirname(Yii::app()->basePath).$rs[0];
            //图像文件目的地址
            $dstsrc = dirname(Yii::app()->basePath).$virtualpath.$avatarname.'.'.Util::getImgType($imgsrc);
            //图像文件的绝对路径
            $avatarsrc = $virtualpath.$avatarname.'.'.Util::getImgType($imgsrc);
            $res = Util::CutImg($imgsrc,$dstsrc,$_POST['x'], $_POST['y'], $_POST['width'], $_POST['height']);
            unlink($imgsrc);
            //写入用户图片地址到数据库
            $save_rs = User::model()->updateByPk($uid,array('avatar'=>$avatarsrc));
            echo $res ? $avatarsrc : 'fail';
        }else{
            die('empty');
        }
        
    }
    public function actionDeluser(){
        $groupid = Yii::app()->session['userinfo']['groupid'];
        $uid = Yii::app()->request->getParam('uid');
        //是否是添加者
        $addby = User::model()->findByPk($uid);
        if(empty($addby)){
            die("<script>alert('非法操作');history.back();</script>");
        }
        $optid = $addby->getAttributes(array('addby'));
        $current_uid = Yii::app()->session['userinfo']['uid'];
        //是否是管理员
        $isAdmin = User::model()->findByAttributes(array('groupid'=>$groupid,'uid'=>$current_uid,'roleid'=>0),'isdeleted=0');
        
        if($optid['addby']==$current_uid || $isAdmin){
            User::model()->updateByPk($uid,array('isdeleted'=>1));
            Yii::app()->user->setFlash('success','用户删除成功！');
            $this->redirect('/ucenter/role/userlist');
        }else{
            die('没有权限的操作');
        }
    }
}