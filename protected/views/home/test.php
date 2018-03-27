DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>js 实现图片预加载 加载完后执行动作</title>
</head>
<body>
<a href='javascript:;' onclick='alert(1)'>click</a>
</body>

<script type="text/javascript">
    function preLoadImg(url) {
        var img = new Image();
        img.src = url;
        console.log(img);
    }
    preLoadImg('http://www.qimiaojiyi.com/uploads/test.jpeg');
</script>


