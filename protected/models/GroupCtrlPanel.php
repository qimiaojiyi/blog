<?php

/* 
 * Expoon.com
 * Auth @Libra
 */

class GroupCtrlPanel extends CActiveRecord{
    public function getCtrlPanel($groupid,$isnormal=false,$ismenu=false){
        //查找分组拥有的模块权限
        $condition = "groupid=:groupid AND isdeleted = 0";
        $hasctrlpanelid = GroupCtrlPanel::model()->find($condition,array(':groupid'=>$groupid));
        $_rs = $hasctrlpanelid->getAttributes(array('panelid'));
        $panelids = $_rs['panelid'];
        //非递归方法排序
        if($ismenu){
           return CtrlPanel::model()->getCtrlPanel($panelids,false,true);
        }else if($isnormal){
           return CtrlPanel::model()->getCtrlPanel($panelids,true);
        }else{
            return CtrlPanel::model()->getCtrlPanel($panelids);
        }
    }
    public function tableName(){
        return '{{groupctrlpanel}}';
    }
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
}