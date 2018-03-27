<ul class="breadcrumb">
    <li><a href="/">首页</a> > </li>
    <li>@我的留言</li>
</ul>
<?php if(Yii::app()->user->hasFlash('success')):?>
<div class="alert alert-info" style="margin-left:17px;margin-right: 17px;margin-bottom:14px;">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong><?php echo Yii::app()->user->getFlash('success');?></strong>
</div>
<?php endif;?>
<!--列表详情层-->
<div class='m_listwraper'>
    <div class="m_typebox noborder">
                <table class="table">
                    <tr class="info">
                        <td>文章ID</td>
                        <td>回复人</td>
                        <td>回复内容</td>
                        <td>回复时间</td>
                        <td>使用IP</td>
                        <td>操作</td>
                    </tr>
                    <?php if(empty($mymsg)):?>
                    <tr>
                        <td colspan="6" style="text-align:center;">暂无动态^~^</td>
                    </tr>
                    <?php endif;?>
                    <?php foreach($mymsg as $v):?>
                    <tr style="width: 100%;">
                        <td style="width:240px;" title="<?php echo $v['title'];?>"><?php echo mb_substr($v['title'], 0, 20, 'utf-8')?>...</td>
                        <td><?php echo $v['qqnickname']?></td>
                        <td><?php echo $v['content']?></td>
                        <td><?php echo date("Y-m-d H:i",$v['addtime'])?></td>
                        <td><?php echo Util::IpToLocation($v['userip'])?></td>
                        <td>
                            <a id="<?php echo $v['id']?>" class="delmsg" href="javascript:;">删除</a> 
                        </td>
                    </tr>
                    <?php endforeach;?>
                </table>
    </div>
</div>
<!--列表详情层END-->

<script>
    //删除留言
    $('.delmsg').click(function(){
        if(!confirm('确定删除本条记录？')){
            return;
        }
        var msgid = $(this).attr('id');
        var url = '<?php echo __APP__?>/ucenter/message/delarcmsg';
        $.ajax({
            type: 'POST',
            url : url,
            data : {'msgid':msgid},
            success:function(rs){
                if(rs=='ok'){
                    window.location.reload();
                }
            },
            dataType:'HTML'
        });
    });
</script>
