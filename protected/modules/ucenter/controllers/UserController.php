<?php

/* 
 * Expoon.com
 * Auth @Libra
 */

class UserController extends Controller{
    public function actions() { 
        return array( 'captcha' => 
                array( 
                'class' => 'Captcha', 
                'backColor' => 0xF5F5F5,
                'transparent'=>true,
                'minLength'=>4, //最短为4位
                'maxLength'=>4, //是长为4位
                'testLimit'=>1,
                ),
        ); 
    }
    public function actionLogin(){
        $model=new UserLoginForm();
        $this->renderPartial('login',array('model'=>$model),false,true);
    }
    public function actionLogout(){
        Yii::app()->session->clear();
        Yii::app()->session->destroy();
        $this->redirect('/ucenter/user/login');
    }
    public function actionChecklogin(){
        $groupid = addslashes(Yii::app()->request->getParam('groupid'));
        $username = addslashes(Yii::app()->request->getParam('username'));
        $password = md5(Yii::app()->request->getParam('password'));
        $verifycode = Yii::app()->request->getParam('verifycode');
        
        if($password=== md5('')){//不允许空密码,md5空字符串不能用empty判断
            die('fail');
        }
        if(strtolower($verifycode)!==strtolower($this->createAction('captcha')->getVerifyCode())){
            die('errorcode');
        }
        if($this->_Usermsg($groupid,$username,$password)){
            User::model()->updateAll(array('lastlogintime'=>time()),'groupid=:groupid AND uname=:uname',array(':groupid'=>$groupid,':uname'=>$username));
            $userinfo = $this->_Usermsg($groupid,$username,$password);
            Yii::app()->session['userinfo']=$userinfo;
            $this->redirect(Yii::app()->createUrl('/ucenter/article/type'));
        }else{
            die('erroruser');
        }
    }
    //查询登陆信息
    private function _Usermsg($groupid,$username,$password){
        $ishasgroup = Group::model()->exists('groupid=:groupid AND isdeleted=0',array('groupid'=>$groupid));
        if(!$ishasgroup){
            return false;
        }
        $ishasusername = User::model()->exists('groupid=:groupid AND uname=:username AND isdeleted=0',array('groupid'=>$groupid,'username'=>$username));
        if($ishasusername){
            $ishaspassword = User::model()->exists('groupid=:groupid AND uname=:username AND upwd=:password AND isdeleted=0',array('groupid'=>$groupid,'username'=>$username,'password'=>$password));
            if(!$ishaspassword){
                return false;
            }
        }else{
            return false;
        }
        //$userinfo = User::model()->find('groupid=:groupid AND uname=:uname',array(':groupid'=>$groupid,':uname'=>$username))->getAttributes(array('uid','roleid','groupid','uname'));
        $userinfo = User::model()->find(array(
            'select'=>'t.uid,t.roleid,t.groupid,t.uname,t.avatar,t1.groupname',
            'condition'=>'t.groupid=:groupid AND t.uname=:uname AND t.isdeleted=0 AND t1.isdeleted=0',
            'join'=>'LEFT JOIN {{group}} t1 ON t.groupid = t1.groupid',
            'params'=>array(':groupid'=>$groupid,':uname'=>$username)
        ));
        $_userinfo = $userinfo->getAttributes(array('uid','roleid','groupid','uname','avatar'));
        $_userinfo_groupname  = array('groupname'=>$userinfo['groupname']);
        $result = array_merge($_userinfo,$_userinfo_groupname);
        return empty($result) ? array() : $result;
    }
}