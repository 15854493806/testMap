<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:36:"./themes/index/index_copy/index.html";i:1574738356;}*/ ?>
<html>
<head>
	<title>盲兔游</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<meta charset="utf-8">
	<script src="http://code.jquery.com/jquery-1.8.0.min.js"></script>
	<script type="text/javascript">
		function browserRedirect() {
			var sUserAgent = navigator.userAgent.toLowerCase();
			var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
			var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
			var bIsMidp = sUserAgent.match(/midp/i) == "midp";
			var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
			var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
			var bIsAndroid = sUserAgent.match(/android/i) == "android";
			var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
			var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";
			if (bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM) {

			} else {
				//跳转pc端页面
				window.location.href="http://www.mangtuyou.com/pc.html";
			}
		}
	//	browserRedirect();
	</script>
	<style>
		.action{
			color: red;
		}
		.action span{
			border:1px solid red!important;
		}
      .first_class_menu::-webkit-scrollbar {
        display: none;
      }
		@media screen and (orientation:landscape) {

		}
	</style>
</head>
<body onorientationchange="updateOrientation();" id="print"  style="overflow: hidden;margin: 0px!important;">
<div style="width:100%;height:0px;background:transparent;color:#fff;text-align: center;line-height: 50px;letter-spacing:2px;"></div>
<div style="width:99.5%;border:1px solid #ddd;position:relative;">
	<img src="" style="width:100%;height: 100%" id="images">
	<div id="img">

	</div>
	<div id="city">

	</div>
</div>
<div style="width:80px;position: fixed;right: 10px; top: 10px;">
	<button id="biyou" style="width:80px; border: 0px;background-color: transparent;height: 60px;margin-top:10px;outline: none" class="action" onclick="biyou( this,'1')"><img src="__STATIC__/images/biyou-select.png" width="45px" style="text-align: center"><br>必游景点</button>
	<button id="tuijian" style="width:80px; border: 0px;background-color: transparent;height: 60px;margin-top:10px;outline: none" class="" onclick="tuijian( this,'2')"><img src="__STATIC__/images/tuijian.png" width="45px" style="text-align: center"><br>推荐景点</button>
	<button id="zhoumo" style="width:80px; border: 0px;background-color: transparent;height: 60px;margin-top:10px;outline: none" class="" onclick="zhoumo( this,'3')"><img src="__STATIC__/images/zhoumo.png" width="45px" style="text-align: center"><br>周末景点</button>
	<!--<button id="tese" style="width:80px; border: 0px;background-color: transparent;height: 60px;margin-top:10px;outline: none" class="" onclick="tese( this,'3')"><img src="tese.png" width="45px" style="text-align: center"><br>特色景点</button>-->
</div>
<div id="describe" style="position:fixed;top:10%;left:10%;height:300px;border:1px solid #666;border-radius:5px;width:78%;line-height: 25px;background:#fff;display:none;padding:1%;overflow: auto;">
	<div class="first_class_menu" style="width:100%;height: 80px;overflow-y: scroll;white-space: nowrap;display:flex;" id="image">

	</div>
	<div id="imgp" style="overflow:auto">

	</div>

</div>
<div id="hideimg" style="position:fixed;top:9.5%;left:87%;display:none;">
	<img src="__STATIC__/images/x.png" style="width:30px;height:30px;" onclick="hidedescribe();">
</div>
  
  <div style="width:100%;height:100%;position:fixed;top:0px;left:0px;background:#fff;display:none" id="divimg">
    
  </div>
<input id="cid" value="1" style="display: none">
</body>

<script>
	function horizontalScreen(className) {
  // transform 强制横屏
  var conW = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
  var conH = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
  // transform: rotate(90deg); width: 667px; height: 375px;transform-origin:28% 50%;
  //var iosTopHe = 0;//若有其他样式判断，写于此

  $(className).css({
   "transform": "rotate(90deg) translate(" + ((conH - conW) / 2) + "px," + ((conH - conW) / 2) + "px)",
   "width": conH + "px",
   "height": conW + "px",
   //"margin-top":iosTopHe+"px",
   // "border-left":iosTopHe+"px solid #000",
   "transform-origin": "center center",
   "-webkit-transform-origin": "center center"
  });
 }
	function showdescribe(id){
		document.getElementById('describe').style.display = 'block';
		document.getElementById('hideimg').style.display = 'block';
		$.ajax({
			cache: true,
			type: "get",
			url: "http://admin.mangtuyou.com/index/spot/getScenicDetails/id/"+id+"",
			contentType: 'application/x-www-form-urlencoded',
			dataType: 'JSON',
			data :  JSON.stringify({}),
			async : true,
			success : function(request){
				$("#image").empty()
				$("#imgp").empty()
				$("#imgp").append(request.Data.content)
				for(var i=0;i<request.Data.img.length;i++){
					// for(var j;j<request.Data.img[i].length;j++){
					$("#image").append(
							"<img src='"+request.Data.url+request.Data.img[i]+"' style='height: 97%; margin-right: 10px;float: left;border:1px solid #ddd;display: inline-block;' onclick='fada(this)'>"
					)
					// }

				}
			},
			error : function(request) {
				alert(request);
			},
		});
	}
	function hidedescribe(){
		document.getElementById('describe').style.display = 'none';
		document.getElementById('hideimg').style.display = 'none';
	}
	$(function () {
		var pid=1;
		lod(pid);
		horizontalScreen("body")
	})
	function lod(pid) {
		var cid=$("#cid").val()
		$.ajax({
			cache: true,
			type: "get",
			url: "http://admin.mangtuyou.com/index/spot/getScenic/cid/"+cid+"/pid/"+pid+"",
			contentType: 'application/x-www-form-urlencoded',
			dataType: 'JSON',
			data : "",
			async : true,
			success : function(request){
				$("#images").attr('src',"");
				$("#images").attr('src', request.Img);
				$("#city").empty()
				$("#img").empty();
				var city=JSON.parse(request.Url)
				for(var i=0;i<city.length;i++){
					var top=city[i].y;
					var left=city[i].x;
					$("#city").append(
							"<div style='position:absolute;top:"+top+"%;left:"+left+"%;height:20px;border-radius:5px;color:#000;font-size: 16px;' onclick='dianji("+city[i].urlname+")'>"+city[i].cityname+"</div>"
					)
				}
				for(var i=0;i<request.Data.length;i++){
					var top=request.Data[i].coordinate_top;
					var left=request.Data[i].coordinate_left+4
					$("#img").append(
							"<img src='__STATIC__/images/biaodian.png' style='width:30px;height:30px;position:absolute;top:"+request.Data[i].coordinate_top+"%;left:"+request.Data[i].coordinate_left+"%' onclick='showdescribe("+request.Data[i].id+")'>" +
							"<div style='position:absolute;top:"+top+"%;left:"+left+"%;border:1px solid #999;height:20px;background:#fff;border-radius:5px;color:#999;' onclick='showdescribe("+request.Data[i].id+")'>"+request.Data[i].name+"</div>"
					)
				}

			},
			error : function(request) {
				alert(request);
			},
		});
	}
	function biyou(index,pid) {
		$(index).addClass("action").siblings("button").removeClass("action")
		$(index).find("img").attr("src","__STATIC__/images/biyou-select.png")
		$("#tuijian").find("img").attr("src","__STATIC__/images/tuijian.png")
		$("#zhoumo").find("img").attr("src","__STATIC__/images/zhoumo.png")
		$("#tese").find("img").attr("src","__STATIC__/images/tese.png")
		lod(pid)
	}
	function tuijian(index,pid) {
		$(index).addClass("action").siblings("button").removeClass("action")
		$(index).find("img").attr("src","__STATIC__/images/tuijian-select.png")
		$("#biyou").find("img").attr("src","__STATIC__/images/biyou.png")
		$("#zhoumo").find("img").attr("src","__STATIC__/images/zhoumo.png")
		$("#tese").find("img").attr("src","__STATIC__/images/tese.png")
		lod(pid)
	}
	function zhoumo(index,pid) {
		$(index).addClass("action").siblings("button").removeClass("action")
		$(index).find("img").attr("src","__STATIC__/images/zhoumo-select.png")
		$("#tuijian").find("img").attr("src","__STATIC__/images/tuijian.png")
		$("#biyou").find("img").attr("src","__STATIC__/images/biyou.png")
		$("#tese").find("img").attr("src","__STATIC__/images/tese.png")
		lod(pid)
	}
	function tese(index,pid) {
		$(index).addClass("action").siblings("button").removeClass("action")
		$(index).find("img").attr("src","__STATIC__/images/tese-select.png")
		$("#tuijian").find("img").attr("src","__STATIC__/images/tuijian.png")
		$("#biyou").find("img").attr("src","__STATIC__/images/biyou.png")
		$("#zhoumo").find("img").attr("src","__STATIC__/images/zhoumo.png")
		lod(pid)
	}
	function dianji(cid) {
		$("#cid").val(cid)
		var pid=1
		lod(pid)
	}
  function fada(index){
   var img= $(index).attr("src");
    $("#divimg").show();
    $("#divimg").empty()
   $("#divimg").append(
     "<img src='"+img+"' style='width:100%;height:100%' onclick='divimghideimg()'>"
   );
     
  }
  function divimghideimg(){
     $("#divimg").hide();
  }
</script>
<script>
	// 定义全局JS变量
	var GV = {
		current_controller: "index/<?php echo (isset($controller) && ($controller !== '')?$controller:''); ?>/",
		base_url: "__STATIC__"
	};
</script>
</html>
