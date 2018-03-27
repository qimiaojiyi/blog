<?php
class ArcType extends CActiveRecord{
    public function tableName(){
        return '{{arctype}}';
    }
    public static function model($className=__CLASS__){
        return parent::model($className);
    } 
    
    //获取栏目
    public function getType($pid){
        $uid = Yii::app()->session['userinfo']['uid'];
        if($pid==='all'){
            $rs = self::model()->findAll(array(
            'condition'=>'ishidden=0 AND isdeleted=0',
            'order'=>'id ASC'));
        }else {
            $rs = self::model()->findAll(array(
                'condition'=>'ishidden=0 AND isdeleted=0 AND pid='.$pid,
                'order'=>'id ASC'
            ));
        }
        $_arr = array();
        foreach ($rs  as $k=>$v){
            $_arr[]=$v->getAttributes();
            $_arr[$k]['archivenum'] = Archives::model()->count("typeid={$v['id']} AND writer={$uid} AND isdeleted=0");
        }
        return $_arr;
    }
    public function getChildrenType(){
        //取出depth不为0的所有分类，可以自行定义
        $arr = array();
        $rs = self::model()->findAll(array(
            'condition'=>'depth <> 0 ',
            'order'=>'id DESC'
        ));
        if(!empty($rs)){
            foreach($rs as $v){
                $arr[] = $v->getAttributes();
            }
        }
        return $arr;
    }
    //获取顶级分类下所有的子类ID
    public function getChildrenTypeTree($id){
        $_childrentype = self::model()->findAll(array(
            'condition'=>"pid = {$id}"
        ));
        if($_childrentype){
            static $str = '';
            $str .= $id.',';
            $arr = array();
            foreach ($_childrentype as $k=>$v){
                $arr[] = $v->getAttributes(array('id'));
                $str .= $arr[$k]['id'].',';
                $this->getChildrenTypeTree($arr[$k]['id']);
            }
        }else{
            $str = $id;
        }
        return rtrim($str,',');
    }
    /*
     * 通过文章id获取面包屑导航
     * @param   int $typeid 最子级分类id
     * @param   string $link_style  访问链接路径
     */
    public function getBreadCrumbs($typeid,$link_style='/ucenter/article/articlelist?typeid='){
        $parent_info = $this->getPrentInfo($typeid);
        $arr = array();
        $arr[] = "<a href='{$link_style}{$parent_info['id']}'>".$parent_info['typename']."</a>";
        while($parent_info['pid']!=0 && $parent_info['pid']!=''){
            $parent_info = $this->getPrentInfo($parent_info['pid']);
            $arr[] = "<a href='{$link_style}{$parent_info['id']}'>".$parent_info['typename']."</a>";
        }
        krsort($arr);
        $str_link = implode(' > ', $arr);
        return $str_link;
    }
    public function getTopTypeID($setarcid=false,$settypeid=false){
        if($setarcid){
            $_typeid = Archives::model()->find(array(
                'select'=>'typeid,id',
                'condition'=>'id = :arcid AND isdeleted=0',
                'params'=>array(':arcid'=>$setarcid)
            ));
            $typeid = $_typeid->getAttributes(array('typeid'));
        }
        if($settypeid){
            $typeid = array('typeid'=>$settypeid);
        }
        $parent_info = $this->getPrentInfo($typeid['typeid']);
        
        //如何已经是顶级，则不再寻找上级
        if($parent_info['pid']==0){
            return array($typeid['typeid']);
        }
        $arr = array();
        $arr[] = $parent_info['pid'];
        while($parent_info['pid'] !=0 && $parent_info['pid'] !=''){
            $parent_info = $this->getPrentInfo($parent_info['pid']);
            $arr[] = $parent_info['id'];
            sort($arr);
        }
        //var_dump($arr);
        return $arr;
    }
    private function  getPrentInfo($nodleid){
        $_rs = self::model()->find(array(
            'select'=>'id,pid,typename',
            'condition'=>"id = {$nodleid}",
        ));
        $rs = $_rs->getAttributes();
        return $rs;
    }
}

