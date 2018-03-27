<script type="text/javascript" charset="utf-8" src="<?php echo __APP__?>/assets/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo __APP__?>/assets/ueditor/ueditor.all.min.js"></script>
<ul class="breadcrumb">
    <li><a href="/">首页</a> > </li>
    <li><a href="<?php echo __APP__?>/ucenter/article/type">文章分类</a> > <a href="<?php echo __APP__?>/ucenter/article/articlelist?typeid=<?php echo isset($_GET['typeid']) ? $_GET['typeid'] : '';?>"><?php if(isset($breadcrumbs))echo $breadcrumbs;?></a>>添加文档</li>
    <li style="position: absolute;right:17px;top:-3px;">
        <div class="btn-toolbar">
            <div class="btn-group">
                <!--<a class="btn btn-mini" role="button" href="<?php echo __APP__?>/manager/default/addarchives?typeid=<?php //echo $_GET['typeid'];?>" data-toggle="modal">编辑文档</a>-->
            </div>
        </div>
    </li>
</ul>
<div class="alert alert-info" style="margin-left:17px;margin-right: 17px;margin-bottom:14px;display: none;">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>操作成功！</strong>
</div>
<!--添加文章层-->
    <div class="m_typebox noborder">
        <form action="<?php echo __APP__?>/ucenter/article/addarticle" method="post" name="addform" enctype="multipart/form-data">
        <ul class="padding17">
            <li style="font-size: 14px;line-height: 25px;">
            <p>
                <?php if(isset($_GET['typeid'])):?>
                <input type="hidden" name="typeid" value="<?php echo $_GET['typeid'];?>">
                <?php endif;?>
                文章标题：
                <input name="title" type='text'>
                &nbsp;&nbsp;
                定义属性：
                <input class="checkbox" type="radio" name="flag" value="h">头条[h]
                <input class="checkbox" type="radio" name="flag" value="c">推荐[c]
                <input class="checkbox" type="radio" name="flag" value="p">图片[p]
            </p>
            <?php if(!isset($_GET['typeid'])):?>
            <p>
                选择分类：
                <select name="typeid">
                    <?php foreach($types as $type):?>
                    <option value="<?php echo $type['id']?>"><?php echo str_repeat('&emsp;', $type['depth']),$type['typename']?></option>
                    <?php endforeach;?>
                </select>
            </p>
            <?php endif;?>
                文章图片：
                <div id="imagePreview" style="display:inline-block;cursor: pointer;width:100px;height:75px;border:1px solid #ccc;margin-bottom: 17px;border-radius: 3px;text-align: center;line-height: 75px;color:#ccc;font-size: 14px;">
                   +点击上传
                </div>
                <input type="file" id="imageInput" name="thumb" style="display:none">
            <p>
                文章内容：
                <script id="editor" name="ucontent" type="text/plain" style="width:90%;height:300px;margin-left: 74px;"></script>

            </p>
            </li>
        </ul>
            <input type="submit" name="subtn" value="发布文档" class="btn" style="margin-left: 75px;">
        </form>
    </div>
<!--添加文章END-->

<script>
    $(document).ready(function(){
            var ue = UE.getEditor('editor');
    });

    $('#subtype').click(function(){
        var ishidden = $("input[name='ishidden']:checked").val(),
        typename = $("input[name='typename']").val(),
        modeltype = $("select[name='modeltype']").val(),
        sortrank = $("input[name='sortrank']").val();
        var url = "<?php echo __APP__?>/ucenter/article/addtype";
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
    //上传缩略图
    $('#imagePreview').click(function(){
        $("input[name='thumb']").trigger('click');
        $('input[name="thumb"]').change(function(){
            loadImageFile();
        });
    });
    //获取客户端文件路径在不上传的条件下生成预览
    var loadImageFile =(function() {
    if (window.FileReader) {
        var oPreviewImg = null, oFReader = new window.FileReader(),
        rFilter = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;

        oFReader.onload = function (oFREvent) {
        if (!oPreviewImg) {
            var newPreview = document.getElementById("imagePreview");
            oPreviewImg = new Image();
            oPreviewImg.style.position='relative';
            oPreviewImg.style.width = (newPreview.offsetWidth).toString() + "px";
            oPreviewImg.style.height = (newPreview.offsetHeight).toString() + "px";
            newPreview.innerHTML='';
            newPreview.appendChild(oPreviewImg);
        }
        oPreviewImg.src = oFREvent.target.result;
        };

        return function () {
        var aFiles = document.getElementById("imageInput").files;
        if (aFiles.length === 0) { return; }
        if (!rFilter.test(aFiles[0].type)) { 
            alert("You must select a valid image file!"); return; 
        }
            oFReader.readAsDataURL(aFiles[0]);
        };
    }
    if (navigator.appName === "Microsoft Internet Explorer") {
        return function () {
        //alert(document.getElementById("imageInput").value);
        document.getElementById("imagePreview").filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = document.getElementById("imageInput").value;
        };
    }
})(); 
</script>
