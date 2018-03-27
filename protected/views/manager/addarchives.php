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
    <li><a href="<?php echo __APP__?>/manager/type">网站栏目管理</a> ></li>
    <li style="position: absolute;right:17px;top:-3px;">
        <div class="btn-toolbar">
            <div class="btn-group">
                <a class="btn btn-mini" role="button" href="<?php echo __APP__?>/manager/addarchives?typeid=<?php echo $_GET['typeid'];?>" data-toggle="modal">编辑文档</a>
            </div>
        </div>
    </li>
</ul>
<div class="alert alert-info" style="margin-left:17px;margin-right: 17px;margin-bottom:14px;display: none;">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>操作成功！</strong>
</div>
<!--添加文章层-->
    <div class="m_typebox">
        <ul class="padding17">
            <li style="font-size: 14px;line-height: 25px;">
            <p>
                文章标题：
                <input name="typename" type='text'>
            </p>
            <p>
                定义属性：
            	<input class="checkbox" type="checkbox" name="flags[]" id="flagsh" value="h">头条[h]
                <input class="checkbox" type="checkbox" name="flags[]" id="flagsc" value="c">推荐[c]
                <input class="checkbox" type="checkbox" name="flags[]" id="flagsp" value="p">图片[p]
            </p>
            <p>
                所属栏目：
                <select name="modeltype">
                    <option value="1">普通模型</option>
                </select>
            </p>
            <p>
                缩  略 图 ：
                <input type="file">
            </p>
            <p>
                文章内容：
                <input name="sortrank" type='text' value="50">
            </p>
            </li>
        </ul>
        
    </div>
<!--添加文章END-->

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
            url = "<?php echo __APP__?>/manager/Deltype",
            data = {'typeid':typeid};
        $.post(url,data,function(rs){
            if(rs=='ok'){
                self.parents('.m_typebox').remove();
                $('.alert').show();
            }
        });
    });
</script>
