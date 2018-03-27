<?php

/* 
 * Expoon.com
 * Auth @Libra
 */

class WebMessage extends CActiveRecord{
    //顶起来的留言
    public function getFavMessage(){
        $arr = array();
        $_arr = self::model()->findAll(array(
            'condition'=>'isdeleted = 0 AND pid=0 AND isprivate=0 AND click<>0',
            'limit'=>5,
            'order'=>'click DESC'
        ));
        if(!empty($_arr)){
            foreach($_arr as $v){
                $arr[] = $v->getAttributes(array('id','pid','qqnickname','qqfigureurl','content','click','addtime'));
            }
            return $arr;
        }
    }
    //分页显示公开留言
    public function getMessage($arcid='',$page=1,$limit=5,$notree=false){
        $totalCount = $this->getTotal();
        $totalpage = ceil($totalCount/$limit);
        //$page = $page > $totalpage ? $totalpage : $page;
        if($page>$totalpage){
            return array();
        }
        //分页计算公式
        $offset = $limit*$page-$limit;
        
        if($offset>$totalCount){
            $offset =  $totalCount-$limit+1;
        }
        $message = array();
        $condition = "isdeleted = 0 AND pid = 0 AND isprivate = 0";
        $_message = self::model()->findAll(array(
            'condition'=>$condition,
            'offset'=>$offset,
            'limit'=>$limit,
            'order'=>'id DESC'
        ));
        if(!empty($_message)){
            //不按照递归父子的方式取留言
            if($notree){
                foreach($_message as $k=>$v){
                    $message[] = $v->getAttributes(array('id','pid','isprivate','qqopenid','qqnickname','qqfigureurl','content','click','addtime','level'));
                }
                return $message;
            }
            //循环父级的同时穷找到子级
            foreach($_message as $k=>$v){
                $message[] = $v->getAttributes(array('id','pid','isprivate','qqopenid','qqnickname','qqfigureurl','content','click','addtime','level'));
                $kids = array();
                $level = 0;
                $info = $this->findKids($v['id']);
                $kids[] = $info;
                $kids[$level]['level'] = $level;
                while(isset($info['id'])){
                    $info = $this->findKids($info['id']);
                    $kids[] = $info;
                    $kids[$level]['level'] = $level;
                    $message[$k]['children']=$kids;
                    array_pop($message[$k]['children']);//删除最后一个空元素
                    $level++;
                }
            }
        }
        return Category::getTree($message,$pid=0);
    }
    //分页获取私有留言
    public function getMyMessage($arcid='',$page=1,$limit=5,$openid){
        $totalCount = $this->getTotal($openid);
        $totalpage = ceil($totalCount/$limit);
        //$page = $page > $totalpage ? $totalpage : $page;
        if($page>$totalpage){
            return array();
        }
        //分页计算公式
        $offset = $limit*$page-$limit;
        
        if($offset>$totalCount){
            $offset =  $totalCount-$limit+1;
        }
        $message = array();
        $condition = "isdeleted = 0 AND pid = 0 AND qqopenid= '$openid'";
        $_message = self::model()->findAll(array(
            'condition'=>$condition,
            'offset'=>$offset,
            'limit'=>$limit,
            'order'=>'id DESC'
        ));
        if(!empty($_message)){
            //循环父级的同时穷找到子级
            foreach($_message as $k=>$v){
                $message[] = $v->getAttributes(array('id','pid','isprivate','qqopenid','qqnickname','qqfigureurl','content','click','addtime','level'));
            }
        }
        return $message;
    }
    //获取留言记录数
    public function getTotal($openid=false){
        $condition = 'isdeleted = 0 AND pid = 0 AND isprivate = 0';
        if($openid){
           $condition =  "isdeleted = 0 AND pid = 0 AND qqopenid = '$openid'";
        }
        $rs = self::model()->count($condition);
        return $rs;
    }
    //通过父级找子级（穷尽）
    private function findKids($id){
        $_rs = self::model()->find(array(
            'condition'=>"pid = $id",
        ));
        return $_rs ? $_rs->getAttributes() : array();
    }
    public function tableName(){
        return '{{webmessage}}';
    }
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
}