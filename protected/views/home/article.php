<script type="text/javascript" charset="utf-8" src="<?php echo __APP__?>/assets/ueditor/ueditor.parse.min.js"></script>
<script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" data-appid="101340021" data-redirecturi="http://www.qimiaojiyi.com/qqcontect/sheng.html" charset="utf-8"></script>
<div class="bodys">
   <div class="article">
			<ul class="right list">
                            <li style="padding-top:0px;">
                                    <img src="<?php echo isset($article['avatar']) ? $article['avatar'] : __HOMESRC__.'/img/tmp.jpg' ?>" style="float: left;width:35px;vertical-align:middle;margin-right: 10px;border-radius: 50%;">
                                    <h4 articleid=<?php echo $article['id']?> class="onlyId"><?php echo $article['title']?></h4>
                                    <div class="tool">
			               <p>
			                    <span class="time"><span class="icon"></span><?php echo $this->TimeFormat($article['pubdate'])?></span>
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
                            <h5><i class="relative-article"></i>相关文章</h5>
			        <?php foreach ($likearticle as $v):?>
			        <li>
                                    <i class="items_li"></i>
                                    <a href="<?php echo __APP__?>/article/<?php echo $v['id']?>.html" class="connectLink"><?php echo mb_substr($v['title'], 0, 10, 'utf8')?></a><span><?php echo $this->TimeFormat($v['pubdate'])?></span>
                                </li>
			        <?php endforeach;?>
			</ul>
			<ul class="connect Label">
		          <h5><span></span>文章分类</h5>
                          <?php foreach($childrentype as $v):?>
		          <li><a href="<?php echo __APP__?>/home/childtype/typeid/<?php echo $v['id']?>" class="LabelLink"><?php echo $v['typename']?></a></li>
                          <?php endforeach;?>
		    </ul>
	</div>	    
    <!--相关评论 -->
    <h4 class="comment">相关评论:</h4>
    <ul class="commentList">
       
    </ul>

    <!-- 分页 -->
    <div class="_LookMore" style="display: none;">查看更多</div>
	<div id="biuuu_city"></div>
	<!-- 留言 -->
	<ul class="commentSbmit">
        <li class="_personShow" style="text-align:left">
            <img src="<?php echo __HOMESRC__?>/img/default.jpg" alt="">
            <span style="display: none">退出登录</span>
        </li>
        <li class="myself">
            <textarea name="" id="" cols="30" rows="10"></textarea>
            <p><img src="<?php echo __HOMESRC__?>/img/1.jpg" alt=""></p>
            <div class="shengMessage">发布</div>
            <div class="Expression shengHidden bottomReply">
            	<ul>    
                    <?php foreach($this->emotion as $k => $v):?>
                        <li class="ExpressionImg" imgNum="<?php echo $k;?>"><img src="<?php echo __HOMESRC__?>/emoubb/<?php echo $v;?>.gif" alt=""></li>
                    <?php endforeach;?>
            	</ul>
            </div>
        </li>
	</ul>
	<!-- qq登录 -->
<span id="qqLoginBtn" style="display: none;"></span>
</div>
<div id="sheng1" style="width:200px;height:50px;position:fixed;left:0;bottom:200px;"></div>
<!-- 待克隆表情包 -->
<div class="shengClone" style="display: none;">
	<div class="Expression cloneOne">
            	<ul>
                    <?php foreach($this->emotion as $k => $v):?>
                        <li class="ExpressionImg" imgNum="<?php echo $k;?>"><img src="<?php echo __HOMESRC__?>/emoubb/<?php echo $v;?>.gif" alt=""></li>
                    <?php endforeach;?>
            	</ul>
    </div>
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
</html>