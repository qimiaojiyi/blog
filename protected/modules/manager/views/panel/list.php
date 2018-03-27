<ul class="breadcrumb">
    <li><a href="/">首页</a> > </li>
    <li>模块列表</li>
</ul>
<?php if(Yii::app()->user->hasFlash('success')):?>
<div class="alert alert-info" style="margin-left:17px;margin-right: 17px;margin-bottom:14px;">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong><?php echo Yii::app()->user->getFlash('success');?></strong>
</div>
<?php endif;?>
<div class='m_listwraper'>
    <div class="m_typebox noborder">
                <table class="table">
                    <tr class="info">
                        <td style="width: 50px;">开/关</td>
                        <td>模块名称</td>
                        <td>模块路径</td>
                        <td>添加时间</td>
                        <td>操作</td>
                    </tr>
                    <?php if(empty($panels)):?>
                    <tr style="width: 100%;">
                        <td colspan="5" style="text-align:center">暂无相关记录^~^</td>
                    </tr>
                    <?php endif;?>
                    <?php foreach($panels as $v):?>
                    <tr style="width: 100%;">
                        <td class="ctrl-btn">展开</td>
                        <td><?php echo $v['panelname']?></td>
                        <td><?php echo $v['panelpath']?></td>
                        <td><?php echo date("Y-m-d H:i",$v['addtime'])?></td>
                        <td>
                            <a href="<?php echo __APP__?>/manager/ucenter/edit?gid=<?php //echo $v['groupid'].'?'.rand(0,99);?>">修改</a> 
                            <a href="<?php echo __APP__?>/manager/ucenter/del?gid=<?php //echo $v['groupid'].'?'.rand(0,99);?>" onclick="return confirm('确定删除本条记录？');">删除</a> 
                        </td>
                    </tr>
                    <tr style="display: none;">
                        <td colspan="5" style="border-top:none;">
                            <?php foreach($v['children'] as $v1):?>
                            <table  class="children table-hover" style="width: 100%">
                                <tr>
                                    <td style="width:50px;padding-left: 0px;"></td>
                                    <td style="width:20%;"><?php echo $v1['panelname']?></td>
                                    <td style="width:20%;"><?php echo $v1['panelpath']?></td>
                                    <td style="width:20%;"><?php echo date("Y-m-d H:i",$v['addtime'])?></td>
                                    <td>
                                        <a href="<?php echo __APP__?>/manager/ucenter/edit?gid=<?php //echo $v['groupid'].'?'.rand(0,99);?>">修改</a> 
                                        <a href="<?php echo __APP__?>/manager/ucenter/del?gid=<?php //echo $v['groupid'].'?'.rand(0,99);?>" onclick="return confirm('确定删除本条记录？');">删除</a> 
                                    </td>
                                </tr>
                            </table>
                            <?php endforeach;?>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </table>
    </div>
</div>
<script>
    $('.ctrl-btn').click(function(){
        var self = $(this);
        var children = self.parent('tr').next('tr');
        if(self.text()=='展开'){
            self.text('收起');
        }else{
            self.text('展开');
        }
        children.toggle();
    });
</script>