<style>
    .m_typebox ul,.m_typebox ul li{
        padding: 0px 5px 0px 5px ;
        margin: 0px 0px 0px 0px ;
        list-style: none;
    }
    .m_typebox{
        background: #ffffff;
    }
</style>
<ul class="breadcrumb">
    <li><a href="/">首页</a> > </li>
    <li>文章分类</li>
    <li style="position: absolute;right:17px;top:-3px;">
        <div class="btn-toolbar">
            <div class="btn-group">
                <a class="btn btn-mini" id="addtypebtn" role="button" href="#addtype" data-toggle="modal">添加分类</a>
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
        <ul>
            <li style="height:25px;font-size: 14px;line-height: 25px;" id="<?php echo $type['id']?>">
                <span class="m_fleft"><img src="<?php echo __MANSRC__?>/images/openimg.png" class="childimg" onclick="getChildType($(this))"></span>
                <span class="m_fleft">
                    <a href="<?php echo __APP__?>/ucenter/article/articlelist?typeid=<?php echo $type['id'] .'?'.rand(0,99)?>">
                        <?php echo $type['typename']?>
                    </a>
                    (分类ID:<?php echo $type['id']?> 文章数:<?php echo $type['archivenum']?>)
                </span>
                <!--<span class="opentype m_fright"><a href="<?php echo __APP__?>/ucenter/article/articlelist?typeid=<?php echo $type['id'] .'?'.rand(0,99)?>">打开</a></span>-->
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
    <h3 id="myModalLabel">添加文章分类</h3>
  </div>
  <div class="modal-body">
      <p>
          是否隐藏分类：
          <input name='ishidden' type="radio" checked="checked" value="0">显示
          <input name='ishidden' type="radio" value="1">不显示
      </p>
      <br/>
      <p>
          分类名称：
          <input name="typename" type='text'>
      </p>
      <p>
          所属分类：
          <select name="pid">
              <option value="0">栏目获取中...</option>
          </select>
      </p>
      <p>
          排列顺序：
          <input name="sortrank" type='text' value="50">
      </p>
 </div>
  <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true" id="closetype">关闭</button>
    <button class="btn btn-primary" id="subtype">提交</button>
  </div>
</div>
<!--添加栏目弹出框END--> 
<script>
    $('#subtype').click(function(){
        var ishidden = $("input[name='ishidden']:checked").val(),
        typename = $("input[name='typename']").val(),
        pid = $("select[name='pid']").val(),
        sortrank = $("input[name='sortrank']").val();
        var url = "<?php echo __APP__?>/ucenter/article/addtype";
        var data = {'ishidden':ishidden,'typename':typename,'pid':pid,'sortrank':sortrank};
        if($.trim(typename)==='' || $.trim(pid)==='' || $.trim(sortrank)===''){
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
    //删除栏目
    $('.deltype').click(function(){
        return confirm('确定要删除？');
        var self = $(this);
        var typeid = self.parent('li').attr('id'),
            url = "<?php echo __APP__?>/ucenter/article/deltype",
            data = {'typeid':typeid};
        $.post(url,data,function(rs){
            if(rs=='ok'){
                self.parents('.m_typebox').remove();
                $('.alert').show();
            }
        });
    });
    //添加栏目时获取所有分类栏目接口
    $('#addtypebtn').click(function(){
        var html = '<option value="0" depth="0">顶级栏目</option>';
        var url = '<?php echo __APP__?>/ucenter/article/type';
        $.ajax({
            type: 'POST',
            url : url,
            data : {'flag':'api'},
            success:function(rs){
                for (var i in rs){
                    html += '<option value="'+rs[i].id+'.'+rs[i].depth+'">'+padMark(rs[i].typename,'&emsp;',rs[i].depth)+'</option>';
                }
                $('select[name="pid"]').html(html);
            },
            dataType:'JSON'
        });
    });
    //通过pid获取子类栏目
    $('.childimgs').click(function(){
            var self = $(this).parent('span').parent('li'),
                pid = self.attr('id'),
                url = '<?php echo __APP__?>/ucenter/article/childtype';
            if(self.hasClass('on')){
                self.removeClass('on');
                self.siblings('li').css('display','none');
            }else{
                $.ajax({
                type: 'POST',
                url : url,
                data : {'pid':pid},
                success:function(rs){
                    self.addClass('on');
                    self.after(rs);
                },
                dataType:'HTML'
            });
        }
    });
    var flag = false;
    function getChildType(obj){
        var self = obj.parent('span').parent('li'),
            pid = self.attr('id'),
            url = '<?php echo __APP__?>/ucenter/article/childtype';
            if(self.hasClass('on')){
                    self.removeClass('on');
                    self.siblings('li').css('display','none');
                    obj.attr('src','/assets/manager/images/openimg.png');
                    flag=false;
                }else{
                    obj.attr('src','/assets/manager/images/closeimg.png')
                    $.ajax({
                    type: 'POST',
                    url : url,
//                    beforeSend:function(jqXHR,settings){
//                        console.log(jqXHR);
//                        if(arr[0]){
//                        alert(1);
//                        arr[0].abort();
//                    }
//	               arr[0]=jqXHR;
//                    },
                    data : {'pid':pid},
                    success:function(rs){
                        self.addClass('on');
                        self.after(rs);
                    },
                    dataType:'HTML'
                });
                
            }
    }
    //填充字符
    function padMark(str,mark,num){
        var oldstr = str;
        for(var i=0;i<num;i++){
            oldstr =mark+oldstr;
        }
        return oldstr;
    }
</script>
