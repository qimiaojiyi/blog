   <div class="bodys">
       <div class="left" data-total=<?php echo $archives['totalpage'];?>><!--存放总页数--></div>
       <ul class="right list">
            <?php foreach ($archives['info'] as $arc):?>
    	      <li>
                  <img src="<?php echo isset($arc['avatar']) ? $arc['avatar'] : __HOMESRC__.'/img/tmp.jpg' ?>" style="float:left;width:35px;vertical-align:middle;margin-right: 10px;border-radius: 50%;">
                  <h4>
                      <a href="<?php echo __APP__?>/article/<?php echo $arc['id']?>.html" title="<?php echo $arc['title']?>"><?php echo $arc['title']?></a>
                  </h4>
    	           <div class="tool">
                        <p>
                             <span class="time"><span class="icon"></span><?php echo $this->TimeFormat($arc['pubdate'])?></span>
                             <span class="autour"><span class="icon"></span><?php echo $arc['uname']?></span>
                        <span class="clicks" id="<?php echo $arc['id']?>">
                             <span class="icon"></span>
                             <span class="number"><?php echo $arc['click']?></span>
                             <span class="title">您已赞过...</span>
                        </span>
                        </p>
    	           </div>
    	           <p class="text">
    	               <?php echo str_replace('&nbsp;&nbsp;','',mb_substr($arc['description'], 0, 500, 'utf-8'))?>
                       <a class="details" href="<?php echo __APP__?>/article/<?php echo $arc['id']?>.html">查看全文</a>
    	           </p>
    	      </li>
            <?php endforeach;?>
       </ul>
       <ul class="connect">
            <h5><i class="relative-article"></i>相关文章</h5>
            <?php foreach ($likearticle as $v):?>
            <li>
                <i class="items_li"></i>
                <a href="<?php echo __APP__?>/article/<?php echo $v['id']?>.html" class="connectLink" title="<?php echo $v['title']?>"><?php echo mb_substr($v['title'], 0, 10, 'utf8')?>...</a><span><?php echo $this->TimeFormat($v['pubdate'])?></span>
            </li>
            <?php endforeach;?>
      </ul>
      <ul class="connect Label">
            <h5><span></span>文章分类</h5>
            <?php foreach($childrentype as $v):?>
            <li><a href="<?php echo __APP__?>/home/childtype/typeid/<?php echo $v['id']?>" class="LabelLink"><?php echo $v['typename']?></a></li>
            <?php endforeach;?>
      </ul>
      <!-- 分页 -->
      <div id="biuuu_city"></div>
        <!-- qq登录 -->
      <span id="qqLoginBtn" style="display: none;"></span>
   </div>
</body>
</html>
