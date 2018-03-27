<ul class="breadcrumb">
    <li><a href="/">首页</a> > </li>
    <li>用户组列表</li>
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
                        <td>分组ID</td>
                        <td>分组名称</td>
                        <td>管理人</td>
                        <td>添加时间</td>
                        <td>操作</td>
                    </tr>
                    <?php if(empty($list)):?>
                    <tr style="width: 100%;">
                        <td colspan="5" style="text-align:center">暂无相关记录^~^</td>
                    </tr>
                    <?php endif;?>
                    <?php foreach($list as $v):?>
                    <tr style="width: 100%;">
                        <td><?php echo $v['groupid']?></td>
                        <td><?php echo $v['groupname']?></td>
                        <td><?php echo $v['uname']?></td>
                        <td><?php echo date("Y-m-d H:i",$v['addtime'])?></td>
                        <td>
                            <a href="<?php echo __APP__?>/manager/ucenter/edit?gid=<?php echo $v['groupid'].'?'.rand(0,99);?>">修改</a> 
                            <a href="<?php echo __APP__?>/manager/ucenter/del?gid=<?php echo $v['groupid'].'?'.rand(0,99);?>" onclick="return confirm('确定删除本条记录？');">删除</a> 
                        </td>
                    </tr>
                    <?php endforeach;?>
                </table>
    </div>
</div>