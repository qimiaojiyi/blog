<link rel="stylesheet" href="<?php echo __HOMESRC__?>/imgcut/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo __HOMESRC__?>/imgcut/css/tether.min.css">
<link rel="stylesheet" href="<?php echo __HOMESRC__?>/imgcut/dist/cropper.css">
<link rel="stylesheet" href="<?php echo __HOMESRC__?>/css/cut_main.css">
<ul class="breadcrumb">
    <li><a href="#">个人中心</a> > </li>
    <li>账号信息</li>
</ul>
<div class='m_listwraper'>
    <div class="add_typebox">
        <form action="<?php echo __APP__?>/ucenter/role/edituser" method="post">
        <ul class="padding17">
            <li style="font-size: 14px;line-height: 25px;">
                <p>
                    当前图像：<img id="avatar" src="<?php echo empty($userinfo['avatar']) ? __HOMESRC__.'/img/defaut_userlogo.jpg' : $userinfo['avatar'];?>" style="width:72px;"> [<a id="changeavatar" href="#">修改</a>]
                </p>
                <p>用户名：<?php echo Yii::app()->session['userinfo']['uname'];?></p>
                <p>所属组：<?php echo Yii::app()->session['userinfo']['groupname']?></p>
                <p>密&emsp;码：<input type="password" value="******" disabled="disabled" id="password" placeholder="留空表示不修改"> [<span><a href="javascript:;" id="editpwd">修改</a>]</span></p>
            </li>
        </ul>
        </form>
    </div>
    <div id="avatarwrap" class="add_typebox" style="display: none">
        <ul class="padding17">
            <li style="font-size: 14px;line-height: 25px;">
                <p>
                    <form id="avatarform" enctype="multipart/form-data">
                    <label class="btn" for="inputImage" title="Upload image file">
                        <!--<input type="file" class="sr-onlys" id="inputImage" name="file" accept="image/*">-->
                        <input type="file" id="inputImage" name="thumb" style="display:none">
                        <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="Import image with Blob URLs">
                            上传图片 <span class="fa fa-upload"></span>
                        </span>
                    </label><span style="color:#ccc;"> (支持png、gif、jpg格式)</span>
                    </form>
                </p>
                <!-- <h3 class="page-header">Demo:</h3> -->
                <div class="img-container" style="float:left;margin-right: 10px;">
                    <img id="image" src="<?php echo __HOMESRC__?>/imgcut/images/picture.jpg" style="opacity:0">
                </div>
                <!-- <h3 class="page-header">Preview:</h3> -->
                <div class="docs-preview clearfix" style="float:left;">
                    <div class="img-preview preview-lg"></div>
                    <div class="img-preview preview-md"></div>
                    <div class="img-preview preview-sm"></div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-9 docs-buttons">
                    <div class="btn-group">
                        <a class="btn" href="javascript:;" id="baocun">保存 <span class="fa fa-check"></span></a>
                        <a class="btn" href="javascript:;" id="chongzhi">重置 <span class="fa fa-refresh"></span></a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- Scripts -->
<script src="<?php echo __HOMESRC__?>/imgcut/js/tether.min.js"></script>
<script src="<?php echo __HOMESRC__?>/imgcut/dist/cropper.js"></script>
<script src="<?php echo __HOMESRC__?>/js/cut_main.js"></script>