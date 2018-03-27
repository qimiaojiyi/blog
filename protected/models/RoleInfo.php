<?php
/* 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 */

class RoleInfo extends CActiveRecord{
    public $ctrlpanelid;
    //通过roleid获取信息
    public function getBaseRoleinfoByID($rid){
        $rs = self::model()->find(array(
            'condition'=>'roleid = :roleid',
            'params'=>array(':roleid'=>$rid)
        ));
        return !empty($rs) ? $rs->getAttributes() : array();
    }
    //获取角色基本信息
    public function getBaseRoleinfo($groupid){
        $roles = self::model()->findAll(array(
            'condition'=>'groupid=:groupid AND isdeleted=0',
            'params'=>array(':groupid'=>$groupid)
        ));
        $arr = array();
        if(!empty($roles)){
            foreach($roles as $v){
                $arr[] = $v->getAttributes();
            }
        }
        return $arr;
    }
    //获取角色的详细有关的信息
    public function getRoleinfo($groupid){
        $roles  = self::model()->findAll(array(
            'select'=>'t.*,t1.ctrlpanelid',
            'condition'=>"t.groupid = :groupid AND t.isdeleted=0 AND t1.isdeleted=0",
            'join'=>'LEFT JOIN {{rolectrlpanel}} t1 ON t.roleid=t1.roleid',
            'params'=>array(':groupid'=>$groupid)
        ));
        $arr = array();
        if(!empty($roles)){
            foreach ($roles as $k=>$v){
                //查找模块名称
                $ctrlpanels = CtrlPanel::model()->getCtrlPanel($v['ctrlpanelid']);
                $arr[$k][] = $v->getAttributes(); 
                $arr[$k]['panelname'] = $ctrlpanels; 
            }
        }
        return $arr;
    }
    public function tableName(){
        return '{{roleinfo}}';
    }
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
}