<?php

/* 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 */
class Note extends CActiveRecord{
    public function getNotes($writer){
        $rs = self::model()->findAll(array(
            'condition'=>"writer = {$writer}",
            'order'=>'time desc',
        ));
        return $rs;
    }
    public function tableName(){
        return '{{note}}';
    }
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
}