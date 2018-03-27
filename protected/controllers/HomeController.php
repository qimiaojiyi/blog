<?php

/* 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 */

class HomeController extends Controller{
    public function filters(){
        return array(array(
            'COutputCache + article,summary',
            'duration'=>7200,
            'varyByParam'=>array('aid'),
        ));
    }
    public $title = '个人博客分享-七秒记忆，做些有意义的事';
    public $keywords = '个人博客,七秒记忆,技术博客,技术分享-七秒记忆网';
    public $description = '个人博客,个人网站-七秒记忆网';
    public $typeid = 0;
    public $emotion = array(
            '[惊呆]'=>'1',
            '[可爱]'=>'2',
            '[憨笑]'=>'3',
            '[坏笑]'=>'4',
            '[无聊]'=>'5',
            '[生气]'=>'6',
            '[折磨]'=>'7',
            '[不屑]'=>'8',
            '[流泪]'=>'9',
            '[不理]'=>'10',
            '[晕]'=>'11',
            '[冷汗]'=>'12',
            '[困]'=>'13',
            '[害羞]'=>'14',
            '[呐喊]'=>'15',
            '[稀罕]'=>'16',
            '[色]'=>'17',
            '[酷]'=>'18',
            '[石化]'=>'19',
            '[囧]'=>'20',
            '[睡觉]'=>'21',
            '[调皮]'=>'22',
            '[亲亲]'=>'23',
            '[疑问]'=>'24',
            '[闭嘴]'=>'25',
            '[难过]'=>'26',
            '[好奇]'=>'27',
            '[得意]'=>'28',
            '[鄙视]'=>'29',
            '[猪头]'=>'30'
        );
    public function actiontest(){
        $this->render('test');
	#file_put_contents('./file.txt', time());
    }
    public function actionIndex(){
        $_page = Yii::app()->request->getParam('page');
        $page =  isset($_page)? $_page : 1;
        //文章列表
        $archives = Archives::model()->getAllArchives($page,10);
        //相关文章
        $likearchive = Archives::model()->getLikeArchieve();
        //子栏目右侧分类
        $childretype = ArcType::model()->getChildrenType();
        
        $this->render('index',array('archives'=>$archives,'likearticle'=>$likearchive,'childrentype'=>$childretype));
    }
    //前端
    public function actionFront(){
        $_page = Yii::app()->request->getParam('page');
        $this->typeid = 1;
        $page =  isset($_page)? $_page : 1;
        $likearchive = Archives::model()->getLikeArchieve(false,$this->typeid);
        $archives = Archives::model()->getAllArchives($page,10,$this->typeid);
        //子栏目右侧分类
        $childretype = ArcType::model()->getChildrenType();
        $this->render('arclist',array('archives'=>$archives,'likearticle'=>$likearchive,'childrentype'=>$childretype));
    }
    //后端
    public function actionBack(){
        $_page = Yii::app()->request->getParam('page');
        $this->typeid = 2;
        $page =  isset($_page)? $_page : 1;
        $likearchive = Archives::model()->getLikeArchieve(false,$this->typeid);
        $archives = Archives::model()->getAllArchives($page,10,$this->typeid);
        //子栏目右侧分类
        $childretype = ArcType::model()->getChildrenType();
        $this->render('arclist',array('archives'=>$archives,'likearticle'=>$likearchive,'childrentype'=>$childretype));
    }
    //系统相关
    public function actionSystem(){
        $_page = Yii::app()->request->getParam('page');
        $this->typeid = 3;
        $page =  isset($_page)? $_page : 1;
        $likearchive = Archives::model()->getLikeArchieve(false,$this->typeid);
        $archives = Archives::model()->getAllArchives($page,10,$this->typeid);
        //子栏目右侧分类
        $childretype = ArcType::model()->getChildrenType();
        $this->render('arclist',array('archives'=>$archives,'likearticle'=>$likearchive,'childrentype'=>$childretype));
    }
    //杂谈
    public function actionZatan(){
        $this->title = '网络杂谈-七秒记忆网';
        $_page = Yii::app()->request->getParam('page');
        $this->typeid = 4;
        $page =  isset($_page)? $_page : 1;
        $likearchive = Archives::model()->getLikeArchieve(false,$this->typeid);
        $archives = Archives::model()->getAllArchives($page,10,$this->typeid);
        //子栏目右侧分类
        $childretype = ArcType::model()->getChildrenType();
        $this->render('arclist',array('archives'=>$archives,'likearticle'=>$likearchive,'childrentype'=>$childretype));
    }
    //文章详情页
    public function actionArticle(){
        $arcid = Yii::app()->request->getParam('aid');
        $archive = Archives::model()->getArchievebyid($arcid);
        $topid = ArcType::model()->getTopTypeID($arcid);
        $this->typeid = $topid[0];
        $this->title = $archive['title'].'-七秒记忆网';
        $this->description = $archive['title'];
        //相关文章
        $likearchive = Archives::model()->getLikeArchieve(false,$this->typeid);
        //相关留言
        //$livemessages = ArcMessage::model()->getMessage($arcid); 
        //子栏目右侧分类
        $childretype = ArcType::model()->getChildrenType();
        $this->render('article',array('article'=>$archive,'likearticle'=>$likearchive,'childrentype'=>$childretype));
    }
    //子分类页
    public function actionChildType(){
        $typeid = Yii::app()->request->getParam('typeid');
        $this->title = '网络杂谈-七秒记忆网';
        $_page = Yii::app()->request->getParam('page');
        $topid = ArcType::model()->getTopTypeID(false,$typeid);
        $this->typeid = $topid[0];
        $page =  isset($_page)? $_page : 1;
        $likearchive = Archives::model()->getLikeArchieve(false,$typeid);
        $childtypeid = $typeid;
        $archives = Archives::model()->getAllArchives($page,10,false,$childtypeid);
        //子栏目右侧分类
        $childretype = ArcType::model()->getChildrenType();
        $this->render('arclist',array('archives'=>$archives,'likearticle'=>$likearchive,'childrentype'=>$childretype));
    }
    //ajax获取文章留言分页使用无限分类
    public function actionGetmessage(){
        CheckRequest::CheckAll();
        $arcid = Yii::app()->request->getParam('arcid');
        $page = Yii::app()->request->getParam('page');
        if(trim($arcid)==''){
            echo json_decode('param invalid');
        }
        $livemessages = ArcMessage::model()->getMessage($arcid,$page);
        //循环一次用于转换日期显示
        $format_time_messages = array();
        foreach($livemessages as $key=>$v){
            $format_time_messages[$key]=$v;
            $format_time_messages[$key]['addtime'] = $this->TimeFormat($v['addtime']);
            if(isset($livemessages[$key]['children'])){
                foreach ($livemessages[$key]['children'] as $k1=>$v1){
                    $format_time_messages[$key]['children'][$k1]['addtime'] = $this->TimeFormat($v1['addtime']);
                }
            }
            
        }
        if(empty($livemessages)){
            echo json_decode('empty');
        }
        header('HTTP/1.1 200 OK');
        header('Content-type: application/json');
        echo json_encode($format_time_messages);
    }
    //点赞
    public function actionPraise(){
        CheckRequest::CheckAjax();
        $type = Yii::app()->request->getParam('typeid');
        /*
         * @type 1：文章点赞    2：文章留言点赞     3：网站留言点赞
         */
        switch ($type){
            case 1:
                $aid = Yii::app()->request->getParam('id');
                try{
                    $rs = Archives::model()->updateCounters(array('click'=>+1),'id=:aid',array(':aid'=>$aid));
                }catch (Exception $e){
                    echo $e->getCode();
                }
                break;
            case 2:
                $msgid = Yii::app()->request->getParam('msgid');
                try{
                    $rs = ArcMessage::model()->updateCounters(array('click'=>+1),'id=:msgid',array(':msgid'=>$msgid));
                }catch (Exception $e){
                    echo $e->getCode();
                }
                break;
            case 3:
                $msgid = Yii::app()->request->getParam('msgid');
                try{
                    $rs = WebMessage::model()->updateCounters(array('click'=>+1),'id=:msgid',array(':msgid'=>$msgid));
                }catch (Exception $e){
                    echo $e->getCode();
                }
                break;
        }
        
    }
    
    // public function actionTest(){
    //     $bb = ArcType::model()->getChildrenTypeTree(1);
    //     //$rs = Util::FilterWords($bb);
    //     var_dump($bb);

    //     //ini_set('session.gc_maxlifetime',3600); 
    // }
    //网站留言展示
    public function actionLeavemsg(){
        //查询当前登陆的
        $this->typeid = 8;
        //公开的留言
        $messages = WebMessage::model()->getMessage();
        $total = WebMessage::model()->getTotal();
        
        //我的留言
        $openid = isset(Yii::app()->session['qqinfo']) ? Yii::app()->session['qqinfo'] : false;
        if($openid){
            $mine_messages = WebMessage::model()->getMyMessage(false,1,5,$openid);
        }else{
            $mine_messages = array();
        }
        $favmessages = WebMessage::model()->getFavMessage();
        $this->render('leavemsg',array('total'=>$total,'messages'=>$messages,'favmessage'=>$favmessages,'mine_messages'=>$mine_messages));
    }
    //ajax获取网站留言分页数据
    public function actionGetWebmessage(){
        $msgtype = Yii::app()->request->getParam('msgtype');
        $openid = isset(Yii::app()->session['qqinfo']) ? Yii::app()->session['qqinfo'] : false;
        $page = Yii::app()->request->getParam('page');
        $messages = array();
        if($msgtype=='1'){
            $messages = WebMessage::model()->getMessage(false,$page,5);
        }
        if($msgtype=='2'){
            $messages = WebMessage::model()->getMyMessage(false,$page,5,$openid);
        }
        $this->renderPartial('responsemsg',array('messages'=>$messages));
    }
    //QQ登录评论(包含文章评论，和网站留言)
    public function actionQQlogin(){
        $access_token = Yii::app()->request->getParam('accesstoken');
        $openid = Yii::app()->request->getParam('openid');
        $arcid = Yii::app()->request->getParam('arcid');
        $pid = Yii::app()->request->getParam('pid') ? Yii::app()->request->getParam('pid') : 0;
        $isprivate = Yii::app()->request->getParam('private') ? Yii::app()->request->getParam('private') : 0;
        $content = Yii::app()->request->getParam('content');
        if(empty($access_token) && empty($openid) && empty($content)){
            die('params invalid');
        }
        
        //由前端传access_token和openid
        $curl = "https://graph.qq.com/user/get_user_info?oauth_consumer_key=101340021&access_token={$access_token}&openid={$openid}&format=json";
        $_info = file_get_contents($curl);
        $info = (json_decode($_info,true));
        //文章评论
        if($arcid){
            //查询当前评论文章的作者
            $_writer = Archives::model()->findByPk($arcid,"isdeleted=0")->getAttributes(array('writer'));
            $writer = $_writer['writer'];
            if($info['ret']==0){
                $arc_model = new ArcMessage();
                $arc_model->pid = $pid;
                $arc_model->arcid = $arcid;
                $arc_model->uid = $writer;
                $arc_model->qqopenid = $openid;
                $arc_model->qqnickname  = $info['nickname'];
                $arc_model->sex  = $info['gender'];
                $arc_model->qqfigureurl = $info['figureurl_1'];
                $arc_model->content = htmlspecialchars(addslashes(Util::FilterWords($content)));
                $arc_model->userip = Yii::app()->request->getUserHostAddress();
                $arc_model->addtime = time();
                $rs = $arc_model->save();
                if($rs){
                    $newid = Yii::app()->db->getLastInsertID();
                    echo $newid;  
                }else{
                    echo 'fail';
                }
            }
        }else{
            //网站留言
            if($info['ret']==0){
                $arc_model = new WebMessage();
                $arc_model->pid = $pid;
                $arc_model->qqopenid = $openid;
                $arc_model->qqnickname  = $info['nickname'];
                $arc_model->isprivate  = $isprivate;
                $arc_model->sex  = $info['gender'];
                $arc_model->qqfigureurl = $info['figureurl_1'];
                $arc_model->content = htmlspecialchars(addslashes(Util::FilterWords($content)));
                $arc_model->userip = Yii::app()->request->getUserHostAddress();
                $arc_model->addtime = time();
                $rs = $arc_model->save();
                if($rs){
                    $newid = Yii::app()->db->getLastInsertID();
                    echo $newid;  
                }else{
                    echo 'fail';
                }
            }
        }
        
    }
    //登陆后保存session
    public function actionSetSession(){
        $openid = Yii::app()->request->getParam('openid');
        Yii::app()->session['qqinfo'] = $openid;
    }
    
    //退出QQ
    public function actionQQLogout(){
        Yii::app()->session->clear();
        Yii::app()->session->destroy();
        echo 'ok';
    }
    //搜索
    public function actionSearch(){
        $str = "[惊呆][可爱][憨笑][坏笑][无聊]sdfdsfdsl了哈啦啦啦啦啦";
        $_str = '';
        $_key = '';
        preg_match_all("/\[([\x{4e00}-\x{9fa5}])+\]/u", $str,$arr);
        $emotionurl = __HOMESRC__.'/emoubb/';
        if(!empty($arr)){
            foreach($arr[0] as $v){
                $_str .= str_replace($v, "<img src='".$emotionurl.$this->emotion[$v].".gif'>", $v);
                $_key .= $v;
            }
        }
        echo str_replace($_key, $_str, $str);
        die;
        $rs = $arr ? str_replace($arr[0], "<img src='".$emotionurl.$this->emotion[$arr[0]].".gif'>", $str) : $str;
        return $rs;
        
    }
    //表情ubb函数
    public function UbbEmotion($str){
        $_str = '';
        $_key = '';
        preg_match_all("/\[([\x{4e00}-\x{9fa5}])+\]/u", $str,$arr);
        $emotionurl = __HOMESRC__.'/emoubb/';
        if(!empty($arr)){
            foreach($arr[0] as $v){
                $_str .= str_replace($v, "<img src='".$emotionurl.$this->emotion[$v].".gif'>", $v);
                $_key .= $v;
            }
        }
        return str_replace($_key, $_str, $str);
    }
    //自定义时间格式
    public function TimeFormat($time){
        //1.三分钟之内   2.一小时之内    3.十二小时之内  4.
        $time_piece = time() - $time;
        switch ($time){
            case date('Y',$time) != date('Y',time()):
                return date('Y-m-d',$time);
                break;
            case $time_piece<60*3:
                return '刚刚';
                break;
            case $time_piece<60*60:
                return ceil($time_piece/60).'分钟前';
                break;
            case $time_piece<3600*12:
                return ceil($time_piece/3600).'小时前';
                break;
            case $time_piece<3600*24*30*12:
                return date('m-d',$time);
                break;
            default :
                return date('Y-m-d',$time);
        }
    }
}
