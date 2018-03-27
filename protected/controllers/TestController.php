<?php
class TestController extends Controller{
    public function curl_get($url)
    {
        static $obj = NULL;
        if($obj === NULL)
            // 创建对象
            $obj = curl_init();
        // 配置对象
        curl_setopt($obj, CURLOPT_URL, $url);
        // 获取返回值
        curl_setopt($obj, CURLOPT_RETURNTRANSFER, 1);
        // 执行请求
        $str = curl_exec($obj);
        return $str;
    }

    public function httpGet($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);    //表示需要response header
        curl_setopt($ch, CURLOPT_NOBODY, FALSE); //表示需要response body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        
        $result = curl_exec($ch);
        
        return curl_getinfo($ch, CURLINFO_HTTP_CODE);      
    }
    public function actiongethtml(){
        $url = "http://www.3dxy.com";
        $html = UrlRequest::request($url);
        $preg = '/<!--indexModelCont-->(.*?)<!--indexModelCont-->/';
        $html = preg_match_all($preg, $html,$rs);
        $preg1 = '/<a href="(\/3dmodel\/.*?)".*?>.*?<\/a>/';
        $html = preg_match_all($preg1, $rs[0][0], $matches);

        $model = new SaveHttp();

        $rs_index = $this->httpGet('http://www.3dxy.com');
        if($rs_index != 200){
        	$model->id = null;
            $model->url = 'http://www.3dxy.com';
            $model->code = $rs_index;
            $model->time = date("Y-m-d H:i:s");
            $model->save();
        }
        foreach($matches[1] as $k=>$v){
            $rs = $this->httpGet('http://www.3dxy.com'.$v);
            if($rs != 200){
                $model->isNewRecord=true;
                $model->id = null;
                $model->url = 'http://www.3dxy.com'.$v;
                $model->code = $rs;
                $model->time = date("Y-m-d H:i:s");
                $model->save();
            }
        }
    }
    public function actionImg(){
            $data = ArcMessage::model()->findBySql('SELECT * FROM {{arcmessage}} where isdeleted!=0');
        //$sql = "count(*) from {{ArcMessage}}";
//        $rs = $data->findAll(array(
//            'condition'=>'isdeleted!=0',
//        ));
        var_dump($data);
//        $data = serialize($_FILES);
//        file_put_contents('/usr/local/http2/htdocs/blog/file.txt', $data);
    }
    public function actionCut(){
        $imgsrc = './a.png';
        $x = 10;
        $y = 10;
        $w = 100;
        $h = 100;
        Util::CutImg($imgsrc, $x, $y, $w, $h);
        //echo Util::CreateFrom($imgsrc);
    }
    public function actionInitdb(){
        $dbhost='localhost';
        $dbuser='root';
        $dbpwd='root';
        $conn = mysqli_connect($dbhost,$dbuser,$dbpwd) or die('DB connect failed!');
        
//        $command = 'create database oacms charset utf8;';
//        mysqli_query($conn,$command);
//        die;
        $dbprefix='';
        $query = '';
        $mysqlVersion=4.0;
        $fp = fopen('data/sql-dftables.txt','r');
        while(!feof($fp))
        {
            $line = rtrim(fgets($fp,10));
            if(preg_match("#;$#", $line))
            {
                $query .= $line."\n";
                $query = str_replace('#@__',$dbprefix,$query);
                if($mysqlVersion < 4.1)
                {
                    $rs = mysqli_query($conn,$query);
                } else {
                    if(preg_match('#CREATE#i', $query))
                    {
                        $rs = mysqli_query($conn,preg_replace("#TYPE=MyISAM#i",$sql4tmp,$query));
                    }
                    else
                    {
                        $rs = mysqli_query($conn,$query);
                    }
                }
                $query='';
            } else if(!preg_match("#^(\/\/|--)#", $line))
            {
                $query .= $line;
            }
        }
        fclose($fp);
    }
}

