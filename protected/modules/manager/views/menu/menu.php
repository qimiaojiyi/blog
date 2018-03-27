<style>
    .m_typebox ul,.m_typebox ul li{
        padding: 0px 5px 0px 0px ;
        margin: 0px 10px 10px 0px ;
        list-style: none;
    }
    .m_typebox{
        padding: 5px 0px;
        margin-left: 17px;
        border:1px solid #eee;
        margin-right: 17px;
        margin-top:5px;
    }
    .m_fleft{
        display: inline-block;
        float:left;
    }
    .m_fright{
        display: inline-block;
        margin-left: 10px;
        float:right;
    }
    .noborder{
        border:none;
    }
</style>
<ul class="breadcrumb">
    <li><a href="/">首页</a> > </li>
    <li>菜单管理</li>
    <li style="position: absolute;right:17px;top:-3px;">
        <div class="btn-toolbar">
            <div class="btn-group">
                <a class="btn btn-mini" id="addtypebtn" role="button" href="#addtype" data-toggle="modal">添加菜品分类</a>
            </div>
        </div>
    </li>
</ul>
<div class="alert alert-info" style="margin-left:17px;margin-right: 17px;margin-bottom:14px;display: none;">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>操作成功！</strong>
</div>
<!--列表层-->
<div class='m_typebox noborder'>
<!--    <form>
        <input type="text" placeholder="查找菜名" style="margin-bottom:0px;width: 260px">
        <input type="submit" class="btn btn-inverse" value="查找">
    </form>-->
    <ul>
        <?php foreach($menus as $menu):?>
        <a href="<?php echo __APP__?>/manager/menu/menuitem?menuid=<?php echo $menu['menuid'].'&'.rand(0,99);?>">
        <li class="m_fleft" style="width:110px;height: 110px;background: #eee;line-height: 110px;text-align: center;">
            <p><?php echo $menu['menuname']?></p>
            <label style="position:relative;top:-50px;">菜数（<?php echo $menu['count']?>）</label>
        </li>
        <?php endforeach;?>
        </a>
    </ul>
</div>
<!--列表层END-->

<!--添加栏目弹出框-->
<div id="addtype" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">添加菜品分类</h3>
  </div>
  <div class="modal-body">
      <p>
          分类名称：
          <input name="menuname" type='text'>
      </p>
      <p>
          排序顺序：
          <input name="sortrank" type='text' value="50">（越小越靠前）
      </p>
 </div>
  <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true" id="closetype">关闭</button>
    <button class="btn btn-primary" id="submenu">提交</button>
  </div>
</div>
<!--添加栏目弹出框END--> 

<script>
    $('#submenu').click(function(){
        var menuname = $("input[name='menuname']").val(),
            sortrank = $("input[name='sortrank']").val();
        var url = "<?php echo __APP__?>/manager/menu/addmenu";
        var data = {'menuname':menuname,'sortrank':sortrank};
        if($.trim(menuname)==='' || $.trim(sortrank)===''){
            alert('请全部填写');return;
        }
        $.post(url,data,function(rs){
            if(rs=='ok'){
                $('#closetype').click();
                location.reload();
                //$('.alert').show();
            }else{
                alert('添加失败，请重新添加');
            }
        });
    });    
</script>