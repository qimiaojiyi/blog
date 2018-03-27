<!DOCTYPE HTML>
<html lang="zh-cn">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
<title>奇妙记忆</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<!--<link rel="apple-touch-icon" href="//qzonestyle.gtimg.cn/qzone/v8/index/touch-icon-ipad-retina.png">
<link rel="apple-touch-icon" sizes="76x76" href="//qzonestyle.gtimg.cn/qzone/v8/index/touch-icon-ipad.png">
<link rel="apple-touch-icon" sizes="120x120" href="//qzonestyle.gtimg.cn/qzone/v8/index/touch-icon-iphone-retina.png">
<link rel="apple-touch-icon" sizes="152x152" href="//qzonestyle.gtimg.cn/qzone/v8/index/touch-icon-ipad-retina.png">
<link rel="icon" sizes="any" mask href="//qzonestyle.gtimg.cn/qzone/v8/img/Qzone.svg">
<meta name="theme-color" content="#FFC028">-->
<!--[if IE]><base href="//qzs.qq.com/"></base><![endif]-->
<!--[if !(IE)]><!--><base href="//qzs.qq.com/" /><!--<![endif]-->
<!--[if IE]>
<script type="text/javascript">
    function toAbsURL(s) { 
     var l = location, h, p, f, i; 
     if (/^\w+:/.test(s)) { 
       return s; 
     } 
     h = l.protocol + '//' + l.host + (l.port!=''?(':' + l.port):''); 
     if (s.indexOf('/') == 0) { 
       return h + s; 
     } 
     p = l.pathname.replace(/\/[^\/]*$/, ''); 
     f = s.match(/\.\.\//g); 
     if (f) { 
       s = s.substring(f.length * 3); 
       for (i = f.length; i--;) { 
         p = p.substring(0, p.lastIndexOf('/')); 
       } 
     } 
     return h + p + '/' + s; 
   }
    var base = document.getElementsByTagName('base')[0];
    base.href = toAbsURL(base.href);
</script>
<![endif]-->
<style>
    *{
        padding: 0;
        margin: 0;
    }
    body{
        background: #eeeeee;
        font-family: 微软雅黑;
    }
    .tool_bar li{
        list-style: none;
        float: left;
    }
    .clearfloat{
        clear:both;
    }
    .input_bar,.tool_bar{
        color:#ffffff;
        background: #40a9e5;
        width: 100%;
        height: 2.5rem;
    }
    .tool_bar li{
        height: 100%;
        line-height: 2.5rem;
        text-align: center;
        /*background: #ffffff;*/
    }
    .input_textarea{
        /*margin-top:0.7rem;*/ 
    }
    .input_textarea textArea{
        font-size: 1rem;
        border:none;
        background: #ffffff;
        width: 100%;
        min-height: 8rem;
        padding: 1rem;
        box-sizing:border-box;  
        -moz-box-sizing:border-box; /* Firefox */  
        -webkit-box-sizing:border-box; /* Safari */  
    }
    .setposition{
        padding-left: 1rem;
        margin-top: .2rem;
        background: #ffffff;
        height:2.5rem;
        line-height: 2.5rem;
    }
    .pictures{
        padding: 1rem;
        background: #fff;
        height: 100%;
        line-height: 4.5rem;
    }
    .pictures ul li{
        list-style: none;
        float: left;
        margin:0 .3rem .3rem 0; 
        height: 5rem;
        width:5rem;
    }
    /*图片上传插件*/
    #imageform{width:90px;}
    #img{display: none;}
    #thumbs{
        width: 100%;
        height: 100%;
        background: url(https://www.qimiaojiyi.com/assets/home/img/camera.png) center center no-repeat;
    }
    .previewwrap{
        display: none;
        z-index: 9999;
        background: #343535;
        position: absolute;
    }
</style>
<script src="https://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>
<script src="https://www.qimiaojiyi.com/assets/home/js/jquery-1.7.2.js"></script>
<script src="https://www.qimiaojiyi.com/assets/home/js/exif.js"></script>
<script src="https://www.qimiaojiyi.com/assets/home/js/jquery.wallform.js"></script>
</head>
<body>
<!--    <div class="previewwrap">
        <img src="" id="imgpreview">
    </div>-->
    <div class="wrap">
        <ul class="tool_bar">
            <li style="width:20%;cursor:pointer;" id="cancle">取消</li>
            <li style="width:60%;">编辑长文本</li>
            <li style="width:20%;cursor:pointer;" id="submit">确定</li>
        </ul>
        <div class="input_textarea">
            <textarea name="content" placeholder="写点什么吧"></textarea>
        </div>
        <div class="pictures">
            <ul>
                <li>
                    <form id="imageform" method="post" enctype="multipart/form-data" action="https://www.qimiaojiyi.com/note/Uploadimg">
                        <input id="img" type="file" name="photoimg">
                        <input type="hidden" name="imgsrc">
                    </form>
                    <canvas id="thumbs"></canvas>
                    <canvas id="canvas-clip" style="display:none;"></canvas>
                </li>
            </ul>
            <div class="clearfloat"></div>
        </div>
        <div class="clearfloat"></div>
        <div class="setposition" onclick="geolocation.getLocation(showPosition, showErr, options)" id="location" lat="" lng="">显示位置</div>
    </div>
    <script>
        $(function(){
//            $('.previewwrap').css({
//                'width':$(window).width()+'px',
//                'height':$(window).height()+'px'
//            });
            geolocation.getLocation(showPosition, showErr, options);
        });
        $('#submit').click(function(){
            var url = 'https://www.qimiaojiyi.com/note/save';
            var content = $('textarea[name=content]').val();
            var address = $('#location').text();
            var lat = $('#location').attr('lat');
            var lng = $('#location').attr('lng');
            var adcode = $('#location').attr('adcode');
            var imgsrc = $('input[name=imgsrc]').val();
            var data = {'content':content,'imgsrc':imgsrc,'address':address,'lat':lat,'lng':lng,'adcode':adcode};
            $.post(url,data,function(rs){
                if(rs=='ok'){
                    window.location.href = 'https://www.qimiaojiyi.com/note/add';
                }else{
                    alert('内容不能为空，请重试');
                }
            });
        });
    </script>
    <!--腾讯地图定位-->
    <script>
        var geolocation = new qq.maps.Geolocation("OB4BZ-D4W3U-B7VVO-4PJWW-6TKDJ-WPB77", "myapp");
        var positionNum = 0;
        var options = {timeout: 8000};
        function showPosition(position) {
            var data = JSON.stringify(position, null, 4);
            eval('var position='+data);
            //console.log(position);
            $('#location').attr('lat',position.lat);
            $('#location').attr('lng',position.lng);
            $('#location').html(position.addr ? position.addr : position.city);
        };
        function showErr() {
            positionNum ++;
            document.getElementById("demo").innerHTML += "序号：" + positionNum;
            document.getElementById("demo").appendChild(document.createElement('p')).innerHTML = "定位失败！";
            document.getElementById("pos-area").scrollTop = document.getElementById("pos-area").scrollHeight;
        };
 
    </script>
    <script type="text/javascript">
        var thumbico = $('#thumbs');
        thumbico.click(function(){
//                if(thumbico.attr('width')>0){
//                    previewsrc = $('input[name=imgsrc]').val();
//                    $('.previewwrap').css('display','block');
//                    $('#imgpreview').attr('src','http://www.qimiaojiyi.com/'+previewsrc);
//                }else{
                    $("#img").trigger('click');
//                }
        });
        var fileEle = document.getElementById('img');
        fileEle.onchange = function() {
          if (!this.files.length) return;

          //以下考虑的是单图情况
          var _ua = window.navigator.userAgent;
          var _simpleFile = this.files[0];

          //判断是否为图片
          if (!/\/(?:jpeg|png|gif)/i.test(_simpleFile.type)) return;

          //插件exif.js获取ios图片的方向信息
          var _orientation;
          if(_ua.indexOf('iphone') > 0) {
            EXIF.getData(_simpleFile,function(){
              _orientation=EXIF.getTag(this,'Orientation');
            });
          }

          //1.读取文件，通过FileReader，将图片文件转化为DataURL，即data:img/png;base64，开头的url，可以直接放在image.src中;
          var _reader = new FileReader(),
            _img = new Image(),
            _url;

            _reader.onload = function() {
            _url = this.result;
            _img.src = _url;
            _img.onload = function () {
                thumbs(70,56,_img);
                var _data = compress(_img);
                uploadPhoto(_data, _orientation);
            };
          };

          _reader.readAsDataURL(_simpleFile);
        };
        //剪裁缩略图
        function thumbs(w,h,_img){
            //2.计算符合目标尺寸宽高值，若上传图片的宽高都大于目标图，对目标图等比压缩；如果有一边小于，对上传图片等比放大。
            var _goalWidth = w,         //目标宽度
            _goalHeight = h,         //目标高度
            _imgWidth = _img.naturalWidth,   //图片宽度
            _imgHeight = _img.naturalHeight,  //图片高度
            _tempWidth = _imgWidth,      //放大或缩小后的临时宽度
            _tempHeight = _imgHeight,     //放大或缩小后的临时宽度
            _r = 0;              //压缩比

            if(_imgWidth === _goalWidth && _imgHeight === _goalHeight) {
            } else if(_imgWidth > _goalWidth && _imgHeight > _goalHeight) {//宽高都大于目标图，需等比压缩
                _r = _imgWidth / _goalWidth;
                if(_imgHeight / _goalHeight < _r) {
                    _r = _imgHeight / _goalHeight;
                }
                _tempWidth = Math.ceil(_imgWidth / _r);
                _tempHeight = Math.ceil(_imgHeight / _r);
            } else {
                if(_imgWidth < _goalWidth && _imgHeight < _goalHeight) {//宽高都小于
                    _r = _goalWidth / _imgWidth;
                    if(_goalHeight / _imgHeight < _r) {
                      _r = _goalHeight / _imgHeight;
                    }
                } else {
                    if(_imgWidth < _goalWidth) {     //宽小于
                      _r = _goalWidth / _imgWidth;
                    } else{               //高小于
                      _r = _goalHeight / _imgHeight;
                    }
                }
                _tempWidth = Math.ceil(_imgWidth * _r);
                _tempHeight = Math.ceil(_imgHeight * _r);
            }

            //3.利用canvas对图片进行裁剪，等比放大或缩小后进行居中裁剪
            var _canvas = document.getElementById("thumbs");
            if(!_canvas.getContext) return;
            var _context = _canvas.getContext('2d');
            _canvas.width = _tempWidth;
            _canvas.height = _tempHeight;
            var _degree;

            if(window.navigator.userAgent.indexOf('iphone') > 0 && !!_degree) {
                _context.rotate(_degree*Math.PI/180);
                _context.drawImage(_img, 0, 0, _tempWidth, _tempHeight); 
            } else {
                _context.drawImage(_img, 0, 0, _tempWidth, _tempHeight);
            }
        }
        /**
         * 计算图片的尺寸，根据尺寸压缩
         * 1. iphone手机html5上传图片方向问题，借助exif.js
         * 2. 安卓UC浏览器不支持 new Blob()，使用BlobBuilder
         * @param {Object} _img     图片
         * @param {Number} _orientation 照片信息
         * @return {String}       压缩后base64格式的图片
         */
        function compress(_img, _orientation) {
          //2.计算符合目标尺寸宽高值，若上传图片的宽高都大于目标图，对目标图等比压缩；如果有一边小于，对上传图片等比放大。
          var _goalWidth = 800,         //目标宽度
            _goalHeight = 800,         //目标高度
            _imgWidth = _img.naturalWidth,   //图片宽度
            _imgHeight = _img.naturalHeight,  //图片高度
            _tempWidth = _imgWidth,      //放大或缩小后的临时宽度
            _tempHeight = _imgHeight,     //放大或缩小后的临时宽度
            _r = 0;              //压缩比

          if(_imgWidth === _goalWidth && _imgHeight === _goalHeight) {

          } else if(_imgWidth > _goalWidth && _imgHeight > _goalHeight) {//宽高都大于目标图，需等比压缩
            _r = _imgWidth / _goalWidth;
            if(_imgHeight / _goalHeight < _r) {
              _r = _imgHeight / _goalHeight;
            }
            _tempWidth = Math.ceil(_imgWidth / _r);
            _tempHeight = Math.ceil(_imgHeight / _r);
          } else {
            if(_imgWidth < _goalWidth && _imgHeight < _goalHeight) {//宽高都小于
              _r = _goalWidth / _imgWidth;
              if(_goalHeight / _imgHeight < _r) {
                _r = _goalHeight / _imgHeight;
              }
            } else {
              if(_imgWidth < _goalWidth) {     //宽小于
                _r = _goalWidth / _imgWidth;
              } else{               //高小于
                _r = _goalHeight / _imgHeight;
              }
            }

            _tempWidth = Math.ceil(_imgWidth * _r);
            _tempHeight = Math.ceil(_imgHeight * _r);
          }

          //3.利用canvas对图片进行裁剪，等比放大或缩小后进行居中裁剪
          var _canvas = document.getElementById("canvas-clip");
          if(!_canvas.getContext) return;
          var _context = _canvas.getContext('2d');
          _canvas.width = _tempWidth;
          _canvas.height = _tempHeight;
          var _degree;

          //ios bug，iphone手机上可能会遇到图片方向错误问题
          switch(_orientation){
            //iphone横屏拍摄，此时home键在左侧
            case 3:
              _degree=180;
              _tempWidth=-_imgWidth;
              _tempHeight=-_imgHeight;
              break;
            //iphone竖屏拍摄，此时home键在下方(正常拿手机的方向)
            case 6:
              _canvas.width=_imgHeight;
              _canvas.height=_imgWidth; 
              _degree=90;
              _tempWidth=_imgWidth;
              _tempHeight=-_imgHeight;
              break;
            //iphone竖屏拍摄，此时home键在上方
            case 8:
              _canvas.width=_imgHeight;
              _canvas.height=_imgWidth; 
              _degree=270;
              _tempWidth=-_imgWidth;
              _tempHeight=_imgHeight;
              break;
          }
          if(window.navigator.userAgent.indexOf('iphone') > 0 && !!_degree) {
            _context.rotate(_degree*Math.PI/180);
            _context.drawImage(_img, 0, 0, _tempWidth, _tempHeight); 
          } else {
            _context.drawImage(_img, 0, 0, _tempWidth, _tempHeight);
          }
          //toDataURL方法，可以获取格式为"data:image/png;base64,***"的base64图片信息；
          var _data = _canvas.toDataURL('image/jpeg');
          return _data;
        }

        /**
         * 上传图片到NOS
         * @param {Object} _blog Blob格式的图片
         * @return {Void}
         */
        function uploadPhoto(_data) {
            $.post('https://www.qimiaojiyi.com/note/uploadimg',{'BASE64_STR':_data},function(rs){
                $('input[name=imgsrc]').val(rs);
            });
        }
    </script>
</body>
</html>
