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
    .noborder{
        border:none;
    }
    .info td{
        font-family: 微软雅黑;
        font-weight: bolder;
    }
</style>
<ul class="breadcrumb">
    <li><a href="/">首页</a> > </li>
    <li><a href="<?php echo __APP__?>/manager/default/type">网站栏目管理</a> > <?php echo $typename;?></li>
    <li style="position: absolute;right:17px;top:-3px;">
        <div class="btn-toolbar">
            <div class="btn-group">
                <a class="btn btn-mini" role="button" href="<?php echo __APP__?>/manager/default/addarchives?typeid=<?php echo $_GET['typeid']?>" data-toggle="modal">添加文档</a>
            </div>
        </div>
    </li>
</ul>
<div class="alert alert-info" style="margin-left:17px;margin-right: 17px;margin-bottom:14px;display: none;">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>操作成功！</strong>
</div>
<!--列表详情层-->
<div class='m_listwraper'>
    <div class="m_typebox noborder">
                <table class="table">
                    <tr class="info">
                        <td>文章ID</td>
                        <td>文章标题</td>
                        <td>更新时间</td>
                        <td>发布人</td>
                        <td>操作</td>
                    </tr>
                    <?php foreach($archives as $archive):?>
                    <tr style="width: 100%;">
                        <td><?php echo $archive['id']?></td>
                        <td><?php echo $archive['title']?></td>
                        <td><?php echo date("Y-m-d H:i",$archive['pubdate'])?></td>
                        <td><?php echo $archive['writer']?></td>
                        <td>
                            <a href="<?php echo __APP__?>/manager/default/editarchives?arcid=<?php echo $archive['id'].'?'.rand(0,99);?>">修改</a> 
                            <a href="<?php echo __APP__?>/manager/default/changetype?arcid=<?php echo $archive['id'];?>">移动</a> 
                            <a href="<?php echo __APP__?>/manager/default/delarchives?typeid=<?php echo $archive['typeid'];?>&arcid=<?php echo $archive['id'];?>" onclick="return confirm('确定删除本条记录？');">删除</a> 
                        </td>
                    </tr>
                    <?php endforeach;?>
                </table>
    </div>
</div>
<!--列表详情层END-->

<script>
    $('#subtype').click(function(){
        var ishidden = $("input[name='ishidden']:checked").val(),
        typename = $("input[name='typename']").val(),
        modeltype = $("select[name='modeltype']").val(),
        sortrank = $("input[name='sortrank']").val();
        var url = "<?php echo __APP__?>/manager/default/addtype";
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
            url = "<?php echo __APP__?>/manager/default/deltype",
            data = {'typeid':typeid};
        $.post(url,data,function(rs){
            if(rs=='ok'){
                self.parents('.m_typebox').remove();
                $('.alert').show();
            }
        });
    });
</script>
