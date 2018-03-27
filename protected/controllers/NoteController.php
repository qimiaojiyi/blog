<?php

/* 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 */

class NoteController extends Controller{
    public function weekMark($day){
        $arr = array(
            '0'=>'星期天',
            '1'=>'星期一',
            '2'=>'星期二',
            '3'=>'星期三',
            '4'=>'星期四',
            '5'=>'星期五',
            '6'=>'星期六',
        );
        return $arr[$day];
    }
    public function actionIndex(){
        $writer = 10001;
        $notes = Note::model()->getNotes($writer);
        $this->renderPartial('index',array('notes'=>$notes));
    }
    public function actionAdd(){
        $this->renderPartial('note_add');
    }
    //ajax保存note内容
    public function actionSave(){
        if(empty($_POST['content'])){
            die();
        }
        $userid = 10001;
        
        $note_model = new Note();
        
        $imgsrc = Yii::app()->request->getParam('imgsrc');
        if(!empty($imgsrc)){
            $imgext = substr($imgsrc,strrpos($imgsrc,'.')+1);
            //移动图片到永久保存文件夹相对路径
            $imgdst = 'uploads/notes/'.substr(md5($userid),-15).'/'. date("Ymd").'/';
            if(!is_dir(dirname(Yii::app()->basePath).'/'.$imgdst)){
                mkdir(dirname(Yii::app()->basePath).'/'.$imgdst, 0777 ,true);
            }
            //最终保存图片的名称
            $dstname = $imgdst.uniqid().'.'.$imgext;
            rename(dirname(Yii::app()->basePath).$imgsrc, dirname(Yii::app()->basePath).'/'.$dstname);
            $_POST['img'] = $dstname;
        }
        
        foreach($_POST as $k=>$v){
            if($note_model->hasAttribute($k)){
                $note_model[$k] = $v;
            }
        }
        
        $note_model->time = time();
        $note_model->week = date('w');
        $rs = $note_model->save();
        if($rs>0){
            echo 'ok';
        }
    }
    //处理上传图片
    public function actionUploadimgbak(){
        //用户名
        $userid = 10001;
        if(isset($_POST['BASE64_STR'])){
            $base64_str = $_POST['BASE64_STR'];
            $path = dirname(Yii::app()->basePath)."/uploads/notes/".substr(md5($userid),-15).'/'. date("Ymd").'/';
            if(!is_dir($path)){
                mkdir($path, 0777 ,true);
            }
            $base64_body = substr(strstr($base64_str,','),1);
            $img = base64_decode($base64_body);
            //图片start  
            list($type, $data) = explode(',', $base64_str);  
            // 判断类型  并设置图片的后缀名  
            if(strstr($type,'image/jpeg')!==''){  
                $ext = '.jpg';  
            }elseif(strstr($type,'image/gif')!==''){  
                $ext = '.gif';  
            }elseif(strstr($type,'image/png')!==''){  
                $ext = '.png';  
            }
            $img_name = uniqid();
            $rs = file_put_contents($path.$img_name.$ext, $img);
            if($rs){
                echo str_replace(dirname(Yii::app()->basePath), '', $path.$img_name.$ext);
            }
        }
    }
    public function actionUploadimg(){
        if(isset($_POST['BASE64_STR'])){
            $base64_str = $_POST['BASE64_STR'];
            $path = dirname(Yii::app()->basePath)."/uploads/temp/";
            if(!is_dir($path)){
                mkdir($path, 0777 ,true);
            }
            $base64_body = substr(strstr($base64_str,','),1);
            $img = base64_decode($base64_body);
            //图片start  
            list($type, $data) = explode(',', $base64_str);  
            // 判断类型  并设置图片的后缀名  
            if(strstr($type,'image/jpeg')!==''){  
                $ext = '.jpg';  
            }elseif(strstr($type,'image/gif')!==''){  
                $ext = '.gif';  
            }elseif(strstr($type,'image/png')!==''){  
                $ext = '.png';  
            }
            $img_name = uniqid();
            $rs = file_put_contents($path.$img_name.$ext, $img);
            if($rs){
                
                echo str_replace(dirname(Yii::app()->basePath), '', $path.$img_name.$ext);
            }
        }
    }
    private function extend($file_name){
	$extend = pathinfo($file_name);
	$extend = strtolower($extend["extension"]);
	return $extend;
    }
    public function actiontest(){
        $str = 'data:image/jpg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wgARCAA5AEEDASIAAhEBAxEB/8QAGgAAAQUBAAAAAAAAAAAAAAAAAwABAgQFBv/EABkBAAMBAQEAAAAAAAAAAAAAAAEDBAIFAP/aAAwDAQACEAMQAAABzYEgcjhYt4fmLXGujMRQNjmmRxeZ3InZDopdJVNSoU+f7vmeRTiIi6cRZNMixezZK5exe5nqc3m5fY5qS8SkulMZ5ogUSC9k5c4SdlKCy0uiLw//xAAkEAABBAIABQUAAAAAAAAAAAABAAIDEQQQBRITFCAhIiQwMv/aAAgBAQABBQL6w2yI2jRaCns5fCl+VG10ju3YEcRwXZkqWIxSaGoPZhrDcTriA+QrQ1jyNA7WRQNbGFlu551SpA69SYoxFHk5AibqlWrpRT9J7+ISuV2Qq8CjoJuv/8QAIhEAAgEEAgEFAAAAAAAAAAAAAQIAAwQQERIxBRMhIkFC/9oACAEDAQE/AZSoNU6hsT9GMhQ6bBlnf6okN2JS8jVL6aXJ5DZywNJ5ZL6jctdSu35yVDexifBeK5//xAAfEQACAQMFAQAAAAAAAAAAAAABAgADBBAREhMhUTP/2gAIAQIBAT8BjOFnNAdcinyOB7LmxC0iyHsSzrMz7TntTqJe3z8ez2WNI/Q50hoUydxGf//EACcQAAECAwgBBQAAAAAAAAAAAAEAAhESIAMQITEyQVFhMAQiQoGC/9oACAEBAAY/AvJzdkuqpWiJUHeoaD0FqBByIWpFh2ptHDUXS/Vz7PaEbvzS6ytNDt+CvbK4cgpwDg5/yIyFx6wqlGZQYFAa65pJjtioNg1Y+T//xAAjEAEAAgIBBAEFAAAAAAAAAAABABEQITFBUWFxIIGRocHh/9oACAEBAAE/IYx+JhJUWonTbecc+PcffmBlxMQofmC7z0nvqiIfWVr5EBiGkU+JyGKVLi3HZUvxZX7UvFhdr4ZU0k6j9ysFuXFlr+qi76EtRvy19gYOnxCoQRRrAC2rQTpOcvdi5rXB2i3vBiqWg7+hXBUJoHxzLIpV6sF4kY5H4H//2gAMAwEAAgADAAAAEFgOxv5hLe8SV+aPctVaD//EAB8RAQACAgICAwAAAAAAAAAAAAEAERAhMWFRwXHR8P/aAAgBAwEBPxCb/Q8sp6V+K+41KnCoWc7N52L6fUJUU9RD5DCWVPztkKlQ7XvqClMlU2RvEmf/xAAdEQEAAgIDAQEAAAAAAAAAAAABABEhMRBR0UFh/9oACAECAQE/EJuNwF5IBs5cV2j5qLz9iFcJKlQR7CO1j06hlDGj3iohwzMw/vmoY4//xAAlEAEAAgEEAgIBBQAAAAAAAAABABEhEDFBUXGRYaEggbHB0eH/2gAIAQEAAT8QdtRG4YNHaKVECZT3KXiEinsF/UqijB8QdzOmH3MObeevMyaBdFo4ftFF7UfuvBF1G4QTpEro5Y/YiWtKR/3EEulfZuPrTWGk+YBFsxKSJTvkKfnS8Cqo8CZPNysAE3D5sfxLy0cDCwJE4VUJdG1OuGWy7zbp3lxKQAI2O9Xl5f00uFYhfG/2spLJRKltuJcCdAJyspoa+Q3YKceDj2xmpVcq8ytJoRh2zZ0xGYFZQnd2eI3ROc/Z/qXytalqxh+A5am78L//2Q==';
        $base64_body = substr(strstr($str,','),1);
        $img = base64_decode($base64_body);
        //图片start  
        list($type, $data) = explode(',', $str);  
        // 判断类型  并设置图片的后缀名  
        if(strstr($type,'image/jpeg')!==''){  
            $ext = '.jpg';  
        }elseif(strstr($type,'image/gif')!==''){  
            $ext = '.gif';  
        }elseif(strstr($type,'image/png')!==''){  
            $ext = '.png';  
        }  
        file_put_contents('/usr/local/http2/htdocs/blog/uploads/test'.$ext, $img);
        die;
        $this->renderPartial('uploadimg');
    }
}
