<ul class="breadcrumb">
    <li><a href="/">首页</a> > </li>
    <li>角色列表</li>
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
                        <td style="width:100px;">角色名</td>
                        <td>拥有权限</td>
                        <td style="width:150px;">添加时间</td>
                        <td style="width:100px;">操作</td>
                    </tr>
                    <?php if(empty($roleinfo)):?>
                    <tr>
                        <td colspan="5" style="text-align:center;">您还没有添加角色^~^</td>
                    </tr>
                    <?php endif;?>
                    <?php foreach($roleinfo as $v):?>
                    <tr style="width: 100%;">
                        <td><?php echo $v[0]['rolename']?></td>
                        <td>
                            <?php foreach($v['panelname'] as $v1):?>
                                <?php echo $v1['panelname'];?>：
                                    <?php foreach ($v1['children'] as $v2):?>
                                        √<?php echo $v2['panelname']?>&nbsp;&nbsp;
                                    <?php endforeach;?>
                            <br>
                            <?php endforeach;?>
                        </td>
                        <td><?php echo date("Y-m-d H:i",$v[0]['addtime'])?></td>
                        <td>
                            <a href="<?php echo __APP__?>/ucenter/role/editrole?rid=<?php echo $v[0]['roleid'];?>">编辑</a> 
                            <a href="<?php echo __APP__?>/ucenter/role/delrole?rid=<?php echo $v[0]['roleid'];?>">删除</a> 
                        </td>
                    </tr>
                    <?php endforeach;?>
                </table>
    </div>
</div>
<!--列表详情层END-->