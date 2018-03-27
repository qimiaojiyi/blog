<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
header('Content-type:text/html;charset=utf-8');
class UController extends Controller
{     
    public $ctrlpanel;
    public $layout='umanager';
    public function init(){
        $url = strtolower(Yii::app()->getRequest()->getUrl());
        $loginurl = strpos($url, '/ucenter/user/login');
        if(empty(Yii::app()->session['userinfo']) && !$loginurl>0){
            $this->redirect('/ucenter/user/login');
        }
        $groupid = Yii::app()->session['userinfo']['groupid'];
        //只获取显示在面板的模块
        $roletype = Util::getRoleID();
        $haspanels = array();
        
        if($roletype == 0){//用户为管理员,直接从group中查找所有模块
            $ctrlpanel = GroupCtrlPanel::model()->getCtrlPanel($groupid,false,true);
            //所拥有的面板模块，不用递归排序
            $_haspanels = GroupCtrlPanel::model()->getCtrlPanel($groupid,true);
        }else{//普通用户,需要从roleinfo中查找分配的模块
            $rolectrlpanelids = RoleCtrlpanel::model()->getRoleCtrlPanel($roletype);
            $ctrlpanel = CtrlPanel::model()->getCtrlPanel($rolectrlpanelids['ctrlpanelid'],false,true);
            $_haspanels = CtrlPanel::model()->getCtrlPanel($rolectrlpanelids['ctrlpanelid'],true);
        }
        $this->ctrlpanel = $ctrlpanel;
        foreach($_haspanels as $v){
            $haspanels[] = $v['panelpath']; 
        }
//        var_dump($haspanels);
        //处理当前浏览的路径,控制权限访问
        $visiturl = Yii::app()->request->getPathInfo();
        $module = $this->module->id;
        $cur_action = str_replace($module.'/', '', $visiturl);
        if(!in_array($cur_action, $haspanels)){
            $this->redirect('/site/denypage');
        }
    }
    
}