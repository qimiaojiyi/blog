<?php //var_dump($this->ctrlpanel);?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>后台总管理</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="<?php echo __MANSRC__?>/lib/bootstrap/css/bootstrap.min.css">
    
    <link rel="stylesheet" type="text/css" href="<?php echo __MANSRC__?>/stylesheets/theme.css">
    <link rel="stylesheet" type="text/css" href="<?php echo __MANSRC__?>/stylesheets/minestyle.css">

    <script src="<?php echo __MANSRC__?>/lib/jquery-1.7.2.min.js" type="text/javascript"></script>

    <!-- Demo page code -->

    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #FFFFFF;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: normal;
        }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="<?php echo __MANSRC__;?>/lib/html5.js"></script>
    <![endif]-->
  </head>

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body class=""> 
  <!--<![endif]-->
    
    <div class="navbar">
        <div class="navbar-inner">
                <ul class="nav pull-right">
                    
                    <li><a href="#" class="hidden-phone visible-tablet visible-desktop" role="button">当前用户：</a></li>
                    <li id="fat-menu" class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user"></i><?php echo Yii::app()->session['admininfo']['uname'];?>
                            <i class="icon-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="#">我的帐号</a></li>
                            <li class="divider"></li>
                            <li><a tabindex="-1" class="visible-phone" href="#">设置</a></li>
                            <li class="divider visible-phone"></li>
                            <li><a tabindex="-1" href='/manager/admin/logout'>退出</a></li>
                        </ul>
                    </li>
                    
                </ul>
                <a class="brand" href="index.html"><span class="first">网展</span> <span class="second">后台管理系统</span></a>
        </div>
    </div>
    


    
    <div class="sidebar-nav">
        <!--总管理权限，系统用户相关管理-->
        <a href="#dashboard-admin" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i>模块管理</a>
        <ul id="dashboard-admin" class="nav nav-list collapse in">
            <li><i class="mine-icon"></i><a href="<?php echo __APP__?>/manager/panel/list">模块列表</a></li>
            <li><i class="mine-icon"></i><a href="<?php echo __APP__?>/manager/panel/add">添加模块</a></li>
        </ul>
        <a href="#dashboard-group" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i>分组管理</a>
        <ul id="dashboard-group" class="nav nav-list collapse in">
            <li><i class="mine-icon"></i><a href="<?php echo __APP__?>/manager/ucenter/list">用户组列表</a></li>
            <li><i class="mine-icon"></i><a href="<?php echo __APP__?>/manager/ucenter/add">添加用户组</a></li>
            <li><i class="mine-icon"></i><a href="<?php echo __APP__?>/manager/ucenter/security">安全中心</a></li>
        </ul>
    </div>
    <div class="content">
        <?php echo $content;?>
<!--footer        <div class="container-fluid">
            <div class="row-fluid">
            <footer>
                <hr>
                 Purchase a site license to remove this link from the footer: http://www.portnine.com/bootstrap-themes 
                <p class="pull-right">A <a href="http://www.portnine.com/bootstrap-themes" target="_blank">Free Bootstrap Theme</a> by <a href="http://www.portnine.com" target="_blank">Portnine</a></p>

                <p>&copy; 2012 <a href="http://www.portnine.com" target="_blank">Portnine</a></p>
            </footer>
                    
            </div>
        </div>-->
    </div>
    


    <script src="<?php echo __MANSRC__?>/lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
  </body>
</html>
