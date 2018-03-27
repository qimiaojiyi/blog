<?php
/* 
 * @Company    Expoon.com
 * @Author Libra 
 * @Email  316942723@qq.com
 */
class UcenterController extends MController{
    public function actionList(){
        $list = Group::model()->getGroupList();
        $this->render('list',array('list'=>$list));
    }
    public function actionAdd(){
        if(isset($_POST['subtn'])){
            $groupname = Yii::app()->request->getParam('groupname');
            $ctrlpanel = Yii::app()->request->getParam('ctrlpanel');
            $uname = Yii::app()->request->getParam('uname');
            $passwd = Yii::app()->request->getParam('passwd');
            //处理提交过来的模块ID
            $ctrlpanel_ids = array();
            if(empty($ctrlpanel)) die('<script>alert("所填选项不可为空");history.back()</script>');
            foreach($ctrlpanel as $id){
                $ctrlpanel_ids[] = intval($id);
            }
            try{
                $transaction = Yii::app()->db->beginTransaction();
                //添加用户组
                $g_model = isset($uid) ? Group::model()->findByPk($gid) : new Group();
                //设置初始组id(从10000开始)
                $count = $g_model->count(1);
                if(empty($count)){
                    $g_model->groupid = 10000;
                }
                $g_model->groupname = $groupname;
                $g_model->addtime = time();
                $g_model->save();
                $groupid = Yii::app()->db->getLastInsertID();
                
                //添加管理员用户
                $u_model = isset($uid) ? User::model()->findByPk($gid) : new User();
                $u_model->uname = $uname;
                $u_model->upwd = md5($passwd);
                $u_model->groupid = $groupid;
                $u_model->save();
                
                
                //保存分配的模块
                $ctrl_model = new GroupCtrlPanel();
                $ctrlpanel_ids = implode(',', $ctrlpanel_ids);
                $ctrl_model->id = null;
                $ctrl_model->groupid = $groupid;
                $ctrl_model->panelid = $ctrlpanel_ids;
                $ctrl_model->save();
                $transaction->commit();
                
            }catch(Exception $e){
                echo $e->getMessage(),$e->getLine();
                $transaction->rollback();
            }
            Yii::app()->user->setFlash("success","添加用户组成功！");
            $this->redirect('/manager/ucenter/list');
        }else{
            $this->render('add');
        }
    }
    public function actionEdit(){
        if(isset($_POST['subtn'])){
            $groupid = Yii::app()->request->getParam('groupid');
            $uid = Yii::app()->request->getParam('uid');
            $groupname = Yii::app()->request->getParam('groupname');
            $ctrlpanel = Yii::app()->request->getParam('ctrlpanel');
            $uname = Yii::app()->request->getParam('uname');
            $passwd = Yii::app()->request->getParam('passwd');
            //处理提交过来的模块ID
            $ctrlpanel_ids = array();
            if(empty($ctrlpanel)) die('empty');
            foreach($ctrlpanel as $id){
                $ctrlpanel_ids[] = intval($id);
            }
            try{
                $transaction = Yii::app()->db->beginTransaction();
                //修改用户组
                $g_model = Group::model();
                $g_model->updateByPK($groupid,array('groupname'=>$groupname));
                
                //修改管理员用户
                $u_model = User::model();
                if(empty($passwd)){
                    $u_model->updateByPK($uid,array('uname'=>$uname));
                }else{
                    $u_model->updateByPK($uid,array('uname'=>$uname,'upwd'=>md5($passwd)));
                }
                
                $ctrl_model = GroupCtrlPanel::model();
                //删除旧的模块记录
                //$ctrl_model->deleteAll('groupid=:groupid',array(':groupid'=>$groupid));
                //修改新分配的模块
                $ctrlpanel_ids = implode(',', $ctrlpanel_ids);
                $ctrl_model->updateAll(array('panelid'=>$ctrlpanel_ids),'groupid=:groupid',array(':groupid'=>$groupid));
                $transaction->commit();
                
            }
            catch(Exception $e){
                echo $e->getMessage(),$e->getLine();
                $transaction->rollback();
            }
            Yii::app()->user->setFlash("success","修改用户组成功！");
            $this->redirect('/manager/ucenter/list');
        }else{
            $gid = intval($_GET['gid']);
            $info = Group::model()->getGroupListByPK($gid);
            $this->render('edit',array('info'=>$info));
        }
    }
    public function actionDel(){
        $gid = Yii::app()->request->getParam('gid');
        $rs = Group::model()->updateByPk(intval($gid),array('isdeleted'=>1));
        if($rs){
            Yii::app()->user->setFlash("success","用户组删除成功！");
            $this->redirect('/manager/ucenter/list');
        }
    }
}

