<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<meta http-equiv="X-UA-Compatible" content="IE=9">

<meta name="autho" content="hito">
<title>Candicefay And Hito</title>
<meta name="Keywords" content="#" />
<meta name="description" content="#" />
<link href="/assets/timeline/css/Smohan.blog.css" type="text/css" rel="stylesheet">
<style type="text/css">
* {PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px;}
</style>
</head>
<body>
<br />
<br />
<center>
  <h2></h2>
</center>
<!--ShowMsg-->
<div id="Container">
    <div class="timeline_container">
        <div class="timeline">
            <div class="plus"></div>
            <div class="plus2"></div>
        </div>
    </div>
    <?php foreach ($notes as $v):?>
    <div class="item">
        <h3> <span class="fl"><?php echo $v['address']=='显示位置' ? '来自火星' :  $v['address'];?></span> <span class="fr">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo isset($v['week']) ? $this->weekMark($v['week']) : 'sunshine';?></span> </h3>
        <p class="con"><?php echo $v['content']?><br /></p>
        <h4><b style="color:#bbb;"><?php echo date('Y-m-d H:i:s',$v['time']);?></b><b style="display: block;float:right;color:#bbb">hito❤candicefay</b></h4>
    </div>
    <?php endforeach;?>
</div>
<!--/ShowMsg-->
<script src="http://www.qimiaojiyi.com/assets/home/js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="/assets/timeline/js/Smohan.blog.plug.js"></script>
<script src="/assets/home/js/snowfall.jquery.js"></script>
<script type="text/javascript">
//    $(document).snowfall('clear');
//    $(document).snowfall({
//        image: "/assets/home/img/huaban.png",
//        flakeCount:52,
//        minSize: 10,
//        maxSize: 30
//    });
    $(document).ready(function() {
      /*时间轴*/
      $('#Container').masonry({itemSelector : '.item'});
            function Arrow_Points(){
              var s = $("#Container").find(".item");
              $.each(s,function(i,obj){
                    var posLeft = $(obj).css("left");
                    if(posLeft == "0px"){
                      html = "<span class='rightCorner'></span>";
                      $(obj).prepend(html);
                    } else {
                      html = "<span class='leftCorner'></span>";
                      $(obj).prepend(html);
                    }
              });
            }
            Arrow_Points();
    });
</script>
</body>
</html>


