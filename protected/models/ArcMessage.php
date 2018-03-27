<?php

/* 
 * Expoon.com
 * Auth @Libra
 */

class ArcMessage extends CActiveRecord{
    public $title;
    //显示和自己有关的留言
    public function getSelfMessage($uid,$page=1,$limit=5){
        $totalCount = $this->getTotal($uid);
        $totalpage = ceil($totalCount/$limit);
        $page = $page > $totalpage ? $totalpage : $page;
        if($page>$totalpage){
            return array();
        }
        //分页计算公式
        $offset = $limit*$page-$limit;
        
        if($offset>$totalCount){
            $offset =  $totalCount-$limit+1;
        }
        $message = array();
        $_message = self::model()->findAll(array(
            'select'=>'t.*,t1.title',
            'condition'=>"t.uid = {$uid} AND t.isdeleted = 0",
            'offset'=>$offset,
            'limit'=>$limit,
            'order'=>'t.id DESC',
            'join'=>'LEFT JOIN {{archives}} t1 ON t.arcid=t1.id AND t.isdeleted=0 AND t1.isdeleted=0'
        ));
        if(!empty($_message)){
            foreach($_message as $v){
                $message[] = $v->getAttributes(array('id','pid','arcid','uid','qqnickname','content','userip','addtime','title'));
            }
        }
        return $message;
    }
    //分页显示留言
    public function getMessage($arcid='',$page=1,$limit=5){
        $totalCount = $this->getTotal($arcid);
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
        $_message = self::model()->findAll(array(
            'condition'=>"arcid= {$arcid} AND isdeleted = 0 AND pid=0",
            'offset'=>$offset,
            'limit'=>$limit,
            'order'=>'id DESC'
        ));
        if(!empty($_message)){
            //循环父级的同时穷找到子级
            foreach($_message as $k=>$v){
                $message[] = $v->getAttributes(array('id','pid','qqnickname','qqfigureurl','content','click','addtime','level'));
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
    //获取全部文章列表分页显示
    public function tableName(){
        return '{{arcmessage}}';
    }
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
    //获取留言记录数
    public function getTotal($arcid){
        $condition = 'isdeleted = 0';
        if($arcid){
            $condition .= " AND arcid={$arcid} AND isdeleted = 0 AND pid=0";
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
}