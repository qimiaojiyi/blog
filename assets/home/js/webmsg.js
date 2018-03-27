// qq*********************************************************************************************
//调用QC.Login方法，指定btnId参数将按钮绑定在容器节点中
   QC.Login({
       //btnId：插入按钮的节点id，必选
       btnId:"qqLoginBtn",    
       //用户需要确认的scope授权项，可选，默认all
       scope:"all",
       //按钮尺寸，可用值[A_XL| A_L| A_M| A_S|  B_M| B_S| C_S]，可选，默认B_S
       size: "C_S"
   }, function(reqData, opts){//登录成功
       //根据返回数据，更换按钮显示状态方法
      QC.Login.getMe(function(openId, accessToken){
         openIds=openId;
         accessTokens=accessToken;
      })
      $("._personShow img").attr("src",reqData.figureurl_1);
      qqsrc=reqData.figureurl_1;
      nickname=reqData.nickname;
      $("._personShow span").css("display","block");
      $(".qqlogout").css("display","block");
   }, function(opts){//注销成功
         $("._personShow img").attr("src","/assets/home/img/default.jpg");
         alert('QQ登录 注销成功');
   }
);
//退出登录
$("._personShow span").click(function(){
   QC.Login.signOut();
   $(this).css("display","none");
});
$(".qqlogout").click(function(){
   QC.Login.signOut();
   $(this).css("display","none");
});
//留言
  $(".commentSbmit .shengMessage,.items-content .send").click(function(){
      document.getElementById("qqLoginBtn").click();
      //监测登录状态,成功返回true
      var login=QC.Login.check();
      if(!login){
              $("#qqLoginBtn a").click();
      }else{
        //提交留言，并显示
        var value=$(".myself textarea").prop("value");
        //如果为空，禁止添加
        value=trim(value);
        if(value==""){
          return;
        }
        $(".myself textarea").prop("value","");
        $.ajax({
              url:"/home/qqlogin",
              type:"post",
              data:{accesstoken:accessTokens,openid:openIds,content:value,arcid:articleId},
              success:function(data){
              //xss过滤
              value = filterXSS(value); 
              // ********************************************
                  // 转换图片
                  value=changeImg(value);
                  var str="<li class='shengReply'><ul class='person' id="+data+"><li class='picture'><img src="+qqsrc+" width='45px' height='45px'></li><li class='commentNews'><p class='name1'>"+nickname+"</p><p class='speak1'>"+value+"</p><p class='detailed1'><span>刚刚</span><span class='huifu'><span class='icon1'></span><span>回复(<a href='javascript:void(0);' dataFlag='true'>0</a>)</span></span><span class='agree'><span class='icon2'></span><span>顶(<a href='javascript:void(0)' dataFlag='true'>0</a>)</span></span></p></li><div class='clearfloat'></div></ul></li>";
                  $(".commentList").prepend(str);
              },
              error:function(){
                alert("失败");
              }
        })
      }
  });
  //绑定头像登录
  $("._personShow img").click(function(){
      var login=QC.Login.check();
      if(!login){
              $("#qqLoginBtn a").click();
      }
  });
  $(".commentList").delegate("._personShow img","click",function(){
      var login=QC.Login.check();
      if(!login){
              $("#qqLoginBtn a").click();
      }
  });
// ***********************************************************************************************
// 留言分页
var loadFlag=true;//函数开关
function loadMore(){
      if(!loadFlag){
        return;
      }
      var page=++pageAdd; 
      var str="";
      loadFlag=false;
      $.ajax({
           url:"/home/getmessage",
           type:"post",
           data:{page:page,arcid:articleId},
           // datatype:"json",
           success:function(data){
               if(data.length==0){
               	   $("._LookMore").text("已经在最底部...");
               	   return;
               }
               var length=0;
               if(data.children){
                    length=data.children.length;
               }
               length+=data.length;
               if(length>=5){
               	   $("._LookMore").css("display","block");
               }
               for(var i in data){
                  var content=changeImg(data[i].content);
                  str+="<li style='margin-left:"+data[i].level*40+"px' class='shengReply'><ul class='person' id='"+data[i].id+"'><li class='picture'><img src='"+data[i].qqfigureurl+"' width='45px'></li><li class='commentNews'><p class='name1'>"+data[i].qqnickname+"</p><p class='speak1'>"+content+"</p><p class='detailed1'><span>"+data[i].addtime+"</span><span class='huifu'><span class='icon1'></span><span>回复</span></span><span class='agree'><span class='icon2'></span><span>顶(<a href='javascript:void(0)'>"+data[i].click+"</a>)</span></span></p></li><div class='clearfloat'></div></ul></li>";
                  var children=data[i].children;
                  if(children){
                  	for(var j in children){
                        var contents=changeImg(children[j].content);
                  		str+="<li style='margin-left:"+(children[j].level+1)*40+"px' class='shengReply'><ul class='person' id='"+children[j].id+"'><li class='picture'><img src='"+children[j].qqfigureurl+"' width='35px'></li><li class='commentNews'><p class='name1'>"+children[j].qqnickname+"</p><p class='speak1'>"+contents+"</p><p class='detailed1'><span>"+children[j].addtime+"</span><span class='huifu'><span class='icon1'></span><span>回复</span></span><span class='agree'><span class='icon2'></span><span>顶(<a href='javascript:void(0)'>"+children[j].click+"</a>)</span></span></p></li><div class='clearfloat'></div></ul></li>"
                  	}
                  }
               }
               loadFlag=true;
               $(".commentList").append(str);
           }
       });
};
// 初始化页面*****************commentList类名是唯一的，只允许出现在文章页
if($(".commentList").length!=0){
	loadMore();
}
//点击加载
$("._LookMore").click(function(){
       loadMore();
});