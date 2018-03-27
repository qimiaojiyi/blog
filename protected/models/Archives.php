<?php
class Archives extends CActiveRecord{
    public $uname;
    public $typename;
    public $avatar;
    public function tableName(){
        return '{{archives}}';
    }
    public static function model($className=__CLASS__){
        return parent::model($className);
    } 
    //获取全部文章列表分页显示
    public function getAllArchives($page=1,$limit=10,$typeid=false,$ischildtypeid=false){
        if(!empty($typeid)){
            $typeid = ArcType::model()->getChildrenTypeTree($typeid);
        }
	if(!empty(!empty($ischildtypeid))){
	    $typeid = ArcType::model()->getChildrenTypeTree($ischildtypeid);
	}
        //查看查找的typeid是否是顶级分类
        $totalCount = $this->getTotal($typeid);
        $totalpage = ceil($totalCount/$limit);
        $page = $page > $totalpage ? $totalpage : $page;
        //分页计算公式
        $offset = $limit*$page-$limit;
        
        if($offset>$totalCount){
            $offset =  $totalCount-$limit+1;
        }
        $condition = "t.isdeleted=0 AND type.isdeleted=0";
        if($typeid){
            $condition .=" AND t.typeid IN ({$typeid})";
        }
        if($ischildtypeid){
            $condition .=" AND t.typeid IN ({$ischildtypeid})";
        }
        $rs = self::model()->findAll(array(
            'select'=>'t.id,t.typeid,t.click,t.title,t.writer,t.litpic,t.pubdate,t.description,u.avatar,u.uname,type.typename',
            'condition'=> $condition,
            'join'=>'LEFT JOIN {{user}} u ON u.uid=t.writer LEFT JOIN {{arctype}} type ON t.typeid = type.id ',
            'order'=>'id DESC',
            'offset'=>$offset,
            'limit'=>$limit,
        ));
        
        $_arr = array();
        foreach ($rs  as $v){
            $_arr[]=$v->getAttributes(array('id','typeid','click','title','pubdate','description','avatar','uname','typename'));
        }
        return array('info'=>$_arr,'totalpage'=>$totalpage);
    }
    //获取总文章记录数
    public function getTotal($typeid=null){
        $condition = 'isdeleted = 0';
        if($typeid){
            $condition .= " AND typeid IN ({$typeid})";
        }
        $rs = self::model()->count($condition);
        return $rs;
    }
    //获取栏目下对应的文章
    public function getArchives($typeid,$uid){
	echo 11111;
        $rs = self::model()->findAll(array(
            'select'=>'t.id,t.typeid,t.click,t.title,t.pubdate,u.uname',
            'condition'=>"t.isdeleted=0 and t.typeid={$typeid} and t.writer={$uid}",
            'order'=>'id DESC',
            'join'=>'LEFT JOIN {{user}} u ON u.uid=t.writer',
        ));
        $_arr = array();
        foreach ($rs  as $v){
            $_arr[]=$v->getAttributes(array('id','typeid','click','title','pubdate','uname'));
        }
        return $_arr;
    }
    //获取指定文章
    public function  getArchievebyid($archievesid){
        $rs = self::model()->find(array(
            'select'=>'t.id,t.typeid,t.title,t.flag,t.click,t.litpic,t.pubdate,t.content,t.writer,u.avatar,u.uname,type.typename',
            'condition'=>"t.isdeleted=0 and t.id={$archievesid} AND type.isdeleted=0",
            'join'=>'LEFT JOIN {{user}} u ON u.uid=t.writer LEFT JOIN {{arctype}} type ON t.typeid = type.id ',
            'order'=>'id DESC'
        ));
        return $rs->getAttributes(array('id','typeid','click','litpic','title','pubdate','avatar','uname','content','typename'));
    }
    //获取相关文章
    public function getLikeArchieve($arcid=false,$typeid=false){
        $condition = 't.isdeleted=0 ';
        if($arcid){
            $_typeid = self::model()->find(array(
            'select'=>'typeid',
            'condition'=>"id ={$arcid}",
            ));
            if(!$_typeid) return array();
            $typeid = $_typeid->getAttributes(array('typeid'));
        }
        if($typeid){
            $typeid = array('typeid'=>$typeid);
            $condition .= "and t.typeid={$typeid['typeid']}";
        }
        
        $rs = self::model()->findAll(array(
            'select'=>'t.id,t.typeid,t.title,t.flag,t.click,t.litpic,t.pubdate,t.content,t.writer,u.uname',
            'condition'=>$condition,
            'join'=>'LEFT JOIN {{user}} u ON u.uid=t.writer',
            'order'=>'id DESC',
            'limit'=>8,
        ));
        if(!$rs) $likers = array();
        foreach ($rs as $v){
            $likers[] = $v->getAttributes(array('id','typeid','click','litpic','title','pubdate','uname'));
        }
        return $likers;
    }
    //获取最近操作的文章
    /*
     * @param $time 指定时间内的文章(单位s)
     */ 
    public function getNearest($time=7200){
        $uid = Yii::app()->session['userinfo']['uid'];
        $owner = isset($uid) ? $uid : null;
        $now_time = time();
        $nearest_time = $now_time-$time;
        $_archives = Archives::model()->findAll(array(
            'select'=>'t.id,t.typeid,t.click,t.title,t.lastpost,u.uname',
            'condition'=>"t.isdeleted=0 and t.writer={$owner} and t.lastpost > {$nearest_time} or t.isdeleted=0 and t.writer={$owner} and t.lastpost=0",
            'order'=>'id DESC',
            'join'=>'LEFT JOIN {{user}} u ON u.uid=t.writer',
        ));
        $archives = array();
        if(!empty($_archives)){
            foreach ($_archives as $v){
                $archives[] = $v->getAttributes(array('id','typeid','click','title','lastpost','uname'));
            }
        }
        return $archives;
    }
}

