// 设置cookie
// key 键 value是值,cookie是以键值对形式的字符串eg:"a=11"
// time 存活周期单位秒
function setCookie(key,value,time){
	// 如果没有time就直接创建cookie
	if(time==undefined){
		// 设置全局的path，是整个网站可以访问这个cookie
		document.cookie=key+"="+value+";path=/";
	}//如果有time,创建存活周期
	else{
       var now=new Date();
       now.setTime(now.getTime()+time*1000);
       document.cookie=key+"="+value+";expires="+now.toGMTString()+";path=/";
	}
}
// 获取cookie键对应的键值
function getCookie(key){
	// 拆分cookie为[key1=val1,key2=val2];
	var arr=document.cookie.split("; ");
	// 遍历这个数组
	for(var i=0;i<arr.length;i++){
		// 继续拆分数组arr中的元素[key,val]
		var newarr=arr[i].split("=");
		// 如果newarr[0]等于key值
		if(newarr[0]==key){
			// 返回键对应的值
			return newarr[1];
		}
	}
}
// 删除cookie
function delCookie(key){
	// 直接利用设置cookie的time参数为-1，删除cookie
	setCookie(key,"",-1);
}