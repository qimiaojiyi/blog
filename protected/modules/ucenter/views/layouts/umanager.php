<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>用户中心管理</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/bootstrap/2.1.1/css/bootstrap.css">
    
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
                    <li style="color:#fff;line-height: 40px;padding-left: 10px;padding-right: 10px;"><img src="<?php echo __HOMESRC__?>/img/grouplogo.png" style="width:20px;">&nbsp;&nbsp;<?php echo Yii::app()->session['userinfo']['groupname']?></li>
                    <li id="fat-menu" class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user"></i><img src="<?php echo isset(Yii::app()->session['userinfo']['avatar']) ? Yii::app()->session['userinfo']['avatar'] :  __HOMESRC__.'/img/defaut_userlogo.jpg';?>" style="width:20px;">&nbsp;&nbsp;<?php echo Yii::app()->session['userinfo']['uname'];?>
                            <i class="icon-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="/ucenter/role/edituser?uid=<?php echo Yii::app()->session['userinfo']['uid'].'?'.rand(0,99);?>">我的账号</a></li>
                            <li class="divider"></li>
<!--                            <li><a tabindex="-1" class="visible-phone" href="#">设置</a></li>
                            <li class="divider visible-phone"></li>-->
                            <li><a tabindex="-1" href='/ucenter/user/logout'>退出</a></li>
                        </ul>
                    </li>
                    
                </ul>
                <a class="brand" href="index.html">
                    <span class="first">7s</span>
                    <span class="second">用户管理中心</span>
                </a>
        </div>
    </div>
    


    
    <div class="sidebar-nav">
        <?php foreach ($this->ctrlpanel as $v):?>
        <a href="#dashboard-<?php echo $v['panelpath']?>" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i><?php echo $v['panelname']?></a>
        <ul id="dashboard-<?php echo $v['panelpath']?>" class="nav nav-list collapse in">
            <?php foreach($v['children'] as $v1):?>
            <li><i class="mine-icon"></i><a href="<?php echo __APP__.'/ucenter/'.$v1['panelpath'];?>"><?php echo $v1['panelname']?></a></li>
            <?php endforeach;?>
        </ul>
        <?php endforeach;?>
    </div>
    <div class="content">
        <?php echo $content;?>
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
