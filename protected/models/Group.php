<?php

/* 
 * Expoon.com
 * Auth @Libra
 */

class Group extends CActiveRecord{
    public $uname;
    public function getGroupList(){
        $criteria= new CDbCriteria;
        $criteria->select = 't.groupid,t.groupname,t.addtime,u.uname';
        $criteria->join = 'LEFT JOIN {{user}} u ON t.groupid = u.groupid WHERE u.isdeleted=0 AND t.isdeleted=0 AND u.roleid=0 ';
        $rs = array();
        $_rs = self::model()->findAll($criteria);
        if(!empty($_rs)){
            foreach ($_rs as $v){
                $rs[] = $v->getAttributes(array('groupid','groupname','addtime','uname'));
            }
        }
        return $rs;
    }
    public function getGroupListByPK($gid){
        $gid = intval($gid);
        //查询基本信息
        $sql = "SELECT t.groupid,t.groupname,u.uname,u.uid FROM `{{group}}` `t` LEFT JOIN test_user AS u ON t.groupid = u.groupid WHERE u.isdeleted=0 AND t.isdeleted=0 AND t.groupid = {$gid}";
        $db = Yii::app()->db;
        $rs = $db->createCommand($sql)->queryAll();
        //查询分组模块
        $panel_sql = "SELECT panelid FROM `{{groupctrlpanel}}` where groupid = {$gid}";
        $_panel_rs = $db->createCommand($panel_sql)->queryAll();
        if(!$rs || !$_panel_rs) return array();
        $panel_rs = explode(',',$_panel_rs[0]['panelid']);
        return array('baseinfo'=>$rs[0],'panelinfo'=>$panel_rs);
    }
    
    public function tableName(){
        return '{{group}}';
    }
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
}