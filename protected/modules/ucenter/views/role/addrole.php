<ul class="breadcrumb">
    <li><a href="/">首页</a> > </li>
    <li>添加角色</li>
</ul>
<div class='m_listwraper'>
    <div class="add_typebox">
        <form action="<?php echo __APP__?>/ucenter/role/addrole" method="post">
        <ul class="padding17">
            <li style="font-size: 14px;line-height: 25px;">
            <p>
                角色名称：
                <input name="rolename" type='text' placeholder="请输入角色名称">
            </p>
            <p>
                权限分配：
                <ul style="margin-left: 70px;margin-top: -44px;line-height: 20px;" class='sheng_checkbox'>
                    <?php foreach($group_ctrlpanel as $v):?>
                    <li>
                        <label class="pid add_check_btn">
                            <input type="checkbox" name="ctrlpanel[]" value="<?php echo $v['panelid']?>"><?php echo $v['panelname']?>
                        </label>
                        (
                        <?php foreach($v['children'] as $v1):?>
                        <label class="cid add_check_btn"><input name="ctrlpanel[]" type="checkbox" value="<?php echo $v1['panelid']?>"><?php echo $v1['panelname']?></label>
                        <?php endforeach;?>
                        )
                    </li>
                    <?php endforeach;?>
                </ul>
            </p>
            </li>
            <p>
                <input type="submit" name="subtn" value="添加角色" class="btn" style="margin-left: 79px;">
            </p>
        </ul>
        </form>
    </div>
</div>
<script>
    //页面加载的时候判断父级勾选情况
    $('.pid').change(function(){
        var p_input = $(this).children('input');
        var c_input = $(this).siblings('.cid').children('input');
        if(p_input.is(':checked')){
            c_input.attr('checked','checked');
        }else{
            c_input.attr('checked',false);
        }
    });
    $('.cid').change(function(){
        var c_inputs_checked = $(this).siblings('.pid').siblings('.cid').find(':input[name="ctrlpanel[]"]:checked');
        var len_checked = c_inputs_checked.length;
        if(len_checked==0){
            $(this).siblings('.pid').children('input').attr('checked',false);
        }else{
            $(this).siblings('.pid').children('input').attr('checked','checked');
        }
    });
</script>






















