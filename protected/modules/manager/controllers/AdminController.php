<?php

/* 
 * Expoon.com
 * Auth @Libra
 */

class AdminController extends Controller{
    public function actions() { 
        return array( 'captcha' => 
                array( 
                'class' => 'CCaptchaAction', 
                'backColor' => 0xF5F5F5,
                'transparent'=>true,
                'minLength'=>4, //最短为4位
                'maxLength'=>4, //是长为4位
                ),
        ); 
    }
    public function actionLogin(){
        $model=new AdminLoginForm();
        $this->renderPartial('login',array('model'=>$model),false,true);
    }
    public function actionLogout(){
        Yii::app()->session->clear();
        Yii::app()->session->destroy();
        $this->redirect('/manager/admin/login');
    }
    public function actionChecklogin(){
        $username = addslashes(Yii::app()->request->getParam('username'));
        $password = md5(Yii::app()->request->getParam('password'));
        $verifycode = Yii::app()->request->getParam('verifycode');
        if($password=== md5('')){//不允许空密码,md5空字符串不能用empty判断
            die('fail');
        }
        if(strtolower($verifycode)!==strtolower($this->createAction('captcha')->getVerifyCode())){
            die('errorcode');
        }
        if($this->_Adminmsg($username,$password)){
            $admininfo = array('logintime'=>time(),'uname'=>$username);
            Yii::app()->session['admininfo']=$admininfo;
            $this->redirect(Yii::app()->createUrl('/manager/ucenter/list'));
        }else{
            die('erroradmin');
        }
    }
    //查询登陆信息
    private function _Adminmsg($username,$password){
        $ishasusername = Admin::model()->exists('uname=:username',array(':username'=>$username));
        if($ishasusername){
            $ishaspassword = Admin::model()->exists('pwd=:password',array(':password'=>$password));
            if($ishaspassword){
                return true;
            }
        }else{
            return false;
        }
    }
}