<ul class="breadcrumb">
    <li><a href="/">首页</a> > </li>
    <li>添加模块</li>
</ul>
<div class='m_listwraper'>
    <div class="add_typebox">
        <form action="<?php echo __APP__?>/manager/panel/add" method="post">
        <ul class="padding17">
            <li style="font-size: 14px;line-height: 25px;">
            <p>
                所属父类：
                <select name="panelpid">
                    <option value="0">--请选择--</option>
                    <?php if(empty($panels)):?>
                    <option value="0">暂无模块名，请先添加</option>
                    <?php else:?>
                    <?php foreach ($panels as $v):?>
                    <option value="<?php echo $v['panelid']?>"><?php echo $v['panelname']?></option>
                    <?php endforeach;?>
                    <?php endif;?>
                </select>
            </p>
            <p>
                模块名称：
                <input name="panelname" type='text' placeholder="请输入模块名称">
            </p>
            <p>
                模块路径：
                <input name="panelpath" type="text" placeholder="如“default/index”"><span style="color:#bbb"> 父类则只需写控制器名：如“default”</span>
            </p>
            <p>
                面板设置：<input type="radio" value="0" name="isshow"  checked="checked">不在面板显示&emsp;<input type="radio" value="1" name="isshow">在面板显示
            </p>
            </li>
            <p>
                <input type="submit" name="subtn" value="添加模块" class="btn" style="margin-left: 79px;">
            </p>
        </ul>
        </form>
    </div>
</div>
<script>