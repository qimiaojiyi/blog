<?php foreach($messages as $v):?>
<li id="<?php echo $v['id']?>">
    <img src="<?php echo empty($v['qqfigureurl']) ? __HOMESRC__.'/img/default.jpg' : $v['qqfigureurl'] ?>">
    <div class="items-content">
        <span class="avatar"><?php echo $v['qqnickname']?></span>
        <p>
            <?php echo stripslashes($v['content'])?>
            <?php if($v['isprivate']==1):?>
            <img src="<?php echo __HOMESRC__?>/img/private.png" class="privatemsg">
            <?php endif;?>
        </p>
        <div class="items-footer">
            <span><?php echo $this->TimeFormat($v['addtime'])?></span><span class="_sheng_top">顶(<?php echo $v['click']?>)</span>
        </div>
        <div class="clearfix"></div>
    </div>
</li>
<?php endforeach;?>
