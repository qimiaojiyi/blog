<?php

/* 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 */

class IndexController extends UController{
    public function actionIndex(){
        $this->render('index');
    }
    public function actionTest(){
        $groupid = 10005;
        $username = 'AKen';
        $userinfo = User::model()->find(array(
            'select'=>'t.uid,t.roleid,t.groupid,t.uname,t1.groupname',
            'condition'=>'t.groupid=:groupid AND t.uname=:uname AND t.isdeleted=0 AND t1.isdeleted=0',
            'join'=>'LEFT JOIN {{group} t1 ON t.groupid = t1.groupid}',
            'params'=>array(':groupid'=>$groupid,':uname'=>$username)
        ));
        $_userinfo = $userinfo->getAttributes(array('uid','roleid','groupid','uname'));
        $_userinfo_groupname  = array($userinfo['groupname']);
        $result = array_merge($_userinfo,$_userinfo_groupname);
        var_dump($rs);
    }
    
}