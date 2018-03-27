<?php foreach ($types as $type):?>
<li>
<ul style="margin-left:17px;margin-right: 0px;">
    <li style="height:25px;font-size: 14px;line-height: 25px;" id="<?php echo $type['id']?>">
        <span class="m_fleft"><img src="<?php echo __MANSRC__?>/images/openimg.png" class="childimg"></span>
        <span class="m_fleft"><?php echo $type['typename']?></a>[ID:<?php echo $type['id']?>] (文档：0) </span>
        <span class="deltype m_fright">删除</span>
        <span class="opentype m_fright"><a href="<?php echo __APP__?>/manager/default/arclist?typeid=<?php echo $type['id']?>">打开</a></span>
        <div class="clearfix"></div>
    </li>
</ul>
</li>
<?php endforeach;?>

