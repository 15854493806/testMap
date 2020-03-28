<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:29:"./themes/admin/slide/add.html";i:1574737507;s:24:"./themes/admin/base.html";i:1574737504;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>盲兔游</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="__JS__/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="__CSS__/font-awesome.min.css">
    <!--CSS引用-->
    
    <link rel="stylesheet" href="__CSS__/admin.css">
    <!--[if lt IE 9]>
    <script src="__CSS__/html5shiv.min.js"></script>
    <script src="__CSS__/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <!--头部-->
    <div class="layui-header header">
        <a href=""><img class="logo" src="__STATIC__/images/admin_logo.png" alt=""></a>
        <ul class="layui-nav" style="position: absolute;top: 0;right: 20px;background: none;">
            <li class="layui-nav-item"><a href="http://www.mangtuyou.com" target="_blank">前台首页</a></li>
            <li class="layui-nav-item"><a href="" data-url="<?php echo url('admin/system/clear'); ?>" id="clear-cache">清除缓存</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;"><?php echo session('admin_name'); ?></a>
                <dl class="layui-nav-child"> <!-- 二级菜单 -->
                    <dd><a href="<?php echo url('admin/change_password/index'); ?>">修改密码</a></dd>
                    <dd><a href="<?php echo url('admin/login/logout'); ?>">退出登录</a></dd>
                </dl>
            </li>
        </ul>
    </div>

    <!--侧边栏-->
    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <ul class="layui-nav layui-nav-tree">
                <li class="layui-nav-item layui-nav-title"><a>管理菜单</a></li>
                <li class="layui-nav-item">
                    <a href="<?php echo url('admin/index/index'); ?>"><i class="fa fa-home"></i> 网站信息</a>
                </li>
                <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $key=>$vo): if(isset($vo['children'])): ?>
                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="<?php echo $vo['icon']; ?>"></i> <?php echo $vo['title']; ?></a>
                    <dl class="layui-nav-child">
                        <?php if(is_array($vo['children']) || $vo['children'] instanceof \think\Collection || $vo['children'] instanceof \think\Paginator): if( count($vo['children'])==0 ) : echo "" ;else: foreach($vo['children'] as $key=>$v): ?>
                        <dd><a href="<?php echo url($v['name']); ?>"> <?php echo $v['title']; ?></a></dd>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </dl>
                </li>
                <?php else: ?>
                <li class="layui-nav-item">
                    <a href="<?php echo url($vo['name']); ?>"><i class="<?php echo $vo['icon']; ?>"></i> <?php echo $vo['title']; ?></a>
                </li>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>

                <li class="layui-nav-item" style="height: 30px; text-align: center"></li>
            </ul>
        </div>
    </div>

    <!--主体-->
    
<div class="layui-body">
    <!--tab标签-->
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <li class=""><a href="<?php echo url('admin/example/index'); ?>">地图管理</a></li>
            <li class="layui-this">添加地图</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form class="layui-form form-container" action="<?php echo url('admin/example/save'); ?>" method="post">
                    <div class="layui-form-item">
                        <label class="layui-form-label">城市名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" value="" required  lay-verify="required" placeholder="请输入名称" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">地图</label>
                        <div class="layui-input-block">
                            <input type="text" name="img" value="" placeholder="（必填）请上传图片" class="layui-input layui-input-inline" id="thumb">
                            <input type="file" name="file" class="layui-upload-file">
                        </div>
                      	<img id="thumb1" src="" style="width:500px;margin-left:120px;margin-top:30px;">
                    </div>
                    <div id="cityCoordinates" style="display:none;">
                          <label class="layui-form-label">x</label> <label class="layui-form-label" id="x"></label>
                          <label class="layui-form-label">y</label> <label class="layui-form-label" id="y"></label>
                         <div class="layui-form-item">
                        <label class="layui-form-label">城市名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="cityname" value="" required  lay-verify="required" placeholder="请输入名称" class="layui-input">
                        </div>
                        <div class="layui-form-item" style="margin-top:20px">
                        <label class="layui-form-label">跳转链接</label>
                        <div class="layui-input-block">
                            <input type="text" name="urlname" value="" required  lay-verify="required" placeholder="请输入跳转链接" class="layui-input">
                        </div>
                          
                         <div class="layui-input-block" style="margin-top:30px">
                            <input type="button" onclick="sava()" value="确定" style="border:1px solid #C9C9C9;background-color:#fff;height:38px;text-align:center;padding:0px 18px;line-height:38px;">
                        </div>
                        <div id="savacity" style="display:none;">
                           
                        </div>
                    </div>
                    <input name="url" type="text" id="url" style="display:none">
                    </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit lay-filter="*">保存</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script>
  var w ;
  var h;
  var x;
  var y
  var par=[];
  $(document).ready(function(){
	
})
  $(function(){
    console.log("000")
     $("#thumb1").on("load",function(){
        w= $(this).width();
       h=$(this).height();
       console.log(w)
     });
   })
  $('#thumb1').click(function(e){
     console.log(w)
     $("#cityCoordinates").show()
    x=e.offsetX/w*100
    y=e.offsetY/h*100
    x=x.toFixed(2)
    y=y.toFixed(2)
    $("#x").empty()
    $("#x").append(x)
     $("#y").empty()
    $("#y").append(y)
});
  function sava(){
       console.log("0000")
    var cityname=$("[name='cityname']").val()
    var urlname=$("[name='urlname']").val()
    if(cityname&&urlname){
   var parm={}
      parm.cityname=cityname;
      parm.urlname=urlname;
      parm.x=x;
      parm.y=y;
      $("#savacity").show()
      par.push(parm)
      savacity()
      $("#url").val();
      $("#url").val(JSON.stringify(par));
    }else{
      alert("跳转链接或城市不能为空")
    }
    console.log(par)
 }
  function savacity(){
    $("#savacity").empty()
    for(var i=0;i<par.length;i++){
      $("#savacity").append(
        "<div style='width:100%;height:50px'>"+
            "                           <label class='layui-form-label' '>x:"+par[i].x+"</label>" +
           "                           <label class='layui-form-label' '>y:"+par[i].y+"</label>" +
            "                          <label class='layui-form-label' >"+par[i].cityname+"</label>" +
            "                          <label class='layui-form-label' >"+par[i].urlname+"</label>" +
            "                           <label class='layui-form-label' onclick='delect("+i+")')>删除</label>"+
        "</div>"
      )
    }
  }
  function delect(id){ 
      par.splice(id,id);
    savacity()
      console.log(par)
  }
</script>


</div>
{block name="js"}
<script src="__JS__/ueditor/ueditor.config.js"></script>
<script src="__JS__/ueditor/ueditor.all.min.js"></script>
{/block}
<script>
    // 定义全局JS变量
    var GV = {
        current_controller: "admin/<?php echo (isset($controller) && ($controller !== '')?$controller:''); ?>/",
        base_url: "__STATIC__"
    };
</script>
 <script class="resources library" src="__JS__/area.js" type="text/javascript"></script>

    

    <script type="text/javascript">_init_area();</script>
  
<script type="text/javascript">

var Gid  = document.getElementById ;

var showArea = function(){

	Gid('show').innerHTML = "<h3>省" + Gid('s_province').value + " - 市" + 	

	Gid('s_city').value + " - 县/区" + 

	Gid('s_county').value + "</h3>"

							}

Gid('s_county').setAttribute('onchange','showArea()');

</script>

<!--JS引用-->
<script src="__JS__/jquery.min.js"></script>
<script src="__JS__/layui/lay/dest/layui.all.js"></script>
<script src="__JS__/admin.js"></script>

<!--页面JS脚本-->




</body>
</html>
