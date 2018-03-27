<script type="text/javascript" charset="utf-8" src="<?php echo __APP__?>/assets/ueditor/ueditor.parse.min.js"></script>
<script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" data-appid="101340021" data-redirecturi="http://blog.qimiaojiyi.com/qqcontect/sheng.html" charset="utf-8"></script>
<div class="bodys">
   <div class="article">
			<ul class="right list">
			    	<li>
			           <h4><?php echo $article['title']?></h4>
			           <div class="tool">
			               <p>
			                    <span class="time"><span class="icon"></span><?php echo date('Y-m-d H:i:s',$article['pubdate'])?></span>
			                    <span class="autour"><span class="icon"></span><?php echo $article['uname']?></span>
			                    <span class="clicks" id="<?php echo $article['id']?>">
			                        <span class="icon"></span>
			                        <span class="number"><?php echo $article['click'] ? $article['click'] : 0?></span>
			                        <span class="title">您已赞过...</span>
			                    </span>
			               </p>
			               <div class="bdsharebuttonbox shares"><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tieba" data-cmd="tieba" title="分享到百度贴吧"></a><a href="#" class="bds_bdysc" data-cmd="bdysc" title="分享到百度云收藏"></a></div>
			           </div>
			               <div class="content text">
			               <?php echo $article['content']?>
			           </div>
			       </li>
			</ul>
			<ul class="connect">
			      <h5>相关文章</h5>
			        <?php foreach ($likearticle as $v):?>
			        <li><a href="<?php echo __APP__?>/home/article?aid=<?php echo $v['id']?>" class="connectLink"><?php echo mb_substr($v['title'], 0, 10, 'utf8')?></a><span><?php echo date('Y-m-d H:i:s',$v['pubdate'])?></span></li>
			        <?php endforeach;?>
			</ul>
			<ul class="connect Label">
		          <h5><span></span>文章分类</h5>
		          <li><a href="#" class="LabelLink">php</a></li>
		          <li><a href="#" class="LabelLink">javascript</a></li>
		          <li><a href="#" class="LabelLink">运维</a></li>
		          <li><a href="#" class="LabelLink">css</a></li>
		          <li><a href="#" class="LabelLink">Linux</a></li>
		          <li><a href="#" class="LabelLink">html</a></li>
		    </ul>
	</div>	    
    <!--相关评论 -->
    <h4 class="comment">相关评论:</h4>
    <ul class="commentList">
         <li>
    	     <ul class="person">
    	     	<li class="picture"><img src="<?php echo __HOMESRC__?>/img/qq.png" alt=""></li>
    	     	<li class="commentNews">
    	     	    <p class="name1">sheng</p>
    	     	    <p class="speak1">某男生宿舍卧谈会持续至凌晨三点，忽然想讨论一个问题“碰到一个漂亮姑娘，首先该说什么?”某君从梦中惊醒，曰：“甭说了，咱们睡吧!”-</p>
    	     	    <p class="detailed1">
    	     	         <span>7-26</span>
    	     	         <span class="huifu"><span class="icon1"></span><span>回复(<a href="javascript:void(0);" data-flag=true>0</a>)</span></span>
    	     	         <span class="agree"><span class="icon2"></span><span>顶(<a href="javascript:void(0);" data-flag=true>0</a>)</span></span>
    	     	    </p>
    	     	</li>
    	     </ul>
    	 </li>
    	 <li style="margin-left: 40px;">
    	     <ul class="person">
    	     	<li class="picture"><img src="<?php echo __HOMESRC__?>/img/qq.png" alt=""></li>
    	     	<li class="commentNews">
    	     	    <p class="name1">sheng</p>
    	     	    <p class="speak1">某男生宿舍卧谈会持续至凌晨三点，忽然想讨论一个问题“碰到一个漂亮姑娘，首先该说什么?”某君从梦中惊醒，曰：“甭说了，咱们睡吧!”-</p>
    	     	    <p class="detailed1">
    	     	         <span>7-26</span>
    	     	         <span class="huifu"><span class="icon1"></span><span>回复(<a href="javascript:void(0);" data-flag=true>0</a>)</span></span>
    	     	         <span class="agree"><span class="icon2"></span><span>顶(<a href="javascript:void(0);" data-flag=true>0</a>)</span></span>
    	     	    </p>
    	     	</li>
    	     </ul>
    	</li>
    	<li style="margin-left: 80px;">
    	     <ul class="person">
    	     	<li class="picture"><img src="<?php echo __HOMESRC__?>/img/qq.png" alt=""></li>
    	     	<li class="commentNews">
    	     	    <p class="name1">sheng</p>
    	     	    <p class="speak1">某男生宿舍卧谈会持续至凌晨三点，忽然想讨论一个问题“碰到一个漂亮姑娘，首先该说什么?”某君从梦中惊醒，曰：“甭说了，咱们睡吧!”-</p>
    	     	    <p class="detailed1">
    	     	         <span>7-26</span>
    	     	         <span class="huifu"><span class="icon1"></span><span>回复(<a href="javascript:void(0);" data-flag=true>0</a>)</span></span>
    	     	         <span class="agree"><span class="icon2"></span><span>顶(<a href="javascript:void(0);" data-flag=true>0</a>)</span></span>
    	     	    </p>
    	     	</li>
    	     </ul>
    	</li>
    </ul>
    <!-- 分页 -->
	<div id="biuuu_city"></div>
	<!-- 留言 -->
	<ul class="commentSbmit">
        <li class="_personShow">
            <img src="<?php echo __HOMESRC__?>/img/qq.png" alt="">
            <span style="display: none">退出登录</span>
        </li>
        <li class="myself">
            <textarea name="" id="" cols="30" rows="10"></textarea>
            <p><img src="<?php echo __HOMESRC__?>/img/1.jpg" alt=""></p>
            <div>发布</div>
        </li>
	</ul>
	<!-- qq登录 -->
<span id="qqLoginBtn"></span>
</div>
</body>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
</script>
<script>
    $(function(){
       uParse('.content', {
            rootPath: '<?php echo __APP__?>/assets/ueditor/'
        });
    });
</script>
<script src="<?php echo __HOMESRC__?>/js/qq.js"></script>
</html>