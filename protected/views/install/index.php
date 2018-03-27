<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <title>开始安装-后台管理系统</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="<?php echo __MANSRC__;?>/lib/bootstrap/css/bootstrap.min.css">
    
    <link rel="stylesheet" type="text/css" href="<?php echo __MANSRC__;?>/stylesheets/theme.css">

    <script src="<?php echo __MANSRC__;?>/lib/jquery-1.8.1.min.js" type="text/javascript"></script>

    <!-- Demo page code -->

    <style type="text/css">
        body{
            font-family: 微软雅黑;
        }
        form{
            border-radius: 10px;
            border:1px solid #ccc;
            padding: 30px;
            background: #fff;
            width: 450px;
            margin: 20px auto;
        }
        h3{
            font-weight: normal;
            font-size: 15px;
        }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="<?php echo __MANSRC__;?>/lib/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    </head>

    <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
    <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
    <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
    <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
    <!--[if (gt IE 9)|!(IE)]><!--> 
    <body class=""> 
    <!--<![endif]-->
    <div class="contain">
        <div class="cols-xs-1">
            <form class="form-horizontal" method="post" action="<?php echo __APP__?>/install/processing">
            <h3>数据库设置</h3>
            <div class="control-group">
                <label class="control-label" for="dbaddr">数据库地址：</label>
                <div class="controls">
                    <input type="text" name='dbaddr' id="dbaddr" value="localhost" placeholder="默认请填localhost">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="dbuser">数据库用户：</label>
                <div class="controls">
                    <input type="text" name='dbuser' value="root" id="dbuser" placeholder="默认请填root">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="dbpwd">数据库密码：</label>
                <div class="controls">
                    <input type="password" name='dbpwd' id="dbpwd" placeholder="若为空请不要填写">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="dbprefix">数据表前缀：</label>
                <div class="controls">
                    <input type="text" name='dbprefix' id="dbprefix" placeholder="请填写您想设置的表前缀">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="dbname">数据库名称：</label>
                <div class="controls">
                    <input type="text" name='dbname' id="dbname" placeholder="请填写您想创建的表前缀">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="dbchar">数据库编码：</label>
                <div class="controls">
                    <input class="checkbox" type="checkbox" id="dbchar" checked="checked" disabled="disabled"> utf8
                </div>
            </div>
            <h3>管理员登录设置</h3>
            <div class="control-group">
                <label class="control-label" for="uname">用户名：</label>
                <div class="controls">
                    <input type="text" name='uname' id="uname" value="admin" placeholder="请填写管理员密码">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="upwd">密 码：</label>
                <div class="controls">
                    <input type="password" name='upwd' id="upwd" placeholder="后台管理登录密码且必须填写">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn">开始安装</button>
                </div>
            </div>
        </form>
        </div>
    </body>
</html>


