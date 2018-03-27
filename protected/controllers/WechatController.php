<?php

/* 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 */

class WechatController extends Controller{
    public function actionIndex(){
        $wechat_model = new WeChat();
        $wechat_model->responseMsg();
    }
    public function responseMsg(){
        
    }
}