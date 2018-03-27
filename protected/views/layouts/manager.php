<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta property="qc:admins" content="043453532776115117211163757" />
    <title><?php echo $this->title?></title>
    <meta name="keywords" content="<?php echo $this->title;echo ','.$this->keywords;?>" />
    <meta name="description" content="<?php echo $this->description?>" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!--百度统计-->
    <script>
    var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?b4b71ff95b7da5cd96d1bbe1c34ec647";
            var s = document.getElementsByTagName("script")[0]; 
            s.parentNode.insertBefore(hm, s);
        })();
    </script>


    <link rel="stylesheet" href="<?php echo __HOMESRC__?>/css/base.css"/>
    <link rel="stylesheet" href="<?php echo __HOMESRC__?>/css/laypage.css"/>
    <link rel="stylesheet" href="<?php echo __HOMESRC__?>/css/style.css"/>
    <script src="https://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
    <script src="<?php echo __HOMESRC__?>/js/jquery.easing.min.js"></script>
    <script src="<?php echo __HOMESRC__?>/js/laypage.js"></script>
    <script src="<?php echo __HOMESRC__?>/js/cookie.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo __HOMESRC__?>/js/xss.min.js"></script>
    <script src="<?php echo __HOMESRC__?>/js/main.js"></script>
     <!-- 引入文件 -->
    <!-- 指定回调地址，同时回调地址要与申请的回调地址一致 -->
    <script type="text/javascript" src="https://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" data-appid="101340021" data-redirecturi="https://www.qimiaojiyi.com/qqcontect/sheng.html" charset="utf-8"></script>
</head>
<body>
   <div class="header">
       <ul class="navBar">
           <li class="nav"><a href="/" <?php echo $this->typeid == 0 ? 'class="lineOn"' : '';?>>首页</a></li>
           <li class="nav"><a href="<?php echo __APP__?>/home/front" <?php echo $this->typeid == 1 ? 'class="lineOn"' : '';?>>前端</a></li>
           <li class="nav"><a href="<?php echo __APP__?>/home/back" <?php echo $this->typeid == 2 ? 'class="lineOn"' : '';?>>后端</a></li>
           <li class="nav"><a href="<?php echo __APP__?>/home/system" <?php echo $this->typeid == 3 ? 'class="lineOn"' : '';?>>运维</a></li>
           <li class="nav"><a href="<?php echo __APP__?>/home/zatan" <?php echo $this->typeid == 4 ? 'class="lineOn"' : '';?>>网络杂谈</a></li>
           <li class="nav"><a href="<?php echo __APP__?>/home/leavemsg" <?php echo $this->typeid == 8 ? 'class="lineOn"' : '';?>>给我留言</a></li>
       </ul>
       <!--<p class="search">
           <input type="text" id="serachText" placeholder="搜索"><a href="#" id="serachSbmit"><img src="<?php echo __HOMESRC__?>/img/glyphicons-halflings-white.png" alt="搜索"></a>
       </p>-->
       <div class="linestyle">
             <div class="lineHover" style="display: none;"></div>
       </div>
       
   </div>
   <?php echo $content;?>
   <!-- <img src="<?php echo __HOMESRC__?>/img/glyphicons-halflings-white.png" alt="搜索"> -->
    <div class="clearfix"></div>
    <div class="footer" style="margin:0 auto;margin-top: 20px;width: 1100px;height: 30px;line-height: 30px;color:#666;">
        Powered by:七秒记忆网&nbsp;&nbsp;网站备案号：<a href="http://www.miitbeian.gov.cn" target="_blank">皖ICP备13016713号-2</a>&nbsp;&nbsp;<font size="4">&COPY;</font>2016-2018
    </div>
