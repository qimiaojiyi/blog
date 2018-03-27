<?php
class InstallController extends MController{
    public function actionIndex(){
        $this->renderPartial('index');
    }
    public function actionProcessing(){
//        var_dump($_POST);
        $dbaddr=Yii::app()->request->getParam('dbaddr');
        $dbuser=Yii::app()->request->getParam('dbuser');
        $dbpwd=Yii::app()->request->getParam('dbpwd');
        $dbprefix=Yii::app()->request->getParam('dbprefix');
        $dbname=Yii::app()->request->getParam('dbname');
        $upwd=Yii::app()->request->getParam('upwd');
        $uname=Yii::app()->request->getParam('uname');
        if(empty($dbaddr || $dbuser || $dbpwd || $dbname || $uname || $upwd)){
            die('不能为空');
        }
        $conn = @mysqli_connect($dbaddr,$dbuser,$dbpwd) or die('数据库用户名或者密码不正确');
        mysqli_query($conn,"drop database if exists {$dbname};");
        $sql = "create database {$dbname} charset utf8;";
        mysqli_query($conn,$sql) or die('Error querying database'.mysqli_error($conn));
        mysqli_query($conn,"use {$dbname}");
        //mysqli_query("use mde");
        //创建数据表忽略php版本低于4.1
        $sql4tmp = "ENGINE=MyISAM DEFAULT CHARSET=UTF8";
        $query = '';
        $fp = fopen('data/extable.txt','r');
        while(!feof($fp)){
            $line = rtrim(fgets($fp,1024));
            if(preg_match("/;$/", $line)){
                $query .=$line."\n";
                $query =  str_replace('#@__', $dbprefix, $query);
                if(preg_match('/CREATE/i', $query)){
                    $rs = mysqli_query($conn,preg_replace("/TYPE=MyISAM/i",$sql4tmp,$query));
                }else{
                    $rs = mysqli_query($conn,$query);
                }
                $query = '';
            }else if(!preg_match("/^(\/\/|--)/", $line)){
                $query .= $line;
            }
        }
        fclose($fp);
        
        //插入默认的管理员信息
        $addtime = time();
        $sql = "insert into ${dbprefix}admin". " values (1,0,'',md5('{$upwd}'),'{$uname}','','','',$addtime,'')";
        mysqli_query($conn,$sql);
    }
}

