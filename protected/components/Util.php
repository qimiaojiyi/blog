<?php

/* 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 */
class Util{
    /*
     * 检查是否拥有操作权限
     * @$table string 表名
     * @$condition array 数据表中的键值对
     * @$isadmin boolean 只验证管是否为理员
     */
    public static function CheckRight($TableName='',$condition=array(),$isadmin=false){
        $uid = Yii::app()->session['userinfo']['uid'];
        $db = Yii::app()->db;
        //验证是否为组管理员：roleid为0是管理
        if($isadmin){
            $uid_sql ="select roleid from test_user where  uid = {$uid}";
            $u_rs = $db->createCommand($uid_sql)->execute();
            return $u_rs[0]==0 ? true : false;
        }else{//表记录验证
            $sql = "select 1 from test_{$TableName} where ";
            foreach($condition as $k=>$v){
                $sql .= " {$k} = {$v} AND";
            }
            $sql = rtrim($sql,'AND');
            $rs = $db->createCommand($sql)->execute();
            return $rs ? true : false;
        }
    }
    //自定义时间格式
    public static function TimeFormat($time){
        //1.三分钟之内   2.一小时之内    3.十二小时之内  4.
        $time_piece = time() - $time;
        switch ($time){
            case $time_piece<60*3:
                return '刚刚';
                break;
            case $time_piece<60*60:
                return ceil($time_piece/60).'分钟前';
                break;
            case $time_piece<3600*12:
                return ceil($time_piece/3600).'小时前';
                break;
            case $time_piece<3600*24*30*12:
                return date('m-d',$time);
                break;
            default :
                return date('Y-m-d',$time);
        }
    }
    public static function IpToLocation($queryIP){ 
        $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$queryIP; 
        $ch = curl_init($url); 
        //curl_setopt($ch,CURLOPT_ENCODING ,'utf8'); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回 
        $location = curl_exec($ch); 
        $location = json_decode($location); 
        curl_close($ch); 

        $loc = ""; 
        if($location===FALSE) return ""; 
        if (empty($location->desc)) { 
            //$loc = $location->province.$location->city.$location->district.$location->isp; 
            $loc = $location->city; 
        }else{ 
            $loc = $location->desc; 
        } 
        return $loc; 
    }
    //关键字过滤
    public static function FilterWords($str){
        $bad_words = file_get_contents(dirname(__FILE__).'/../../assets/home/words/words.txt');
        $bad_words_arr = explode("\n", $bad_words);
        $badword1 = array_combine($bad_words_arr,array_fill(0,count($bad_words_arr),'*'));
        return strtr($str, $badword1);
    
    }
    //获取角色ID
    public static function getRoleID(){
        $uid = Yii::app()->session['userinfo']['uid'];
        if(!$uid){
            die('bad request');
        }
        $roleid = User::model()->findByPk($uid)->getAttributes(array('roleid'));
        return $roleid['roleid'];
    }
    public static function CutImg($imgsrc,$dstsrc,$x=0,$y=0,$width=200,$height=200){
        $background = imagecreatetruecolor($width, $height);
        //创建一个可以保存裁剪后图片的资源
        $image = self::CreateFrom($imgsrc);
        //使用imagecopyresampled()函数对图片进行裁剪
        imagecopyresampled($background,$image,0,0,$x,$y,$width,$height,$width,$height);
        //保存裁剪 后的图片，如果不想覆盖图片可以为裁剪后的图片加上前缀
        //header('Content-Type: image/jpeg');
        $rs = imagejpeg($background,$dstsrc);
        imagedestroy($background);
        imagedestroy($image);
        return $rs;
    }
    //根据图片类型调用对应的图片函数
    public static function CreateFrom($imgsrc){
        $type = self::getImgType($imgsrc);
        switch ($type){
            case 'jpg':
                $fucname = 'imagecreatefromjpeg';
                break;
            case 'png':
                $fucname = 'imagecreatefrompng';
                break;
            case 'gif':
                $fucname = 'imagecreatefromgif';
                break;
        }
        return $fucname($imgsrc);
    }
    //获取图片类型
    public static function getImgType($imgsrc){
        //$type_list = array("1"=>"gif","2"=>"jpg","3"=>"png","4"=>"swf","5" => "psd","6"=>"bmp","15"=>"wbmp");    
        $type_list = array("1"=>"gif","2"=>"jpg","3"=>'png');    
        if(file_exists($imgsrc)){   
            $img_info = @getimagesize($imgsrc); 
            if(isset($type_list[$img_info[2]])){   
                return $type_list[$img_info[2]];    
            }else{
                die('notsupport');
            }
        }else{    
            die("empty");    
        }
    }
}