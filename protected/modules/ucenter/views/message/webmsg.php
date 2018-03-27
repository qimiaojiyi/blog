<ul class="breadcrumb">
    <li><a href="/">首页</a> > </li>
    <li>站点留言</li>
    <li style="position: absolute;right:17px;top:-3px;">
        <div class="btn-toolbar">
            <div class="btn-group">
                <a class="btn btn-mini" role="button" href="<?php echo __APP__?>/ucenter/article/addarticle?typeid=<?php //echo $_GET['typeid']?>" data-toggle="modal">添加文档</a>
            </div>
        </div>
    </li>
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
                        <td>留言ID</td>
                        <td>留言人</td>
                        <td>内容</td>
                        <td>留言时间</td>
                        <td>操作</td>
                    </tr>
                    <?php if(empty($msgs)):?>
                    <tr>
                        <td colspan="5" style="text-align:center;">暂无相关留言^~^</td>
                    </tr>
                    <?php endif;?>
                    <?php foreach($msgs as $v):?>
                    <tr style="width: 100%;">
                        <td><?php echo $v['id']?></td>
                        <td><?php echo $v['qqnickname']?></td>
                        <td><?php echo $v['content']?></td>
                        <td><?php echo date("Y-m-d H:i",$v['addtime'])?></td>
                        <td>
                            <a id="<?php echo $v['id'];?>" class="delmsg" href="#">删除</a> 
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
        var url = '<?php echo __APP__?>/ucenter/message/delwebmsg';
        $.ajax({
            type: 'POST',
            url : url,
            data : {'msgid':msgid},
            success:function(rs){
                console.log(rs);
                if(rs=='ok'){
                    window.location.reload();
                }
            },
            dataType:'HTML'
        });
    });
</script>
