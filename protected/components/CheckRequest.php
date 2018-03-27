<?php

/* 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 */

class CheckRequest{
    public static function CheckAll(){
        CheckRequest::CheckAjax();
        CheckRequest::CheckTimes();
    }
    public static function CheckAjax(){
        //是否是IsAjax请求
        if(!Yii::app()->request->isAjaxRequest){
            die('bad quest');
        }
    }
    public static function CheckTimes(){
        //如果多人使用一个IP，可以通过增加请求次数来调整调取频率
        //请求次数
        $Set_Times = 10; 
        //间歇时间s
        $Sleep_Time = 5;
        $_IP = Yii::app()->request->userHostAddress;
        $IP = ip2long($_IP);
        $db = Yii::app()->db;
        $sql = "SELECT count FROM `test_visit` WHERE ip = {$IP}";
        $rs = $db->createCommand($sql)->queryAll();
        if(!$rs){
            $accesstime = time();
            $insert_sql = "insert into {{visit}} (ip,count,accesstime) values ('$IP',1,'$accesstime')";
            $insert_rs = $db->createCommand($insert_sql)->execute();
        }else if($rs[0]['count']<$Set_Times){
            Visit::model()->updateCounters(array('count'=>+1),'ip=:ip',array(':ip'=>$IP));
        }else{
            $now = time();
            $time_sql = "SELECT accesstime FROM `test_visit` WHERE ip = {$IP}";
            $time_rs = $db->createCommand($time_sql)->queryAll();
            //时间间隔
            $time_piece = $now - $time_rs[0]['accesstime'];
            $frequency = floatval($time_piece/$Set_Times);
            if($frequency<=1){
                sleep($Sleep_Time);
                Visit::model()->updateByPk($IP,array('count'=>0));
            }else{
                Visit::model()->deleteByPk($IP);
            }
            
        }
        
    }
}