<?php

/* 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 */

/*
WeChat类用于微信各种调用
*/
class WeChat{
    private $_appid;
    private $_appsecret;
    private $_token;
    private $Tpl = array(
            'text'=>"<xml>
                                    <ToUserName><![CDATA[%s]]></ToUserName>
                                    <FromUserName><![CDATA[%s]]></FromUserName>
                                    <CreateTime>%s</CreateTime>
                                    <MsgType><![CDATA[%s]]></MsgType>
                                    <Content><![CDATA[%s]]></Content>
                                    <FuncFlag>0</FuncFlag>
                                    </xml>",
            'image'=>"<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Image>
                            <MediaId><![CDATA[%s]]></MediaId>
                            </Image>
                            </xml>"
    );

    public function __construct($_appid='wx2271dcf9b1ce6f7b', $_appsecret='26575fff53210665ccc34f34f747cecf', $_token='wechat'){
            $this->_appid = $_appid;
            $this->_appsecret = $_appsecret;
            $this->_token = $_token;
    }

    /*
    添加图片素材
    */
    public function _createImage($type,$file){
            $curl = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$this->_getAccessToken()."&type=".$type;
            $data['type'] = $type;
            $data['media'] = '@'.$file;
            $response = $this->_request($curl,true,'post',$data);
            echo $response;
            file_put_contents("./medialib",$response,FILE_APPEND);
    }
    /*
    位置信息的处理
    */
    private function _doLocation($postObj){
            $contentStr = "您所在的位置：经度：".$postObj->Location_Y." 纬度：".$postObj->Location_X;
            echo sprintf($this->Tpl['text'],$postObj->FromUserName,$postObj->ToUserName,time(),'text',$contentStr);
            }

    /*
    发送图片信息（$msg）到所有用户
    */
    public function _send2Users1(){
            $curl = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$this->_getAccessToken();
            $Tpl = '{
                    "touser":"%s",
                    "msgtype":"image",
                    "image":
                    {
                      "media_id":"x1jI1QXkcb-49_vJ2KAgzY8jdgn7neKZllGvai_obd_bgS0LgMqmjvocLwnMGsaI"
                    }
            }';
            $users = $this->_getUserList();
            for($i=0;$i<count($users);$i++){
                    $content = sprintf($Tpl,$users[$i]);
                    $this->_request($curl,true,'post',$content);
                    echo "已发送信息到".$users[$i]."<br />";
            }
    }

    /*
            按歌曲和歌手构建搜索的URL 
    */
    public function _searchUrl($song,$singer=''){
            if($singer == '')
                    $curl = "http://box.zhangmen.baidu.com/x?op=12&count=1&title=".$song."$$";
            else
                    $curl = "http://box.zhangmen.baidu.com/x?op=12&count=1&title=".$song."$$".$singer."$$$$";
            return $curl;
    }

    /*
            获取歌曲的地址URL
    */
    public function _getSongUrl($song,$singer){
            $curl = $this->_searchUrl($song,$singer);
            $content = $this->_request($curl,false);
            $content = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);
            $encode = $content->url->encode;
            $decode = $content->url->decode;
            //拼接URL
            return substr($encode,0,strrpos($encode,'/')+1).substr($decode,0,strrpos($decode,'&'));
    }

    /*
    发送歌曲到用户
    */
    public function _sendMusic($postObj){
            $str = mb_substr($postObj->Content,2,mb_strlen($postObj->Content,'UTF-8')-2,'UTF-8');
            $strarr = explode('@',$str);
            $song = $strarr[0];
            $singer = '';
            if(isset($strarr[1]))
                    $singer = $strarr[1];
            $musicUrl = $this->_getSongUrl($song,$singer);
            //以下是发送歌曲
            $str = '<xml>
<ToUserName><![CDATA['.$postObj->FromUserName.']]></ToUserName>
<FromUserName><![CDATA['.$postObj->ToUserName.']]></FromUserName>
<CreateTime>'.time().'</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
<Music>
<Title><![CDATA['.$song.']]></Title>
<Description><![CDATA['.$singer.']]></Description>
<MusicUrl><![CDATA['.$musicUrl.']]></MusicUrl>
<HQMusicUrl><![CDATA['.$musicUrl.']]></HQMusicUrl>
<ThumbMediaId><![CDATA[x1jI1QXkcb-49_vJ2KAgzY8jdgn7neKZllGvai_obd_bgS0LgMqmjvocLwnMGsaI]]></ThumbMediaId>
</Music>
</xml>';
    echo $str;
    exit();
    }
    //private function _request($curl, $https=true, $method='get', $data=null){
    public function _getMediaList(){
            $curl = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$this->_getAccessToken();
            $data='{"type":"image","offset":0,"count":5}';
            return $this->_request($curl,true,'post',$data);
    }
    /*
    发送信息（$msg）到所有用户
    */
    public function _send2Users($msg){
            $curl = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$this->_getAccessToken();
            $Tpl = '{
                    "touser":"%s",
                    "msgtype":"text",
                    "text":
                    {
                             "content":"%s"
                    }
            }';
            $users = $this->_getUserList();
            for($i=0;$i<count($users);$i++){
                    $content = sprintf($Tpl,$users[$i],$msg);
                    $this->_request($curl,true,'post',$content);
                    echo "已发送信息到".$users[$i]."<br />";
            }
    }
    /*
    获取用户列表
    */
    public function _getUserList(){
            $curl = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$this->_getAccessToken();
            $content = json_decode($this->_request($curl));
            return $content->data->openid;
    }
    /*
    菜单查询
    */
    public function _getMenu(){
            $curl = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".$this->_getAccessToken();
            $content = $this->_request($curl);
            echo $content;
    }
    /*
    创建菜单
    */
    public function _createMenu($data){
            $curl = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->_getAccessToken();
            $content = json_decode($this->_request($curl,true,'post',$data));
            if($content->errcode == 0){
                    echo "菜单创建成功！";
            }
    }

    /*
    删除菜单
    */
    public function _deleteMenu(){
            $curl = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$this->_getAccessToken();
            $content = json_decode($this->_request($curl));
            if($content->errcode == 0){
                    echo "删除菜单完成！"; 
            }
    }

    /*
    获取二维码
    */
    public function _getQRCode($expire_seconds=604800,$type='temp',$scene_id=8){
            $curl = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($this->_getTicket($expire_seconds,$type,$scene_id));
            return $this->_request($curl);
    }

    /*
    获取Ticket
    */
    public function _getTicket($expire_seconds=604800,$type='temp',$scene_id=8){
            $curl = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$this->_getAccessToken();
            if($type == 'temp'){ //获取临时二维码提交的数据
                    $data = '{"expire_seconds": '.$expire_seconds.', "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}';
            } else {//获取永久二维码提交的数据
                    $data = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';	
            }
            $content = $this->_request($curl,true,'post',$data);
            $content = json_decode($content);
            if(isset($content->errcode)){
                    return false;
            }
            $ticket = $content->ticket;
            return $ticket;		
    }

    /*
    发送请求
    */
    private function _request($curl, $https=true, $method='get', $data=null){
            $ch = curl_init();	
            curl_setopt($ch, CURLOPT_URL, $curl); //设置URL
            curl_setopt($ch, CURLOPT_HEADER, false);//不返回网页URL的头信息
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //不直接显示，返回一个字符串
            if($https){
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//服务器端的证书不验证
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//客户端证书不验证
            }
            if($method == 'post'){
                    curl_setopt($ch, CURLOPT_POST, true); //设置为POST提交方式
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//设置提交数据$data
            }
            $str = curl_exec($ch);//执行访问
            curl_close($ch);//关闭curl释放资源
            return $str;
    }

    /*
    获得Access token
    */
    public function _getAccessToken(){
            $file="./accesstoken";//指定保存access token的文件名
            if(file_exists($file)){
                    $content = file_get_contents($file); //读取json对象
                    $content = json_decode($content);//解析json
                    if(time() - filemtime($file) < $content->expires_in){ //判断文件是否是在有效期内
                            return $content->access_token;
                    }
            }
            $curl = ("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->_appid."&secret=".$this->_appsecret);//获取access token的url
            $content = $this->_request($curl); //发出请求
            file_put_contents($file, $content);//保存json
            $content = json_decode($content);//解码json对象
            $access_token = $content->access_token; //获得access token
            return $access_token;//返回access token
    }

    /*
            验证服务器，返回echostr中内容
    */
    public function valid()
{
    $echoStr = $_GET["echostr"];

    //valid signature , option
    if($this->checkSignature()){
            echo $echoStr;
            exit;
    }
}
    /*
    事件处理
    */
    private function _doEvent($postObj){
            if($postObj->Event == 'subscribe'){//关注公众号
                file_put_contents('./file.txt', $postObj->FromUserName.'\r\n'.$postObj->ToUserName);
                    $contentStr = "欢迎关注七秒钟的记忆个人公众号！";
                    $resultStr = sprintf($this->Tpl['text'], $postObj->FromUserName, $postObj->ToUserName, time(), 'text', $contentStr);
                    echo $resultStr;
                    /*
                            对用户数据处理：如保存到数据库。
                    */
            }
            if($postObj->Event == 'unsubscribe'){//取消关注公众号
                    $contentStr = "欢迎关注七秒钟的记忆个人公众号，等你回来！";
                    $resultStr = sprintf($this->Tpl['text'], $postObj->FromUserName, $postObj->ToUserName, time(), 'text', $contentStr);
                    echo $resultStr;
                    /*
                    主要用于企业服务器后台处理：如删该用户在服务器上数据。
                    */
            }
            if($postObj->Event == 'CLICK' && $postObj->EventKey == 'sportnews'){
                    $itemList = '<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[news]]></MsgType>
                            <ArticleCount>3</ArticleCount>
                            <Articles>
                            %s
                            </Articles>
                            </xml>';
                    $item = '
                            <item>
                            <Title><![CDATA[%s]]></Title> 
                            <Description><![CDATA[%s]]></Description>
                            <PicUrl><![CDATA[%s]]></PicUrl>
                            <Url><![CDATA[%s]]></Url>
                            </item>';
                    $contents=array(
                    array(
                            'title'=>'残酷!已6个小组第2积分超国足 要出线还得算好数',
                            'desc'=>'一场所有人都明白“输不起”的比赛，国足最终还是输了。在10月9日凌晨客场0-1负于卡塔尔后，中国队争夺小组头名从而稳获出线权的可能性已微乎其微，力争成为“4个成绩最好的小组第2”已成为中国队谋求进入12强的线索，但转换奋斗目标的国足在那条战线上也已处于被动局面了。',
                            'picurl'=>'http://k.sinaimg.cn/n/transform/20151009/WNN0-fxirmpz8166686.jpg/w570081.jpg','url'=>'http://sports.sina.com.cn/china/national/2015-10-09/doc-ifxirmpy1398354.shtml'
                    ),
                    array(
                            'title'=>'残酷!已6个小组第2积分超国足 要出线还得算好数',
                            'desc'=>'一场所有人都明白“输不起”的比赛，国足最终还是输了。在10月9日凌晨客场0-1负于卡塔尔后，中国队争夺小组头名从而稳获出线权的可能性已微乎其微，力争成为“4个成绩最好的小组第2”已成为中国队谋求进入12强的线索，但转换奋斗目标的国足在那条战线上也已处于被动局面了。',
                            'picurl'=>'http://k.sinaimg.cn/n/transform/20151009/WNN0-fxirmpz8166686.jpg/w570081.jpg','url'=>'http://sports.sina.com.cn/china/national/2015-10-09/doc-ifxirmpy1398354.shtml
                    '),	
                    array(
                            'title'=>'残酷!已6个小组第2积分超国足 要出线还得算好数',
                            'desc'=>'一场所有人都明白“输不起”的比赛，国足最终还是输了。在10月9日凌晨客场0-1负于卡塔尔后，中国队争夺小组头名从而稳获出线权的可能性已微乎其微，力争成为“4个成绩最好的小组第2”已成为中国队谋求进入12强的线索，但转换奋斗目标的国足在那条战线上也已处于被动局面了。',
                            'picurl'=>'http://k.sinaimg.cn/n/transform/20151009/WNN0-fxirmpz8166686.jpg/w570081.jpg','url'=>'http://sports.sina.com.cn/china/national/2015-10-09/doc-ifxirmpy1398354.shtml')
                    );
                    foreach($contents as $c){
                            $itemcontent.=sprintf($item,$c['title'],$c['desc'],$c['picurl'],$c['url']);
                    }
                    echo sprintf($itemList,$postObj->FromUserName,$postObj->ToUserName,time(),$itemcontent);
            }
    }

public function responseMsg()
{
            //get post data, May be due to the different environments
            $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

    //extract post data
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            switch($postObj->MsgType){
                    case 'event':
                            $this->_doEvent($postObj);
                            break;
                    case 'text':
                            $this->_doText($postObj);
                            break;
                    case 'image':
                            $this->_doImage($postObj);
                            break;
                    case 'location':
                            $this->_doLocation($postObj);
                            break;
                    default:;
            }
    }
    //上传素材
    public function _upLoadMedia(){

    }

    private function _doImage($postObj){
            $contentStr = "您发送的图片地址：".$postObj->PicUrl;
            $str = sprintf($this->Tpl['text'],$postObj->FromUserName,$postObj->ToUserName,time(),'text',$contentStr);
            echo $str;//file_put_contents('./'.$postObj->MediaID.'.jpg',$this->_request($postObj->PicUrl));//建议保存用户上传的图片到企业服务器
    }

    private function _doText($postObj){
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            if($postObj->Content=='新闻'){

                    $itemList = '<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[news]]></MsgType>
                            <ArticleCount>2</ArticleCount>
                            <Articles>
                            %s
                            </Articles>
                            </xml>';
                    $item = '
                            <item>
                            <Title><![CDATA[%s]]></Title> 
                            <Description><![CDATA[%s]]></Description>
                            <PicUrl><![CDATA[%s]]></PicUrl>
                            <Url><![CDATA[%s]]></Url>
                            </item>';
                    $contents=array(
                    array(
                            'title'=>' ',
                            'desc'=>'添加大侠老师个人微信，实现一对一的专业辅导（适合新手）',
                            'picurl'=>'http://www.cmsvi.com/1.png','url'=>'http://sports.sina.com.cn/china/national/2015-10-09/doc-ifxirmpy1398354.shtml'
                    ),
                    array(
                            'title'=>'添加大侠老师个人微信，实现一对一的专业辅导（适合新手）',
                            'desc'=>'一场所有人都明白“输不起”的比赛，国足最终还是输了。在10月9日凌晨客场0-1负于卡塔尔后，中国队争夺小组头名从而稳获出线权的可能性已微乎其微，力争成为“4个成绩最好的小组第2”已成为中国队谋求进入12强的线索，但转换奋斗目标的国足在那条战线上也已处于被动局面了。',
                            'picurl'=>'http://k.sinaimg.cn/n/transform/20151009/WNN0-fxirmpz8166686.jpg/w570081.jpg','url'=>'http://sports.sina.com.cn/china/national/2015-10-09/doc-ifxirmpy1398354.shtml')
                    );
                    foreach($contents as $c){
                            $itemcontent.=sprintf($item,$c['title'],$c['desc'],$c['picurl'],$c['url']);
                    }
                    echo sprintf($itemList,$postObj->FromUserName,$postObj->ToUserName,time(),$itemcontent);
            }
            if($postObj->Content=='报名'){

                    $contentStr = '报名二维码';
                    $time = time();    
                    $resultStr = sprintf($this->Tpl['text'], $fromUsername, $toUsername, $time, 'text', $contentStr);

                    $media_id = 'KYBF0Xx_Yg-9w_09V21HYbyUKRoWJnE0s4-b8rB_OYQmmRwKq5I9ucaz632pJ0KM';
                    $str = sprintf($this->Tpl['image'],$postObj->FromUserName,$postObj->ToUserName,time(),'image',$media_id);
                    file_put_contents('./tmp.txt',$str);
                    echo $resultStr;echo $str;
                    // die;
            }		
            if($postObj->Content=='报名'){

                    $media_id = 'KYBF0Xx_Yg-9w_09V21HYbyUKRoWJnE0s4-b8rB_OYQmmRwKq5I9ucaz632pJ0KM';
                    $str = sprintf($this->Tpl['image'],$postObj->FromUserName,$postObj->ToUserName,time(),'image',$media_id);
                    file_put_contents('./tmp.txt',$str);
                    echo $str;
                    die;
            }
            //判断是否是搜索歌曲
            if(mb_substr($postObj->Content,0,2,'UTF-8')=='歌曲'){
                    $this->_sendMusic($postObj);
            }

            switch($postObj->Content){
                    case '报名':
                            $contentStr = '报名二维码';
                            break;
                    case 'java':
                            $contentStr = '比PHP稍弱的编程语言！';
                            break;
                    default:
                            $contentStr = 'http://www.baidu.com';
            }

            $time = time();    
            $resultStr = sprintf($this->Tpl['text'], $fromUsername, $toUsername, $time, 'text', $contentStr);

            //file_put_contents('./tmp.txt',$resultStr);
            echo $resultStr;
}

    /*
            检查签名
    */
    private function checkSignature()
    {
    $signature = $_GET["signature"];
    $timestamp = $_GET["timestamp"];
    $nonce = $_GET["nonce"];
            $token = $this->_token;
            $tmpArr = array($token, $timestamp, $nonce);
    sort($tmpArr, SORT_STRING);
            $tmpStr = implode( $tmpArr );
            $tmpStr = sha1( $tmpStr );

            if( $tmpStr == $signature ){
                    return true;
            } else {
                    return false;
            }
    }
}