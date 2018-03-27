<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
header('Content-type:text/html;charset=utf-8');
class MController extends Controller
{     
    public $ctrlpanel;
    public $layout='manager';
    public function init(){
        header('Content-type:text/html;charset=utf8');
        $url = strtolower(Yii::app()->getRequest()->getUrl());
        $loginurl = strpos($url, '/manager/admin/login');
        if(empty(Yii::app()->session['admininfo']) && !$loginurl>0){
            $this->redirect('/manager/admin/login');
        }
        $ctrlpanel = CtrlPanel::model()->getCtrlPanel();
        $this->ctrlpanel = $ctrlpanel;
    }
    
}