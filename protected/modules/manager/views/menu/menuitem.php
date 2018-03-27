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
     .info td{
        text-align: center;
        font-weight: bolder;
    }
    .cur{
        cursor:pointer;
        color: #0081c2;
    }
</style>
<ul class="breadcrumb">
    <li><a href="/">首页</a> > </li>
    <li>菜单管理 > <?php echo $menuname;?></li>
</ul>
<div class="alert alert-info" style="margin-left:17px;margin-right: 17px;margin-bottom:14px;display: none;">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>操作成功！</strong>
</div>
<!--列表层-->
<div class='m_typebox noborder'>
    <form style="display:inline-block;margin-right: 40px;">
        <input type="text" placeholder="查找菜名" style="margin-bottom:0px;width: 260px">
        <input type="submit" class="btn btn-inverse" value="查找">
    </form>
    <table class="table table-striped table-bordered table-responsive">
        <tr class="info">
            <td>序号</td>
            <td>菜名</td>
            <td>原价</td>
            <td>现价</td>
            <td>状态</td>
            <td>图片</td>
            <td>操作</td>
        </tr>
        <?php foreach($menuitems as $menuitem):?>
        <tr>
            <td><?php echo $menuitem['menuitemid']?></td>
            <td><?php echo $menuitem['menuitemname']?></td>
            <td><?php echo $menuitem['originalprice']?></td>
            <td><?php echo $menuitem['realprice']?></td>
            <td><?php echo $menuitem['issale']=='1'? '<font color="#66cc33">正常</font>' : '<font color="#ff3333">停售</font>';?></td>
            <td><?php echo $menuitem['photourl']?></td>
            <td>
                <span class="editbtn cur">修改</span>
                <span class="removebtn cur">删除</span>
            </td>
        </tr>
        <?php endforeach;?>
        <!--添加菜品-->
        <tr class="warning">
            <td><input name="menuid" type="hidden" value="<?php echo $menuid;?>"></td>
            <td><input name="menuitemname" type="text" placeholder="请输入菜名" style="margin-top:9px;"></td>
            <td><input name="originalprice" type="text" placeholder="请输入价格" style="margin-top:9px;width:80px;"></td>
            <td><input name="realprice" type="text" placeholder="请输入价格" style="margin-top:9px;width:80px;"></td>
            <td>
                <select name="issale" style="margin-top:9px;width:80px;">
                    <option value="1">正常</option>
                    <option value="0">停售</option>
                </select>
            </td>
            <td><button class="btn" style="margin-top:9px;" disabled="disabled">上传图片</button></td>
            <td><button id="savebtn" class="btn" style="margin-top:9px;">保存</button></td>
        </tr>
        <!--END-->
    </table>
</div>
<!--列表层END-->

<script>
    //添加
    $("#savebtn").click(function(){
        var menuid = $('input[name="menuid"]').val(),
            menuitemname = $('input[name="menuitemname"]').val(),
            originalprice = $('input[name="originalprice"]').val(),
            realprice = $('input[name="realprice"]').val(),
            issale = $('select[name="issale"]').val();
        var url = "<?php echo __APP__?>/manager/menu/addmenuitem";
        if($.trim(menuid)==='' || $.trim(menuitemname)==='' || $.trim(originalprice)==='' || $.trim(realprice)===''){
            alert('菜品信息不能留空');
            return;
        }
        $.ajax({
            type:'POST',
            url:url,
            data:{'menuid':menuid,'menuitemname':menuitemname,'originalprice':originalprice,'realprice':realprice,'issale':issale},
            success:function(rs){
                if(rs=='ok'){
                    alert('添加成功');
                    window.location.reload();
                }else if(rs=='exist'){
                    alert('菜品名已存在');
                }else{
                    alert('添加失败');
                }
            },
            dataType:'HTML'
        });
    });
    //删除
        $('.removebtn').click(function(){
            var self = $(this);
            var menuitemid = self.parent('td').siblings('td:eq(0)').text();
            var menuitemname = self.parent('td').siblings('td:eq(1)').text();
            var url = "<?php echo __APP__?>/manager/menu/delmenuitem";
            if(!confirm('您正在删除：'+menuitemname)){
                return;
            }
            $.post(url,{'menuitemid':menuitemid},function(rs){
                if(rs=='ok'){
                    window.location.reload();
                }
            });
        });
</script>