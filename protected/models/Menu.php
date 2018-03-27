<?php

/* 
 * Expoon.com
 * Auth @Libra
 */
class Menu extends CActiveRecord{
    public function tableName(){
        return '{{menu}}';
    }
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
    public function getMenu(){
        $rs = self::model()->findAll(array(
            'condition'=>'isdeleted=0',
            'order'=>'sortrank ASC,menuid DESC'));
        $_arr = array();
        foreach ($rs  as $v){
            $_arr[]=$v->getAttributes();
        }
        return $_arr;
    }
}
