<?php

/* 
 * Expoon.com
 * Auth @Libra
 */

class User extends CActiveRecord{
    public $groupname;
    public $rolename;
    public $type;
    public function getUserInfo($uid){
        $_info = self::model()->find(array(
            'condition'=>'uid = :uid AND isdeleted=0',
            'params'=>array(':uid'=>$uid)
        ));
        $info = array();
        if(!empty($_info)){
            $info[] = $_info->getAttributes();
        }
        return $info;
    }
    public function getUserList($groupid){
        $_list = self::model()->findAll(array(
            'select'=>'t.*,r.rolename',
            'condition'=>'t.groupid=:groupid AND t.isdeleted=0',
            'join'=>'LEFT JOIN {{roleinfo}} r ON t.roleid=r.roleid',
            'params'=>array(':groupid'=>$groupid)
        ));
        $list = array();
        if(!empty($_list)){
            foreach($_list as $k=>$v){
                $list[] = $v->getAttributes();
                array_push($list[$k],$v['rolename']);
            }
        }
        return $list;
    }
    public function tableName(){
        return '{{user}}';
    }
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
}