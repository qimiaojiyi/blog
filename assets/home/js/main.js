var openIds,accessTokens,nickname,qqsrc,articleId;//qq
var pageAdd=0;//留言分页
$(function() { 
    // 导航
    var startLeft=$(".lineOn").position().left;
    $(".lineHover").css({"left":startLeft,"display":"block"});
    $(".nav").hover(function(){
        var left=$(this).position().left;
        $(".lineHover").finish().animate({left:left},600,"easeOutQuint");
    },function(){});
    $(".navBar").hover(function(){},function(){
        $(".lineHover").finish().animate({left:startLeft},600,"easeOutQuint");
    })
    // 分页************************************************************************
    //好像很实用的样子，后端的同学再也不用写分页逻辑了。
    var totals=$(".left").attr("data-total");
    laypage({
        cont: 'biuuu_city',
        pages: totals, //可以叫服务端把总页数放在某一个隐藏域，再获取。假设我们获取到的是18
        curr: function(){ //通过url获取当前页，也可以同上（pages）方式获取
            var page = location.search.match(/page=(\d+)/);
            pageNum=page ? page[1] : 1;
            if(pageNum>totals){
            	pageNum=totals;
            }
            return pageNum;
        }(), 
        jump: function(e, first){ //触发分页后的回调
            if(!first){ //一定要加此判断，否则初始时会无限刷新
                location.href = '?page='+e.curr;
            }
        }
    });
// 点赞 
   var clickFlag,arr=[],article,msgId;
   $(".clicks").click(function(){
        var $obj=$(this).find(".number");
        article=$(this).attr("id"); 
        var strFlag=article+"clickFlag";
        var $title=$(this).find(".title");
        var obj={son:$obj,zanNews:{cookie:strFlag,title:$title}};
        var shengZan=new callback(obj);
        shengZan.zan();
   });
//顶留言
    $(".commentList").delegate(".agree","click",function(){
        var $agree=$(this).find("a");
        var $idParent=$(this).parentsUntil(".shengReply",".person");
        msgId=$idParent.attr("id");
        var dingFlag=msgId+"dingFlag";
        var obj={son:$agree,zanNews:{cookie:dingFlag}};
        var shengAgree=new callback(obj);
        shengAgree.ding();
    });
//************************表情追加对象********************
var TextUtil = {
         insertAtCaret:function(obj, str) {
             if (document.selection) {
                 obj.focus();
                 var sel = document.selection.createRange();
                 sel.text = str;
                 sel.select();
             } else if (typeof obj.selectionStart === 'number' && typeof obj.selectionEnd === 'number') {
                 var startPos = obj.selectionStart,
                 endPos = obj.selectionEnd,
                 cursorPos = startPos,
                 tmpStr = obj.value;
                 obj.value = tmpStr.substring(0, startPos) + str + tmpStr.substring(endPos, tmpStr.length);
                 cursorPos += str.length;
                 obj.selectionStart = obj.selectionEnd = cursorPos;
             } else {
                 obj.value += str;
             }
         },
         moveEnd:function(obj){
              obj.focus();
                 var len = obj.value.length;
                 if (document.selection) {
                     var sel = obj.createTextRange();
                     sel.moveStart('character',len);
                     sel.collapse();
                     sel.select();
                 } else if (typeof obj.selectionStart == 'number' && typeof obj.selectionEnd == 'number') {
                     obj.selectionStart = obj.selectionEnd = len;
                 }
         }
 };
//********************************************************
//回复 
 articleId=$(".onlyId").attr("articleid");//获取文章id
 $(".commentList").delegate(".huifu","click",function(){
      // 找到顶级父容器
      var $ulParent=$(this).parentsUntil(".commentList",".shengReply");
      var $liParent=$(this).parentsUntil(".shengReply",".person");
      // 获取路径
      var shengSrc=$("._personShow img").attr("src");
      var str="<ul class='afterSubmit'><li class='_personShow'><img src="+shengSrc+" /></li><li class='afterMyself'><textarea name='' id='' cols='30' rows='10'></textarea><p class='afterExpression' flag='true'><img src='/assets/home/img/1.jpg'/></p><div class='afterSheng'>发布</div></li><div class='clearfloat'></div></ul>";
      $(".afterSubmit").remove();
      $liParent.append(str);
 });
$(".commentList").delegate(".afterSheng","click",function(){
     var $ulParent=$(this).parentsUntil(".commentList",".shengReply");
     var $liParent=$(this).parentsUntil(".shengReply",".person");
     //获取name
     var atName=$liParent.find(".name1").text();
     var obj={parent:$ulParent,son:$liParent,news:{name:atName}};
     var replay=new callback(obj);
     replay.Reply();
})
// 底部留言表情包
$(".myself p").click(function(){
    $(".bottomReply").toggleClass("shengHidden");
});
$(".bottomReply li").click(function(){
     //获取内容
     var $text=$(".myself textarea");
     var value=$text.prop("value");
     var Expression=$(this).attr("imgNum");
     TextUtil.insertAtCaret($text[0],Expression);
});
// 追加留言表情包
$(".commentList").delegate(".afterExpression","click",function(){
        var shengExpression=$(this).attr("flag");
        // 首次创建
        if(shengExpression=="true"){
            var $parent=$(this).parent();
            var $clone=$(".cloneOne").clone(true);
            $clone.removeClass("cloneOne");//防止重复创建
            $clone.appendTo($parent);
            $(this).attr("flag","false");
        }else{
            $(this).siblings(".Expression").toggleClass("shengHidden");
        } 
})
$(".commentList").delegate(".ExpressionImg","click",function(){
        var $textarea=$(this).parentsUntil(".afterMyself",".Expression").siblings("textarea");
        var afterImgNum=$(this).attr("imgNum");
         TextUtil.insertAtCaret($textarea[0],afterImgNum);
});
// obj{parent:parent,son:son,news:{src:src,name:name,text:text,time:time},zanNews:{cookie:cookie,title:title}}
function callback(obj){
   this.parent=obj.parent||"";//获取父容器
   this.son=obj.son;//获取子元素
   this.news=obj.news||""//留言信息
   this.zanNews=obj.zanNews||"";//赞
}
callback.prototype={
   constructor:callback,
   init:function(){
         var that=this;
         var cookieFlag=getCookie(that.zanNews.cookie);  
         if(cookieFlag=="false"){
             this.clickFlag=false;
         }else{
         	   this.clickFlag=true;
         }
   },
   zan:function(){
   	    this.init();
   	    var that=this; 
        if(that.clickFlag){
           that.clickFlag=false;
        }else{
            that.zanNews.title.finish().animate({opacity:1},300,function(){
                that.zanNews.title.animate({opacity:0},2000);
            });
            return;
        }
        var num=parseInt(that.son.text())+1;
        // typeid:1表示文章赞
        $.ajax({
            url:"/home/praise",
            type:"post",
            data:{id:article,typeid:1},
            beforeSend: function(XHR){
                if(arr[0]){
                    arr[0].abort();
                }
                arr[0]=XHR;
            },
            success:function(data){
                setCookie(that.zanNews.cookie,that.clickFlag);
                that.son.text(num);
            },
            error:function(data){
                alert("网络不太好");
            }
        })
   },
   ding:function(){//顶一下
        this.init(); 	
        var that=this;
        var $son=that.son;
        if(that.clickFlag){
           that.clickFlag=false;
        }else{
            return;
        }
        $son.css({"color":"black","font-weight":"blod"});
        var num=parseInt($son.text())+1;
        $.ajax({
            url:"/home/praise",
            type:"post",
            data:{msgid:msgId,typeid:2},
            beforeSend: function(XHR){
                if(arr[0]){
                    arr[0].abort();
                }
                arr[0]=XHR;
            },
            success:function(data){
                setCookie(that.zanNews.cookie,that.clickFlag);
                $son.text(num);
            },
            error:function(data){
                alert("网络不太好");
            }
        })
   },
   Reply:function(){
   	    var that=this;
        document.getElementById("qqLoginBtn").click();
        //监测登录状态,成功返回true
        var login=QC.Login.check();
        if(!login){
                $("#qqLoginBtn a").click();
        }else{
          //提交留言，并显示
          var value=that.son.find("textarea").prop("value");
          //如果为空，禁止添加
          value=trim(value);
          if(value==""){
            return;
          }
          value="@"+that.news.name+":"+value;
          that.son.find("textarea").prop("value","");
          var personId=that.son.attr("id");
          var left=parseInt(that.parent.css("margin-left"))+40;
          $.ajax({
                url:"/home/qqlogin",
                type:"post",
                data:{accesstoken:accessTokens,openid:openIds,content:value,arcid:articleId,pid:personId},
                success:function(data){
                    //xss过滤
                    value = filterXSS(value); 
                    // 转换图片
                    value=changeImg(value);
                    var str="<li class='shengReply' style='margin-left:"+left+"px'><ul class='person' id="+data+"><li class='picture'><img src="+qqsrc+" width='35px' height='35px'></li><li class='commentNews'><p class='name1'>"+nickname+"</p><p class='speak1'>"+value+"</p><p class='detailed1'><span>刚刚</span><span class='huifu'><span class='icon1'></span><span>回复(<a href='javascript:void(0);' dataFlag='true'>0</a>)</span></span><span class='agree'><span class='icon2'></span><span>顶(<a href='javascript:void(0)' dataFlag='true'>0</a>)</span></span></p></li><div class='clearfloat'></div></ul></li>";
                      that.parent.after(str);
                      $(".afterSubmit").remove();
                },
                error:function(){
                  alert("失败");
                }
          })
        }
   }
}
//表情包转换
  var ExpressionArr=[{title:"[惊呆]",num:1},{title:"[可爱]",num:2},{title:"[憨笑]",num:3},{title:"[坏笑]",num:4},{title:"[无聊]",num:5},{title:"[生气]",num:6},{title:"[折磨]",num:7},{title:"[不屑]",num:8},{title:"[流泪]",num:9},{title:"[不理]",num:10},{title:"[晕]",num:11},{title:"[冷汗]",num:12},{title:"[困]",num:13},{title:"[害羞]",num:14},{title:"[呐喊]",num:15},{title:"[稀罕]",num:16},{title:"[色]",num:17},{title:"[酷]",num:18},{title:"[石化]",num:19},{title:"[囧]",num:20},{title:"[睡觉]",num:21},{title:"[调皮]",num:22},{title:"[亲亲]",num:23},{title:"[疑问]",num:24},{title:"[闭嘴]",num:25},{title:"[难过]",num:26},{title:"[难过]",num:26},{title:"[好奇]",num:27},{title:"[得意]",num:28},{title:"[鄙视]",num:29},{title:"[猪头]",num:30}] 
  function changeImg(str){
      var reg=/\[([\u4e00-\u9fa5])+\]/g;
      var str=str.replace(reg,function(a){
             for(var i in ExpressionArr){
                 if(a==ExpressionArr[i].title){
                     var replaceNum=ExpressionArr[i].num;
                      return "<img src='/assets/home/emoubb/"+replaceNum+".gif' width='18px'>";
                 }
             }    
      })
      return str;
  };
//去空格函数
function trim(str){
  var reg=/\s*/g
  str=str.replace(reg,"");
  return str;
} 
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
         //网站留言，通信后台显示信息
          $.ajax({
            url:"/home/SetSession",
            type:"post",
            data:{openid:openIds},
            success:function(data){
              
            },
            error:function(data){
                alert("网络不太好");
            }
          }).done(function(){
               //网站留言**************************** 
               _shengq_qqLogin();
               $(".msg-private").css("display","inline-block");
          })
      })
      $("._personShow img").attr("src",reqData.figureurl_1);
      $(".livemessage-avatar img").attr("src",reqData.figureurl_1);
      qqsrc=reqData.figureurl_1;
      nickname=reqData.nickname;
      $("._personShow span").css("display","block");
      $(".qqlogout").css("display","block");
   }, function(opts){//注销成功
        alert('QQ登录 注销成功');
        $("._personShow img").attr("src","/assets/home/img/default.jpg");
        $.ajax({
            url:"/home/qqlogout",
            type:"post",
            success:function(data){

            },
            error:function(data){
                alert("网络不太好");
            }
        })
        //网站留言***************************************************************
        $(".livemessage-avatar img").attr("src","/assets/home/img/default.jpg");
        _shengq_qqLogout();
   }
);
//退出登录***************article+livemsg*************************
$("._personShow span").add(".qqlogout").click(function(){
   QC.Login.signOut();
   $(this).css("display","none");
});
//留言
  $(".commentSbmit .shengMessage").click(function(){
      // document.getElementById("qqLoginBtn").click();
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
                  var str="<li class='shengReply' style='margin-left:0px;'><ul class='person' id="+data+"><li class='picture'><img src="+qqsrc+" width='45px' height='45px'></li><li class='commentNews'><p class='name1'>"+nickname+"</p><p class='speak1'>"+value+"</p><p class='detailed1'><span>刚刚</span><span class='huifu'><span class='icon1'></span><span>回复(<a href='javascript:void(0);' dataFlag='true'>0</a>)</span></span><span class='agree'><span class='icon2'></span><span>顶(<a href='javascript:void(0)' dataFlag='true'>0</a>)</span></span></p></li><div class='clearfloat'></div></ul></li>";
                  $(".commentList").prepend(str);
              },
              error:function(){
                alert("失败");
              }
        })
      }
  });
  //绑定头像登录**********************************************
  $("._personShow img").add(".livemessage-avatar img").click(function(){
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
// 网站留言栏目**********************************
// 类别选择
$(".shengEmotion").click(function(){
     var className=$(this).attr("class");
     var arrOn=className.split(" ");
     var hoverName=arrOn[0]+"hover";
     var reg=new RegExp(hoverName,"g");
     //判断是否重复点击
     if(reg.test(className)){
         return;
     }else{
         // 还原类名
         $(".shengEmotion").each(function(i){
              if(i==0){
                  $(this).attr("class","emotion shengEmotion");
              }else{
                  $(this).attr("class","emotion1 shengEmotion");
              }
         });
         // 加高亮
         className=className+" "+hoverName;
         $(this).attr("class",className);
         $(".shengEmotion").removeAttr("attrs");
         $(this).attr("attrs","hoverOn");
     }
})
//顶
$(".items-wrap").delegate("._sheng_top","click",function(){
       var $obj=$(this);
       var num=$(this).text();
       num=parseInt(num.slice(2,-1));
       var parentId=$(this).parentsUntil("._sheng_ulBox","._sheng_ulBox li").attr("id");
       var dingFlag=parentId+"livemsgFlag";
       var cookieFlag=getCookie(dingFlag);  
       if(cookieFlag=="false"){
           return;
       }
       $.ajax({
            url:"/home/praise",
            type:"post",
            data:{msgid:parentId,typeid:3},
            success:function(data){
                setCookie(dingFlag,false);
                ++num;
                num="顶("+num+")";
                $obj.text(num);
                //数据同步
                var same="._sheng_liBox"+parentId;
                $(same).find("._sheng_top").text(num);
            },
            error:function(data){
                alert("网络不太好");
            }
        })
});
//提交留言
 $(".items-content .send").click(function(){
      //监测登录状态,成功返回true
      var login=QC.Login.check();
      if(!login){
              $("#qqLoginBtn a").click();
      }else{
        //提交留言，并显示
        var value=$(".items-content textarea").prop("value");
        //如果为空，禁止添加
        value=trim(value);
        if(value==""){
          return;
        }
        // 获取类别 private参数只有两种：0代表站长 1代表私信(shengEmotion只能有两个)
        var private,privateImg="";
        $(".shengEmotion").each(function(i){
              if($(this).attr("attrs")){
                  private=i;
              }
        });
        if(private==1){
        	privateImg="<img src='/assets/home/img/private.png' class='privatemsg'>";
        }
        $.ajax({
              url:"/home/qqlogin",
              type:"post",
              data:{accesstoken:accessTokens,openid:openIds,content:value,private:private},
              success:function(data){
              //清空内容
              $(".items-content textarea").prop("value",""); 
                  //xss过滤
                  value = filterXSS(value); 
                  // 转换图片
                  value=changeImg(value);
                  var str="<li id='"+data+"'><img src='"+qqsrc+"'><div class='items-content'><span class='avatar'>"+nickname+"</span><p>"+value+privateImg+"</p><div class='items-footer'><span dataFlag='true'>刚刚</span><span class='_sheng_top'>顶(0)</span></div><div class='clearfix'></div></div></li>"
                  $("._msg_list").eq(private).prepend(str);
              },
              error:function(){
                alert("失败");
              }
        })
      }
  });
//网站留言分页
var shengNewsm=$(".msg-typehover").index("._sheng_msgBtn");
// ajax函数
// obj{container:container,data:data,url:url,btn:btn,page:page,flag:flag,load:load}parent表示父容器   btn表示分页按钮   page是专属于网站分页留言使用
function _shengNews_More(obj){
      if(obj.flag.attr("flag")=="false"){
        return;
      }
      obj.flag.attr("flag","false");
      obj.load.css("display","block");//加载动画
      //专属分页加载
      if(obj.page){
           var fenyeNum=parseInt(obj.page);
           var morePage=$("._sheng_msgBtn").eq(fenyeNum).attr("page");
           morePage=parseInt(morePage)+1;
           $("._sheng_msgBtn").eq(fenyeNum).attr("page",morePage);
           obj.data.page=morePage;
      }
      $.ajax({
           url:obj.url,
           beforeSend: function(XHR){
                if(arr[0]){
                    arr[0].abort();
                }
                arr[0]=XHR;
           },
           type:"post",
           data:obj.data,
           success:function(data){
               obj.load.css("display","none");//加载动画
               if(data.length==0){
               	   $(obj.btn).text("已经在最底部...");
               	   return;
               }
               obj.btn.css("display","block");
               obj.flag.attr("flag","true");
               obj.container.before(data);
           }
      });
}
//qq回调函数
function _shengq_qqLogout(){
    //清楚数据 
    $("._msg_list").eq(1).find("li").remove();
    $("._sheng_liBox41").css("display","block");
    //数据初始化    
    $("._sheng_msgBtn").eq(1).attr({"page":"1","flag":"true"});
    $("._shengNews_More").eq(1).css("display","none").text("查看更多");
}
function _shengq_qqLogin(){
    $("._sheng_liBox41").css("display","none");
    var myFlag=$("._sheng_msgBtn").eq(1);// 开关
    var moreBtn=$("._shengNews_More").eq(1);
    var sheng_Lcontainer=$(".sheng_loading").eq(1);
    var objLogin={container:sheng_Lcontainer,data:{msgtype:2,page:1},url:"/home/getwebmessage",btn:moreBtn,flag:myFlag,load:sheng_Lcontainer};
    _shengNews_More(objLogin);
}
// 事件处理
if(shengNewsm>=0){
	  // 初始化
	 var _shengNumPage=parseInt($(".msg-typehover").attr("page"));//页码
   var pubilcFlag=$(".msg-typehover");//开关
   var _sheng_int=$("._shengNews_More").eq(0);
   var sheng_Icontainer=$(".sheng_loading").eq(0);
   // shengNewsm表示高亮的位置
   _shengNews_More({container:sheng_Icontainer,data:{msgtype:1,page:_shengNumPage},url:"/home/getwebmessage",btn:_sheng_int,flag:pubilcFlag,load:sheng_Icontainer});
   //我的留言登陆事件
   $("._msg_list").delegate("._sheng_liBox41","click",function(){
        var login=QC.Login.check();
        if(!login){
                $("#qqLoginBtn a").click();
        }else{
          $(this).css("display","none");
        }
    });
    // 网站留言分页
    $("._msg_list").delegate("._shengNews_More","click",function(){
          var paheIndex=$(".msg-typehover").index("._sheng_msgBtn");
          var shareFlag=$(".msg-typehover");//开关
          var moreBtn=$("._shengNews_More").eq(paheIndex);
          var sheng_Pconatiner=$(".sheng_loading").eq(paheIndex);
          var pageObj={container:sheng_Pconatiner,data:{msgtype:paheIndex+1,page:1},url:"/home/getwebmessage",btn:moreBtn,page:paheIndex+"",flag:shareFlag,load:sheng_Pconatiner};
          _shengNews_More(pageObj);
    });
    //网站留言，我的留言切换
    $("._sheng_msgBtn").click(function(){
       var index=$(this).index("._sheng_msgBtn");
       $("._sheng_msgBtn").removeClass("msg-typehover").eq(index).addClass("msg-typehover");
       $("._msg_list").removeClass("msg-mine").eq(index).addClass("msg-mine");
    }); 
}






});