<?php

/* 
 * Expoon.com
 * Auth @Libra
 */

class Admin extends CActiveRecord{
    public function tableName(){
        return '{{admin}}';
    }
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
}