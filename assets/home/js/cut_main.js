window.onload = function () {
    var URL = window.URL || window.webkitURL;
    'use strict';
    var image = document.getElementById('image');
    var options = {
        aspectRatio: 1 / 1,
        preview: '.img-preview',
        viewMode:1,
        dragMode : 'move',
        crop: function(e) {
//            console.log(e.detail.x);
//            console.log(e.detail.y);
//            console.log(e.detail.width);
//            console.log(e.detail.height);
//            console.log(e.detail.rotate);
//            console.log(e.detail.scaleX);
//            console.log(e.detail.scaleY);
        }
    };
    var cropper = new Cropper(image, options);
    var uploadedImageURL ;
    // Import image
    var inputImage = document.getElementById('inputImage');

    if (URL) {
        inputImage.onchange = function () {
            var files = this.files;
            var file;
            if (cropper && files && files.length) {
                file = files[0];
                if (/^image\/\w+/.test(file.type)) {
                    image.src = uploadedImageURL = URL.createObjectURL(file);
                    cropper.destroy();
                    cropper = new Cropper(image, options);
                    //inputImage.value = null;
                } else {
                    window.alert('Please choose an image file.');
                }
            }
        };
    } else {
        inputImage.disabled = true;
        inputImage.parentNode.className += ' disabled';
    }
    //重置
    var refresh = document.getElementById('chongzhi');
    refresh.onclick = function(){
        cropper.reset();
    };
    //发送数据
    var getData = document.getElementById('baocun');
    // Use `jQuery.ajax` method
    getData.onclick = function(){
        var avatar = $('#avatar');
        var formData = new FormData($( "#avatarform" )[0]);
        var imgData = cropper.getData();
        formData.append('height',imgData.height);
        formData.append('width',imgData.width);
        formData.append('x',imgData.x);
        formData.append('y',imgData.y);
        $.ajax({  
             url: '/ucenter/role/setprofile' ,  
             type: 'POST',  
             data: formData,
             async: false,  
             cache: false,  
             contentType: false,  
             processData: false,  
             success: function (returndata) {
                 if(returndata == 'empty'){
                     alert('未选择图像');
                 }else if(returndata){
                     avatar.attr('src',returndata+'?'+Math.random());
                     $('#avatarwrap').attr('style','display:none');
                 }else{
                     console.log('fail');
                 }
                 //console.log(returndata);
                 
             },  
             error: function (returndata) {  
                 console.log(returndata);  
             }  
        });  
    };
    $('#changeavatar').click(function(){
        $('#avatarwrap').attr('style','display:block');
        cropper.destroy();
        cropper = new Cropper(image, options);
        cropper.crop();
    });
};
//修改密码
var pwdbtn = $('#password');
var editpwd = $('#editpwd');
var url = '/ucenter/role/edituser';
pwdbtn.next('span').click(function(){
    pwdbtn.attr('disabled',false);
    if(editpwd.text()=='修改'){
        pwdbtn.select();
    }
    if(editpwd.text()=='保存'){
        var data = {'ajax':'ajax','password':pwdbtn.val()};
        $.post(url,data,function(rs){
            if(rs=='ok'){
                alert('密码修改成功');
                pwdbtn.attr('value','******');
                pwdbtn.attr('disabled','disable');
            }else{
                pwdbtn.attr('value','******');
                pwdbtn.attr('disabled','disable');
                editpwd.text('修改');
                alert('密码未修改');
            }
        });
    }else{
        editpwd.text('保存');
    }
});