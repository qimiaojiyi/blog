<style>
/*    .content{
        background: #eee;
    }*/
    .m_typebox ul,.m_typebox ul li{
        padding: 0px 5px 0px 5px ;
        margin: 0px 0px 0px 0px ;
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
    .padding17{
        padding-right: 17px;
    }
</style>
<ul class="breadcrumb">
    <li><a href="/">首页</a> > </li>
    <li>网站栏目管理</li>
    <li style="position: absolute;right:17px;top:-3px;">
        <div class="btn-toolbar">
            <div class="btn-group">
              <a class="btn btn-mini" role="button" href="#addtype" data-toggle="modal">添加栏目</a>
              <a class="btn btn-mini" href="addtypepitch#">批量添加</a>
            </div>
        </div>
    </li>
</ul>
<div class="alert alert-info" style="margin-left:17px;margin-right: 17px;margin-bottom:14px;display: none;">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>操作成功！</strong>
</div>
<!--列表层-->
<div class='m_listwraper'>
    <?php foreach ($types as $type):?>
    <div class="m_typebox">
        <ul class="padding17">
            <li style="height:25px;font-size: 14px;line-height: 25px;" id="<?php echo $type['id']?>">
                <span class="m_fleft">+</span>
                <span class="m_fleft"><?php echo $type['typename']?>[ID:<?php echo $type['id']?>] (文档：0) </span>
                <span class="deltype m_fright">删除</span>
                <span class="movetype m_fright">移动</span>
                <span class="addtype m_fright">增加子类</span>
                <span class="opentype m_fright"><a href="<?php echo __APP__?>/manager/arclist?typeid=<?php echo $type['id']?>">打开</a></span>
                <div class="clearfix"></div>
            </li>
        </ul>
    </div>
    <?php endforeach;?>
</div>
<!--列表层END-->

<!--添加栏目弹出框-->
<div id="addtype" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">添加栏目</h3>
  </div>
  <div class="modal-body">
      <p>
          是否隐藏栏目：
          <input name='ishidden' type="radio" checked="checked" value="1">显示
          <input name='ishidden' type="radio" value="0">不显示
      </p>
      <br/>
      <p>
          栏目名称：
          <input name="typename" type='text'>
      </p>
      <p>
          内容模型：
          <select name="modeltype">
              <option value="1">普通模型</option>
          </select>
      </p>
      <p>
          排列顺序：
          <input name="sortrank" type='text' value="50">
      </p>
 </div>
 <!--添加栏目弹出框END--> 
  <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true" id="closetype">关闭</button>
    <button class="btn btn-primary" id="subtype">提交</button>
  </div>
</div>
<script>
    $('#subtype').click(function(){
        var ishidden = $("input[name='ishidden']:checked").val(),
        typename = $("input[name='typename']").val(),
        modeltype = $("select[name='modeltype']").val(),
        sortrank = $("input[name='sortrank']").val();
        var url = "<?php echo __APP__?>/manager/addtype";
        var data = {'ishidden':ishidden,'typename':typename,'modeltype':modeltype,'sortrank':sortrank};
        if($.trim(typename)==='' || $.trim(modeltype)==='' || $.trim(sortrank)===''){
            alert('请全部填写');return;
        }
        $.post(url,data,function(rs){
            if(rs=='ok'){
                $('#closetype').click();
                location.reload();
                //$('.alert').show();
            }
        });
    });
    //删除栏目
    $('.deltype').click(function(){
        var self = $(this);
        var typeid = self.parent('li').attr('id'),
            url = "<?php echo __APP__?>/manager/deltype",
            data = {'typeid':typeid};
        $.post(url,data,function(rs){
            if(rs=='ok'){
                self.parents('.m_typebox').remove();
                $('.alert').show();
            }
        });
    });
</script>
