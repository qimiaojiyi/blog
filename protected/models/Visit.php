<?php

/* 
 * Expoon.com
 * Auth @Libra
 */

class Visit extends CActiveRecord{
    public function tableName(){
        return '{{visit}}';
    }
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
}