    <input type="file" id="pic" name="pic">
    <p><img id="img1" alt="上传成功啦" src="" /></p>
    <input type="submit" value="提交">

<script src="<?php echo __MANSRC__?>/lib/jquery-1.8.1.min.js"></script>
<script src="<?php echo __MANSRC__?>/lib/ajaxfileupload.js"></script>
<script>
        $(function () {
            $("input[name='pic']").click(function () {
                ajaxFileUpload();
            });
        });
        function ajaxFileUpload() {
            $.ajaxFileUpload
            (
                {
                    url: '<?php echo __APP__?>/manager/default/showform', //用于文件上传的服务器端请求地址
                    secureuri: false, //是否需要安全协议，一般设置为false
                    fileElementId: 'pic', //文件上传域的ID
                    dataType: 'JSON', //返回值类型 一般设置为json
                    success: function (data)  //服务器成功响应处理函数
                    {
                        alert(data);
                    },
                }
            );
            return false;
        }
</script>