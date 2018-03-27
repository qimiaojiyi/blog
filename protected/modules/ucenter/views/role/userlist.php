<ul class="breadcrumb">
    <li><a href="/">首页</a> > </li>
    <li>用户列表</li>
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
                        <td>用户名</td>
                        <td>角色名</td>
                        <td>最后登陆时间</td>
                        <td>操作</td>
                    </tr>
                    <?php if(empty($list)):?>
                    <tr style="width: 100%;">
                        <td colspan="5" style="text-align:center">暂无相关记录^~^</td>
                    </tr>
                    <?php endif;?>
                    <?php foreach($list as $v):if($v['roleid']==0 || Yii::app()->session['userinfo']['uid'] ==$v['uid']){continue;}?> 
                    <tr style="width: 100%;">
                        <td><?php echo $v['uname']?></td>
                        <td><?php echo empty($v[0]) ? '组管理员' : $v[0];?></td>
                        <td><?php echo date("Y-m-d H:i",$v['lastlogintime'])?></td>
                        <td>
                            <a href="<?php echo __APP__?>/ucenter/role/edituser?uid=<?php echo $v['uid'].'?'.rand(0,99);?>">修改</a> 
                            <a href="<?php echo __APP__?>/ucenter/role/deluser?uid=<?php echo $v['uid'].'?'.rand(0,99);?>" onclick="return confirm('确定删除本条记录？');">删除</a> 
                        </td>
                    </tr>
                    <?php endforeach;?>
                </table>
    </div>
</div>