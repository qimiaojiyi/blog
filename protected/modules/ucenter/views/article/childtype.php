<?php foreach ($types as $type):?>
<li>
<ul style="margin-left:17px;margin-right: 0px;">
    <li style="height:25px;font-size: 14px;line-height: 25px;" id="<?php echo $type['id']?>">
        <span class="m_fleft"><img src="<?php echo __MANSRC__?>/images/openimg.png" class="childimg" onclick="getChildType($(this))"></span>
        <span class="m_fleft">
            <a href="<?php echo __APP__?>/ucenter/article/articlelist?typeid=<?php echo $type['id'] .'?'.rand(0,99)?>">
            <?php echo $type['typename']?>
            </a>(ID:<?php echo $type['id']?> 文章:<?php echo $type['archivenum']?>)
        </span>
        <!--<span class="opentype m_fright"><a href="<?php echo __APP__?>/ucenter/article/articlelist?typeid=<?php echo $type['id']?>">打开</a></span>-->
        <div class="clearfix"></div>
    </li>
</ul>
</li>
<?php endforeach;?>

