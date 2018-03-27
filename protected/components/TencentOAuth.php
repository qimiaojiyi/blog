<?php

/* 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 * OAuth2.0
 */

class TencentOAuth{
    private $AppID;
    private $AppSecret;
    private $CallUrl;
    public function __construct($app_id=null,$app_secret=null,$cal_lurl=null) {
        $this->AppID = $app_id;
        $this->AppSecret = $app_secret;
        $this->CallUrl = $cal_lurl;
        session_start();
        $_SESSION['state'] = md5(uniqid(rand(), TRUE));
    }
    public function getCode(){
        $curl = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id={$this->AppID}&redirect_uri=".urlencode($this->CallUrl)."&state={$_SESSION['state']}";
        return $curl;
    }
    //获取Access_Token
    public function getAccessToken(){
        
    }
    //通过openid获取会员信息
    
}