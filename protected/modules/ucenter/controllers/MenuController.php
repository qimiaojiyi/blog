<?php
/* 
 * Expoon.com
 * Auth @Libra
 */
class MenuController extends MController{
    //分类列表
    public function actionMenu(){
        $menus = Menu::model()->getMenu();
        $this->render('menu',array('menus'=>$menus));
    }
    
    //添加分类
    public function actionAddmenu(){
        $menuname = trim(Yii::app()->request->getParam('menuname'));
        $sortrank = trim(Yii::app()->request->getParam('sortrank'));
        $result = Menu::model()->find("menuname = '{$menuname}' and isdeleted = 0");
        if ($result){
            echo 'exsit';
            $this->redirect("/manager/menu/list");
        }else{
            if (!empty($menuname)){
                $model = new Menu();
                $model->menuname = $menuname;
                $model->sortrank = $sortrank;
                $model->addtime = time();
                if ($model->save()){
                    echo 'ok';
                }else{
                    echo 'fail';
                }
            }else{
                $this->redirect(__APP__ . "/manager/menu/list");
            }
        }
    }
    
    
    //菜品列表
    public function actionMenuitem(){
        $menuid = Yii::app()->request->getParam('menuid');
        $menuname = Menu::model()->findByPk($menuid)->getAttributes(['menuname']);
        $menuitems  = MenuItem::model()->getMenuitem($menuid);
        $this->render('menuitem',array('menuid'=>$menuid,'menuname'=>$menuname['menuname'],'menuitems'=>$menuitems));
    }
    
    //添加菜品
    public function actionAddmenuitem(){
        $menuid = Yii::app()->request->getParam('menuid');
        $menuitemname = Yii::app()->request->getParam('menuitemname');
        $originalprice = Yii::app()->request->getParam('originalprice');
        $realprice = Yii::app()->request->getParam('realprice');
        $issale = Yii::app()->request->getParam('issale');
        $rs = MenuItem::model()->exists("menuid=:menuid AND menuitemname=:menuitemname",array(':menuid'=>$menuid,'menuitemname'=>$menuitemname));
        if($rs) die ('exist');
        
        if(empty($menuid) ||empty($menuitemname) || !isset($originalprice) || !isset($realprice) || !isset($issale)){
            die('empty');
        }
        $menuitemmodel = new MenuItem();
        $menuitemmodel->menuid=$menuid;
        $menuitemmodel->menuitemname=$menuitemname;
        $menuitemmodel->originalprice=$originalprice;
        $menuitemmodel->realprice=$realprice;
        $menuitemmodel->issale=$issale;
        $menuitemmodel->addtime = time();
        if($menuitemmodel->save()){
            echo 'ok';
        }else{
            echo 'fail';    
        }
    }
    
    //删除菜品
    public function actionDelmenuitem(){
        $menuitemid = intval(Yii::app()->request->getParam('menuitemid'));
        $count = MenuItem::model()->updateByPk($menuitemid,array('isdeleted'=>1));
        if($count >0){
            echo 'ok';
        }
    }
    public function actionShow(){
        echo date('Y-m-d H:i:s',1462431722);
    }
}

