<?php

/* 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 */

class TestWidget extends CWidget
{
    public $datetime = ''; 
    public $week ='';
    public function run()
    {
        $datetime = empty($this->datetime) ? date('Y-m-d H:i:s') : $this->datetime;
        $week = date('l');
        $this->render('test', array('datetime'=>$datetime,'week'=>$week));
    }
}
