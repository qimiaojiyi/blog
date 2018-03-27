<?php
/* 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 */
class SaveHttp extends CActiveRecord{
    public function tableName(){
        return '{{http}}';
    }
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
}