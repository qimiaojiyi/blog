<?php

/* 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 */

class PanelController extends MController{
    public function actionlist(){
        $panels = CtrlPanel::model()->getCtrlPanel();
        $this->render('list',array('panels'=>$panels));
    }
    public function actionAdd(){
        if(isset($_POST['subtn'])){
            $panelname = Yii::app()->request->getParam('panelname');
            $panelpath = Yii::app()->request->getParam('panelpath');
            $panelpid = Yii::app()->request->getParam('panelpid');
            $isshow = Yii::app()->request->getParam('isshow');
            if(empty($panelname) || empty($panelpath)){
                echo "<script>alert('所填信息，请不要留空！');history.back();</script>";
                die;
            }
            $panel_model = new CtrlPanel();
            $panel_model->panelpid = $panelpid;
            $panel_model->panelname = $panelname;
            $panel_model->panelpath = $panelpath;
            $panel_model->isshow = $isshow;
            $panel_model->addtime = time();
            $rs = $panel_model->save();
            if($rs){
                Yii::app()->user->setFlash('success','模块名添加成功！');
                $this->redirect('/manager/panel/list');
            }else{
                echo "<script>alert('添加失败，请重新添加')</script>;history.back();";
            }
        }else{
            $panels = CtrlPanel::model()->getTopCtrlPanel();
            $this->render('add',array('panels'=>$panels));
        }
    }
}