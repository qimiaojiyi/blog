<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>无标题js文档</title>

</head>
<body>
<input type='file' id='img'>
<canvas id="canvas-clip" width="200" height="100"></canvas>
</body>
</html>
<script type="text/javascript">
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
    //console.log(_url);
    _img.onload = function () {

      var _data = compress(_img);
      uploadPhoto(_data, _orientation);
    };
  };
 
  _reader.readAsDataURL(_simpleFile);
};

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
  var _goalWidth = 150,         //目标宽度
    _goalHeight = 150,         //目标高度
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
  //4.获取canvas中的图片信息
  //window.atob方法将其中的base64格式的图片转换成二进制字符串；若将转换后的值直接赋值给Blob会报错，需Uint8Array转换：最后创建Blob对象；
  _data = _data.split(',')[1];
  _data = window.atob(_data);
 
  //如果不用ArrayBuffer,发送给服务器的图片格式是[object Uint8Array],上传失败...
  var _buffer = new ArrayBuffer(_data.length);
  var _ubuffer = new Uint8Array(_buffer);
  for (var i = 0; i < _data.length; i++) {
    _ubuffer[i] = _data.charCodeAt(i);
  }
 
  // 安卓 UC浏览器不支持 new Blob()，使用BlobBuilder
  var _blob;
  try {
    _blob = new Blob([_buffer], {type:'image/jpeg'});
  } catch(ee) {
    window.BlobBuilder = window.BlobBuilder || window.WebKitBlobBuilder || window.MozBlobBuilder || window.MSBlobBuilder;
    if (ee.name == 'TypeError' && window.BlobBuilder) {
      var _bb = new BlobBuilder();
      _bb.append(_buffer);
      _blob = _bb.getBlob('image/jpeg');
    }
  }
 
  var _suffix = 'jpg';
  if(_blob.type === 'image/jpeg') {
    _suffix = 'jpg';
  }
 
  //获取NOStoken
  this.__cache._$requestDWRByGet({url: 'ImageBean.genTokens',param: [_suffix,'','','','1'],onload: function(_tokens) {
    _tokens = _tokens || [];
    var _token = _tokens[0];
    if(!_token || !_token.objectName || !_token.uploadToken){
      alert('token获取失败！');
      return false;
    }
 
    //上传图片到NOS
    var _objectName = _token.objectName,
      _uploadToken = _token.uploadToken,
      _bucketName = _token.bucketName;
 
    var _formData = new FormData();
    _formData.append('Object', _objectName);
    _formData.append('x-nos-token', _uploadToken);
    _formData.append('file',_blob);
 
    var _xhr;
    if (window.XMLHttpRequest) {
      _xhr = new window.XMLHttpRequest();
    } else if (window.ActiveXObject) {
      _xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
 
    _xhr.onreadystatechange = function() {
      if(_xhr.readyState === 4) {
        if((_xhr.status >= 200 && _xhr.status < 300) || _xhr.status === 304) {
          var _imgurl = "http://www.qimiaojiyi.com/" + _bucketName + "/" + _objectName + "?imageView";
          var _newUrl = mb.x._$imgResize(_imgurl, 750, 750, 1, true);
 
          //window.location.href = 'http://www.lofter.com/act/taxiu?op=effect&originImgUrl=' + _newUrl;
        }
      }
    };
    _xhr.open('POST', 'http://www.qimiaojiyi.com/Uploadimg' + _bucketName, true);
    _xhr.send(_formData);
  }});
}
</script>