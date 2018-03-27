<?php
class Db extends CActiveRecord{
    public function tableName(){
        return '{{arctype}}';
    }
    public static function model($className=__CLASS__){
        return parent::model($className);
    } 
}

