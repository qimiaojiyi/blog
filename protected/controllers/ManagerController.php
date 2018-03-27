<?php
class ManagerController extends Controller{
    public function actionIndex(){
        $this->render('index');
    }
    //栏目管理
    public function actionType(){
        $this->render('type');
    }
    
    public function actionAddtype(){
        $ishidden = Yii::app()->request->getParam('ishidden');
        $typename = Yii::app()->request->getParam('typename');
        $modeltype = Yii::app()->request->getParam('modeltype');
        $sortrank = Yii::app()->request->getParam('sortrank');
        $model = new ArcType();
        $model->ishidden = $ishidden;
        $model->typename = $typename;
        $model->modeltype = $modeltype;
        $model->sortrank = $sortrank;
        if($model->save()){
            echo 'ok';
        }
    }
}

