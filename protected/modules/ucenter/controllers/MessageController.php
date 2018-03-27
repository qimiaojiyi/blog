<?php

/* 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 */
class MessageController extends UController{
    //留言
    public function actionArcmsg(){
        $uid = Yii::app()->session['userinfo']['uid'];
        $mymsg = ArcMessage::model()->getSelfMessage($uid);
        $this->render('arcmsg',array('mymsg'=>$mymsg));
    }
    public function actionWebmsg(){
        $msgs = WebMessage::model()->getMessage($arcid='',$page=1,$limit=5,$notree=true);
        $this->render('webmsg',array('msgs'=>$msgs));
    }
    public function actionDelarcmsg(){
        $msgid = Yii::app()->request->getParam('msgid');
        $uid = Yii::app()->session['userinfo']['uid'];
        
        $right = Util::CheckRight('arcmessage', array('id'=>$msgid,'uid'=>$uid));
        if($right){
            $rs = ArcMessage::model()->updateAll(array('isdeleted'=>1),'id=:id AND uid=:uid',array(':id'=>$msgid,'uid'=>$uid));
            Yii::app()->user->setFlash("success","√ 留言删除成功！");
            echo $rs>0 ? 'ok' : 'fail';
        }else{
            die('noright');
        }
    }
    public function actionDelwebmsg(){
        $msgid = Yii::app()->request->getParam('msgid');
        $uid = Yii::app()->session['userinfo']['uid'];
        
        $right = Util::CheckRight('webmessage', array('id'=>$msgid));
        if($right){
            $rs = WebMessage::model()->updateAll(array('isdeleted'=>1),'id=:id',array(':id'=>$msgid));
            Yii::app()->user->setFlash("success","√ 留言删除成功！");
            echo $rs>0 ? 'ok' : 'fail';
        }else{
            die('noright');
        }
    }
}
