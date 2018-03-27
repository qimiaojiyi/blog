<?php

/*
 * 解决验证码不随页面刷新问题 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 */

class Captcha extends CCaptchaAction{
    //继承CCaptchaAction类，然后重写run方法，使得验证码在页面刷新时刷新
    public function run(){
        if (isset($_GET[self::REFRESH_GET_VAR])){
            $code=$this->getVerifyCode(true);
            echo CJSON::encode(array(
                'hash1'=>$this->generateValidationHash($code),
                'hash2'=>$this->generateValidationHash(strtolower($code)),
                'url'=>$this->getController()->createUrl($this->getId(),array('v'=>uniqid())),
            ));
        }else {
            $this->renderImage($this->getVerifyCode(true));
            Yii::app()->end();
        }
    }
}