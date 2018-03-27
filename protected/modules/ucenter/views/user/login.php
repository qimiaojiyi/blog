<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>管理员登陆</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/bootstrap/2.1.1/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo __MANSRC__?>/stylesheets/theme.css">
    <script src="https://cdn.bootcss.com/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="<?php echo __MANSRC__;?>/lib/html5.js"></script>
    <![endif]-->
    <style>
        body{
            background: #eee;
        }
        form{
            background-color: #fff;
            border:1px solid #ccc;
            width: 550px;
            margin: 15% auto;
        }
    </style>
    </head>
    <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
    <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
    <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
    <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
    <!--[if (gt IE 9)|!(IE)]><!--> 
    <body class=""> 
    <!--<![endif]-->
    <script src="https://cdn.bootcss.com/bootstrap/2.1.1/bootstrap.js"></script>
    <div class="container">
        <form class="form-horizontal" method="post">
            <p class="block-heading">用户中心登录</p>
            <div class="control-group" style="margin-top:20px;">
                <label class="control-label" for="inputID">组编号</label>
                <div class="controls">
                    <input name="groupid" type="text" placeholder="组编号">
                </div>
            </div>
            <div class="control-group" style="margin-top:20px;">
                <label class="control-label" for="inputEmail">用户名</label>
                <div class="controls">
                    <input name="username" type="text" placeholder="管理员名">
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputPassword">密码</label>
              <div class="controls">
                <input name="password" type="password"  placeholder="登陆密码">
              </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPassword">验证码</label>
                <div class="controls">
                    <input name="verifycode" type="text" placeholder="请输入右边的字符" style="width:120px;">
                        <?php $this->widget('CCaptcha',array(
                            'showRefreshButton'=>true,
                            'clickableImage'=>true,
                            'buttonLabel'=>'看不清？',
                            'imageOptions'=>array(
                                'id'=>'code',
                                'alt'=>'点击换图',
                                'title'=>'点击换图',
                                'style'=>'cursor:pointer;height:35px',
                                'padding'=>'10')
                            )); 
                        ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <a id="checklogin" class="btn">登陆</a>
                </div>
            </div>
        </form>
    </div>
    <script>
        $(".container").keydown(function(event) {
            if (event.keyCode == "13") {
                $('#checklogin').click();
            };
        });
        $('#checklogin').click(function(){
            var url = "<?php echo __APP__?>/ucenter/user/checklogin",
                groupid = $("input[name='groupid']").val(),
                username = $("input[name='username']").val(),
                password = $("input[name='password']").val(),
                verifycode = $("input[name='verifycode']").val();
            if(checkInput('code',verifycode)){return false;}
            if(checkInput('admin',username)){return false;}
            if(checkInput('admin',password)){return false;}
            $.post(url,{'groupid':groupid,'username':username,'password':password,'verifycode':verifycode},function(rs){
                if(rs == 'errorcode'){
                    alert('验证码不正确');
                    $('#code').click();
                }else if(rs == 'erroruser'){
                    alert('组编号、用户名、密码不匹配');
                }else{
                    window.location.href="<?php echo __APP__?>/ucenter/article/type";
                }
            });
        });
        function checkInput(type,obj){
            if(type=='code'){
                if($.trim(obj)==''){
                    $("input[name='verifycode']").attr('style','width:120px;border:1px solid #FF0000;').focusin(function(){
                        $("input[name='verifycode']").attr('style','width:120px');
                    });
                    return true;
                }else{
                    return false;
                }
            }else{
                if($.trim(obj)==''){
                    $("input[name='username'],input[name='password']").attr('style','border:1px solid #FF0000;').focusin(function(){
                        $(this).attr('style','');
                    });
                    return true;
                }else{
                    return false;
                }
            }
        }
    </script>
</body>
</html>
