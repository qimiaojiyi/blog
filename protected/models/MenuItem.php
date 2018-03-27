<?php

/* 
 * Expoon.com
 * Auth @Libra
 */
class MenuItem extends CActiveRecord{
    public function tableName(){
        return '{{menuitem}}';
    }
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
    //获取指定分类的菜品
    public function getMenuitem($menuid){
        $rs = self::model()->findAll(array(
            'condition'=>"menuid = {$menuid} AND isdeleted=0",
            'order'=>'issale DESC,menuitemid DESC'));
        $_arr = array();
        foreach ($rs  as $v){
            $_arr[]=$v->getAttributes();
        }
        return $_arr;
    }
    //判断菜品是否存在
}
