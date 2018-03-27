<ul class="breadcrumb">
    <li><a href="/">首页</a> > </li>
    <li>添加用户</li>
</ul>
<div class='m_listwraper'>
    <div class="add_typebox">
        <form action="<?php echo __APP__?>/ucenter/role/adduser" method="post">
        <ul class="padding17">
            <li style="font-size: 14px;line-height: 25px;">
            <p>
                所属角色：
                <select name="roleid">
                    <option value="0">--请选择--</option>
                    <?php if(empty($roles)):?>
                    <option value="0">暂无角色，请先添加</option>
                    <?php else:?>
                    <?php foreach ($roles as $v):?>
                    <option value="<?php echo $v['roleid']?>"><?php echo $v['rolename']?></option>
                    <?php endforeach;?>
                    <?php endif;?>
                </select>
            </p>
            <p>
                用户名称：
                <input name="username" type='text' placeholder="请输入用户名称">
            </p>
            <p>
                用户密码：
                <input name="userpassword" type='text' placeholder="请输入一个用户登陆密码">
            </p>
            </li>
            <p>
                <input type="submit" name="subtn" value="添加用户" class="btn" style="margin-left: 79px;">
            </p>
        </ul>
        </form>
    </div>
</div>