<?php
class ArticleController extends UController{
    public function actionIndex(){
        echo 'hello';
        $this->render('index');
    }
    /**
     * 栏目管理
     * @flag 是否获取添加栏目时所有栏目列表
     * @pid 是否是查询子栏目
     */
    public function actionType(){
        $flag = Yii::app()->request->getParam('flag');//是否是ajax获取数据
        $pid = Yii::app()->request->getParam('pid')!=null ? intval(Yii::app()->request->getParam('pid')) : 0;
        if($flag==='api'){
            $types = ArcType::model()->getType('all');
            echo json_encode($types = Category::getTree($types));
            die;
        }else{
            $types = ArcType::model()->getType($pid);  //首页默认只显示顶级分类
            $this->render('type',array('types'=>$types));
        }
    }
    //获取指定子栏目
    public function actionChildtype(){
        $pid = Yii::app()->request->getParam('pid')!=null ? intval(Yii::app()->request->getParam('pid')) : 0;
        $types = ArcType::model()->getType($pid);
        $this->renderPartial('childtype',array('types'=>$types));
    }
    public function actionAddtype(){
        $ishidden = Yii::app()->request->getParam('ishidden');
        $typename = Yii::app()->request->getParam('typename');
        $pid = Yii::app()->request->getParam('pid');
        if($pid==0){
            $depth=0;
        }else{
            $_depth = explode('.',(Yii::app()->request->getParam('pid')));
            $depth = $_depth[1];
            $depth =$depth+1;
        }
        
        $sortrank = Yii::app()->request->getParam('sortrank');
        if(empty($typename) || empty($sortrank)){
            die();
        }
        $model = new ArcType();
        $model->ishidden = $ishidden;
        $model->typename = $typename;
        $model->pid = $pid;
        $model->depth = $depth;
        $model->sortrank = $sortrank;
        if($model->save()){
            echo 'ok';
        }
    }
    public function actionDeltype(){
        $typeid = intval(Yii::app()->request->getParam('typeid'));
        $delrs = ArcType::model()->updateByPk($typeid,array('isdeleted'=>1));
        echo $delrs==1 ? 'ok' : 'fail';
    }
    public function actionArticlelist(){
        $uid = Yii::app()->session['userinfo']['uid'];
        $typeid = intval(Yii::app()->request->getParam('typeid'));
        $breadcrumbs = ArcType::model()->getBreadCrumbs($typeid);
        $archives = Archives::model()->getArchives($typeid,$uid);
        $this->render('articlelist',array('archives'=>$archives,'breadcrumbs'=>$breadcrumbs));
    }
    public function actionAddarticle(){
        //通过快捷方式添加文章
        $typeid = intval(Yii::app()->request->getParam('typeid'));
        if(empty($typeid)){
            //获取当前添加的文章分类
            $_types = ArcType::model()->getType('all');
            $types = Category::getTree($_types);
            $this->render('addarticle',array('types'=>$types));
            die;
        }
        if(isset($_POST['subtn'])){
            $typeid = intval(Yii::app()->request->getParam('typeid'));
            $flag = Yii::app()->request->getParam('flag');
            $title = Yii::app()->request->getParam('title');
            $uploadpath = dirname(Yii::app()->basePath).'/uploads/manager/'.date('md');
            $uploadpath = str_replace('\\', '/', $uploadpath.'/');
            //判断是否上传缩略图
            if(isset($_FILES['thumb'])){
                if($_FILES['thumb']['error']==4){
                    $thumbrs[0] = '';
                    
                }else{
                    if(!file_exists($uploadpath)){
                        mkdir($uploadpath,0777);
                    }
                    $virtualpath = '/uploads/manager/'.date('md').'/';
                    $filename = date('mdh');

                    $thumbrs = Image::picUpload($virtualpath, $filename);
                    //判断上传图片结果
                    if($thumbrs =='1' || $thumbrs =='2' || $thumbrs =='3'){
                        die($thumbrs);
                    }
                }
            }
            $content = Yii::app()->request->getParam('ucontent');
            $archivesmodel = new Archives();
            $archivesmodel->typeid = $typeid;
            $archivesmodel->flag = $flag;
            $archivesmodel->litpic = $thumbrs[0];
            $archivesmodel->title = $title;
            $archivesmodel->writer = Yii::app()->session['userinfo']['uid'];
            $archivesmodel->pubdate = time();
            $archivesmodel->description = mb_substr(strip_tags($content), 0, 500, 'utf-8');
            $archivesmodel->content = $content;
            if($archivesmodel->save()){
                $this->redirect("/ucenter/article/articlelist?typeid=".$typeid.'?'.rand(0,99));
            }else{
                echo "文章发布失败，请重试";
            }
        }else{
            $breadcrumbs = ArcType::model()->getBreadCrumbs($typeid);
            $this->render('addarticle',array('breadcrumbs'=>$breadcrumbs));
        }
    }
    public function actionEditarticle(){
        if(isset($_POST['subtn'])){
            $arcid = Yii::app()->request->getParam('arcid');
            $typeid = Yii::app()->request->getParam('typeid');
            $typeid= intval(Yii::app()->request->getParam('typeid'));
            $flag = Yii::app()->request->getParam('flag');
            $title = Yii::app()->request->getParam('title');
            
            $content = Yii::app()->request->getParam('ucontent');
            
            $uploadpath = dirname(Yii::app()->basePath).'/uploads/manager/'.date('md');
            $uploadpath = str_replace('\\', '/', $uploadpath.'/');
            if(!file_exists($uploadpath)){
                mkdir($uploadpath,0777);
            }
            $virtualpath = '/uploads/manager/'.date('md').'/';
            $filename = date('mdh');

            $thumbrs = Image::picUpload($virtualpath, $filename);
            //判断上传图片结果
            if($thumbrs =='1' || $thumbrs =='2' || $thumbrs =='3'){
                $litpic = Yii::app()->request->getParam('litpic');
            }else{
               $litpic = $thumbrs[0]; 
            }
            $description = mb_substr(strip_tags($content), 0, 500, 'utf-8');
            $count = Archives::model()->updateByPk($arcid,array('typid'=>$typeid,'flag'=>$flag,'title'=>$title,'litpic'=>$litpic,'description'=>$description,'content'=>$content,'lastpost'=>time()));
            if($count>0){
                $this->redirect("/ucenter/article/articlelist?typeid=".$typeid.'?'.rand(0,99));
            }else{
                echo "文章修改失败，请重试";
            }
        }else{
            $typeid = Yii::app()->request->getParam('typeid');
            $arcid = intval(Yii::app()->request->getParam('arcid'));
            $breadcrumbs = ArcType::model()->getBreadCrumbs($typeid);
            $arcinfo = Archives::model()->getArchievebyid($arcid);
            $this->render('editarticle',array('arcinfo'=>$arcinfo,'breadcrumbs'=>$breadcrumbs));
        }
        
    }
    public function actionDelarticle(){
        $arcid = intval(Yii::app()->request->getParam('arcid'));
        $typeid = intval(Yii::app()->request->getParam('typeid'));
        $count = Archives::model()->updateByPk($arcid,array('isdeleted'=>1));
        if($count>0){
            $this->redirect("/ucenter/article/articlelist?typeid=".$typeid.'?'.rand(0,99));
        }else{
            echo "删除文章失败，请重试";
        }
    }
    public function actionChangetype(){
        $aid = intval(Yii::app()->request->getParam('arcid'));
        $typeid = intval(Yii::app()->request->getParam('typeid'));
        if((isset($aid) && isset($typeid))){
            $writer = Yii::app()->session['userinfo']['uid'];
            //判断文章拥有者
            $owner = Archives::model()->exists('id=:aid AND writer=:writer',array(':aid'=>$aid,':writer'=>$writer));
            if($owner){
                $rs = Archives::model()->updateByPK($aid,array('typeid'=>$typeid));
                echo $rs ? 'ok' : 'fail';
            }else{
                echo 'deny';
            }
        }else{
            $this->render('changetype');
        }
    }
    //最近的操作记录
    public function actionNearest(){
        $set_time = 14400;
        $nearest_archives = Archives::model()->getNearest($set_time);
        $this->render('nearest',array('archives'=>$nearest_archives));
        
    }
}

