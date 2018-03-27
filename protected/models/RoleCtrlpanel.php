<?php

/* 
 * Expoon.com
 * Auth @Libra
 */

class RoleCtrlpanel extends CActiveRecord{
    public function getRoleCtrlPanel($roleid){
        $ctrlpanelid = self::model()->find(array(
            'select'=>'ctrlpanelid',
            'condition'=>'roleid=:roleid AND isdeleted=0',
            'params'=>array(':roleid'=>$roleid)
        ));
        return empty($ctrlpanelid) ? array() : $ctrlpanelid->getAttributes(array('ctrlpanelid'));
    }
//    public function getCtrlPanel($roleid){
//        $ctrlpanelid = self::model()->find(array(
//            'condition'=>'roleid=:roleid AND isdeleted=0',
//            'params'=>array(':roleid'=>$roleid)
//        ));
//        var_dump($ctrlpanelid);
//        die;
//        $ctrlpanels = CtrlPanel::model()->getCtrlPanel($ctrlpanelid,false,true);
//        return $ctrlpanels;
//    }
     public function getCtrlPanel($roleid,$isnormal=false,$ismenu=false){
        $_ctrlpanelid = self::model()->find(array(
            'condition'=>'roleid=:roleid AND isdeleted=0',
            'params'=>array(':roleid'=>$roleid)
        ));
        $ctrlpanelid = $_ctrlpanelid->getAttributes(array('ctrlpanelid'));
        if($ismenu){
           return CtrlPanel::model()->getCtrlPanel($ctrlpanelid['ctrlpanelid'],false,true);
        }else if($isnormal){
           return CtrlPanel::model()->getCtrlPanel($ctrlpanelid['ctrlpanelid'],true);
        }else{
            return CtrlPanel::model()->getCtrlPanel($ctrlpanelid['ctrlpanelid']);
        }
        //$ctrlpanels = CtrlPanel::model()->getCtrlPanel($ctrlpanelid['ctrlpanelid'],false,true);
        //return $ctrlpanels;
    }
    public function tableName(){
        return '{{rolectrlpanel}}';
    }
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
}