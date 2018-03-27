<?php

/* 
 * Expoon.com
 * Auth @Libra
 */

class CtrlPanel extends CActiveRecord{
    //只获取父类（panelid=0）的panelname
    public function getTopCtrlPanel(){
            $panelnames = CtrlPanel::model()->findAll(array(
                'condition'=>'isdeleted=0 AND panelpid=0'
            ));
            $arr = array();
            if(!empty($panelnames)){
                foreach($panelnames as $v){
                    $arr[] = $v->getAttributes();
                }
            }
            return $arr;
    }
    /*
     * @param string ids  指定要查找的id集合
     * @param boolean isnormal 是否需要按照父子排序，默认为真
     * @param boolean ismemu 是否只查找显示面板的记录
     */
    public function getCtrlPanel($ids=false,$isnormal=false,$ismenu=false){
        //用户组用户有的面板权限如果不传ids说明查找所有，否则只查找符合条件的记录
        $condition = 'isdeleted=0 ';
        if($ismenu){
            $condition .="AND isshow=1 ";
        }
        if($ids){
            $condition .= "AND panelid IN ($ids) ";
        }
        $_rs = self::model()->findAll(array(
            'condition'=>$condition,
        ));
        $rs  = array();
        if(!empty($_rs)){
            foreach($_rs as $v){
                $rs[] = $v->getAttributes(); 
            }
        }
        return $isnormal ? $rs : $this->getFront($rs);
    }
    public function tableName(){
        return '{{ctrlpanel}}';
    }
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
    private function Tree($_arr,$pid=0){
        static $arr = array();
        foreach ($_arr as $v){
            if($v['panelpid']==$pid){
                $arr[] = $v;
                $this->Tree($_arr,$v['panelid']);
            }
        }
        return $arr;
    }
    private function getFront($_arr,$pid=0){
	$arr=array();
	foreach($_arr as $v){
		if($v['panelpid']==$pid){
                    $v['children']=$this->getFront($_arr,$v['panelid']);
                    $arr[]=$v;
		}
	}
	return $arr;
}
}