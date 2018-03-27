<script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" data-appid="101340021" data-redirecturi="http://www.qimiaojiyi.com/qqcontect/sheng.html" charset="utf-8"></script>
<div class="section">
    <div class="livemessage">
        <div class="msg-content">
            <div class="msg-items">
                <h3>网站留言</h3>
                <div class="items-wrap">
                    <div class="items-info">
                        <span class="msg-top-total">顶起来的评论</span>
                        <div class="clearfix"></div>
                        <ul class='_sheng_ulBox'>
                            <?php if(empty($favmessage)):?>
                            还没有相关留言呢
                            <?php else:?>
                            <?php foreach($favmessage as $v):?>
                            <li id="<?php echo $v['id']?>" class='_sheng_liBox<?php echo $v['id']?>'>
                                <img src="<?php echo empty($v['qqfigureurl']) ? __HOMESRC__.'/img/default.jpg' : $v['qqfigureurl'] ?>">
                                <div class="items-content">
                                    <span class="avatar"><?php echo $v['qqnickname']?></span>
                                    <p><?php echo stripslashes($v['content'])?></p>
                                    <div class="items-footer">
                                        <span><?php echo $this->TimeFormat($v['addtime']);?></span><span class="_sheng_top">顶(<?php echo $v['click']?>)</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                            <?php endforeach;?>
                            <?php endif?>
                        </ul>
                    </div>
                    <div class="msg-list">
                        <div id="biuuu_city"></div>
                        <span class="msg-total">最近<?php echo $total;?>条评论</span>
                        <span class="msg-public msg-typehover _sheng_msgBtn" page=1 flag=true>全部留言</span>
                        <span class="msg-private _sheng_msgBtn" page=1 flag=true>我的留言</span>
                        <!--全部留言-->
                        <ul class="msg-all msg-list-items _msg_list _sheng_ulBox msg-mine">
                            <!-- loading -->
                            <img src="<?php echo __HOMESRC__?>/img/loading.gif" alt="加载中" width=80 style="margin:0 auto;display: none" class="sheng_loading">
                            <!-- 分页 -->
                            <div class="_shengNews_More" style="display: none;width: 638px;">查看更多</div>
                        </ul>
                        </ul>
                        <!--我的留言-->
                        <ul class="msg-list-items _msg_list _sheng_ulBox">
                           
                            <a class="_sheng_liBox41" style="text-align:center;color:#40A9E5;height:30px;line-height: 30px;display: block;" href="javascript:void(0);">您尚未登录请点击登录</a>
                       
                            <!-- loading -->
                            <img src="<?php echo __HOMESRC__?>/img/loading.gif" alt="加载中" width=80 style="margin:0 auto;display: none" class="sheng_loading">
                            <!-- 分页 -->
                            <div class="_shengNews_More" style="display: none;width: 638px;">查看更多</div>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                    <div class="leavemsg-box">
                        <ul class="msg-list-items">
                            <li>
                                <div class="livemessage-avatar">
                                    <img src="<?php echo __HOMESRC__?>/img/default.jpg">
                                    <span class="qqlogout">退出登录</span>
                                </div>
                                <div class="items-content">
                                    <textarea class="msg-textarea" placeholder="想说点什么"></textarea>
                                    <div class="msg-emotion-send">
                                        <div class="emotion-wrap">
                                            <div class="emotion emotionhover shengEmotion" title="站内留言" attrs="hoverOn"></div>
                                            <div class="emotion1 shengEmotion" title="私信给站长"></div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="send">发布</div>
                                        <div class="Expression shengHidden bottomReply">
                                        <span id="qqLoginBtn" style="display: none;"></span>
                                        <div id="sheng1" style="width:200px;height:50px;position:fixed;left:0;bottom:200px;"></div>
                                        <ul>    
                                            <?php foreach($this->emotion as $k => $v):?>
                                                <li class="ExpressionImg" imgNum="<?php echo $k;?>"><img src="<?php echo __HOMESRC__?>/emoubb/<?php echo $v;?>.gif" alt=""></li>
                                            <?php endforeach;?>
                                        </ul>
                                    </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="about">
            <h3>关于我们：</h3>
            <p>
                姓名：<a href="https://github.com/qimiaojiyi" title="superSheng11的github" target="_blank"><i class="githubicon"></i></a> hito(网站后端开发)<br>
                &emsp;&emsp;&emsp;<a href="https://github.com/superSheng11" title="superSheng11的github" target="_blank"><i class="githubicon"></i></a> superSheng11(网站前端设计)<br>
                技能：网站设计、微信公众号开发、OA系统定制、discuz二开、<br>
                &emsp;&emsp;&emsp;dedecms二开。<br>
                现住地址：北京市 丰台区<br>
                本站说明：本站部分内容摘选于网络，如有侵权，请联系本站。<br>
                QQ交流群：251354116<br><a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=4c8525037f3fca34485d90d3d7eb0a13b54edda9226577be02fc09db13d30556"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="七秒记忆" title="七秒记忆"></a>
            </p>
        </div>
    </div>
</div>
<span id="qqLoginBtn" style="display: none;"></span>
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
