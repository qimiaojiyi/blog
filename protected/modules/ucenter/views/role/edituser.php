<ul class="breadcrumb">
    <li><a href="/">首页</a> > </li>
    <li>编辑用户</li>
</ul>
<div class='m_listwraper'>
    <div class="add_typebox">
        <form action="<?php echo __APP__?>/ucenter/role/edituser" method="post">
        <ul class="padding17">
            <li style="font-size: 14px;line-height: 25px;">
            <p>
                所属角色：
                <select name="roleid">
                    <?php foreach ($roleinfo as $v):?>
                    <option value="<?php echo $v['roleid']?>" <?php echo $userinfo['roleid']==$v['roleid'] ? "selected='selected'" : ""?>><?php echo $v['rolename']?></option>
                    <?php endforeach;?>
                </select>
            </p>
            <p>
                <input type="hidden" name="uid" value="<?php echo $userinfo['uid']?>">
                用户名称：
                <input type='text' placeholder="请输入用户名称" value="<?php echo $userinfo['uname']?>" disabled='disabled'>
            </p>
            <p>
                修改密码：
                <input name="userpassword" type='text' placeholder="留空表示不修改">
            </p>
            </li>
            <p>
                <input type="submit" name="subtn" value="修改用户" class="btn" style="margin-left: 79px;">
            </p>
        </ul>
        </form>
    </div>
</div>