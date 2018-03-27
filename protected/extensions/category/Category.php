<?php

/* 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 */
class Category{
    public static function getTree($data,$pid=0,$level=0){
        static $arr=array();
        foreach($data as $v){
            if($v['pid']==$pid){
                $v['level']=$level;
                $arr[]=$v;
                Category::getTree($data,$v['id'],$level+1);
            }
        }
        return $arr;
    }
    public static function getParentArr($data,$pid=0,$level=0){
        static $parent=array();
        foreach($data as $v){
            if($v['pid']==$pid && $v['pid']!=0){
                    $v['level']=$level;
                    $parent['children']=$v;
                    Category::getParentArr($data,$v['id'],$level+1);
            }
        }
        return $parent;
        //static $chidren=array();
        
    }
    public static function getChilds($data,$pid,$isClear=false){
        static $ids=array();
        if($isClear){
            $ids=array();
        }
        foreach ($data as $v){
            if($v['pid']==$pid){
                $ids[]=$v['id'];
                Category::getChilds($data,$v['id']);
            }
        }
        return $ids;
    }
    public static function getFront($data,$pid=0){
        $arr=array();
        foreach($data as $v){
            if($v['pid']==$pid){
                $v['children']=Category::getFront($data,$v['id']);
                $arr[]=$v;
            }
        }
        return $arr;
    }
}
