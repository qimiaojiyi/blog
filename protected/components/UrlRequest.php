<?php

/* 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 */

class UrlRequest{
    public static function Request($curl,$method='get',$data=null,$https=false){
        $ch = curl_init();	
        curl_setopt($ch, CURLOPT_URL, $curl); //设置URL
        curl_setopt($ch, CURLOPT_HEADER, false);//不返回网页URL的头信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //不直接显示，返回一个字符串
        if($https){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//服务器端的证书不验证
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//客户端证书不验证
        }
        if($method == 'post'){
            $params ='';
            $postdata = null;
            if(is_array($data)){
                foreach ($data as $k=>$v){
                    $params .="$k=".urlencode($v).'&';
                }
                $postdata = substr($params, 0,-1);
            }
            curl_setopt($ch, CURLOPT_POST, true); //设置为POST提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);//设置提交数据$data
            
        }
        $str = curl_exec($ch);//执行访问
        curl_close($ch);//关闭curl释放资源
        return $str;
    }
}