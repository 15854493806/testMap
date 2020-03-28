<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:28:"./themes/admin/spot/add.html";i:1574737507;s:24:"./themes/admin/base.html";i:1574737504;}*/ ?>
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
            <li class=""><a href="<?php echo url('admin/scenic/index'); ?>">景区管理</a></li>
            <li class="layui-this">添加景区</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form class="layui-form form-container" action="<?php echo url('admin/scenic/save'); ?>" method="post">
                    <div class="layui-form-item">
                        <label class="layui-form-label">所属地区</label>
                        <div class="layui-input-block">
                            <select name="cid" lay-verify="required" lay-filter="typeSelect">
                                <?php if(is_array($example) || $example instanceof \think\Collection || $example instanceof \think\Paginator): if( count($example)==0 ) : echo "" ;else: foreach($example as $key=>$vo): ?>
                                <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                  	<div class="layui-form-item">
                        <label class="layui-form-label">景区类别</label>
                        <div class="layui-input-block">
                            <select name="classid" lay-verify="required">
                                <option value="1">必游</option>
                              	<option value="2">推荐</option>
                              	<option value="3">周末游</option>
                              	<option value="4">特色</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">景区名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" value="" required  lay-verify="required" placeholder="请输入景区名称" class="layui-input">
                        </div>
                    </div>
                  	<div class="layui-form-item">
                        <label class="layui-form-label">景区位置</label>
                      	<div class="layui-input-block">
                            <input type="text" name="coordinate_left" value="" required  lay-verify="required" placeholder="请点击地区图片获取横向坐标" class="layui-input" style="margin-bottom:10px;" id="requiredx">
                          	<input type="text" name="coordinate_top" value="" required  lay-verify="required" placeholder="请点击地区图片获取纵向坐标" class="layui-input" style="margin-bottom:10px;" id="requiredy">
                        </div>
                        <div class="layui-input-block">
                            <img src="<?php echo $example[0]['img']; ?>" style="width:400px;" id="cityimg">
                        </div>
                    </div>
                   <div class="layui-form-item">
                        <label class="layui-form-label">景区图片</label>
                        <div class="layui-input-block">
                            <button type="button" id="upload-photo-btn" class="layui-btn">上传图片</button>
                            <div id="photo-container"></div>
                        </div>
                    </div>
                  	<div class="layui-form-item">

                        <label class="layui-form-label">景区描述</label>

                        <div class="layui-input-block">

                            <textarea name="content" placeholder="" class="layui-textarea" id="content"></textarea>

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

<script src="__JS__/ueditor/ueditor.config.js"></script>
<script src="__JS__/ueditor/ueditor.all.min.js"></script>


<script>
  var w ;
  var h;
  $(document).ready(function(){
     $("#cityimg").on("load",function(){
        w= $(this).width();
       h=$(this).height();
    });
     form.on('select(required)', function(data){
           console.log(data.value)
           $.ajax({
            cache: true,
            type: "get",
            url: "http://admin1.mangtuyou.com/admin/spot/getCityimg/id/"+data.value+"",
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'JSON',
            data :  {},
            async : true,
            success : function(request){
              $("#cityimg").empty()
              $("#cityimg").attr("src", request);
            },
            error : function(request) {
                alert(request);
            },
        });
        });
  })
  $('#cityimg').click(function(e){
    //获取鼠标在图片上的坐标
    var x=e.offsetX/w*100
    var y=e.offsetY/h*100
    
    $("#requiredx").val()
     $("#requiredx").val(x)
    $("#requiredy").val();
     $("#requiredy").val(y)
    
});
    $(function() {

        form.on('select(typeSelect)', function(data){
            
            $.ajax({
            cache: true,
            type: "POST",
            url: "http://admin1.mangtuyou.com/admin/spot/getCityimg/id/"+data.value+"",
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'JSON',
            data :  {},
            async : true,
            success : function(request){
              $("#cityimg").empty();
              $("#cityimg").attr("src",request);
              
            },
            error : function(request) {
                alert(request);
            },
        });
        });
		
      var ue = UE.getEditor('content'),

            uploadEditor = UE.getEditor('upload-photo-btn'),

            photoListItem,

            uploadImage;

        // 上传图片
         var   uploadEditor = UE.getEditor('upload-photo-btn'),
            photoListItem,
            uploadImage;

        uploadEditor.ready(function () {
            uploadEditor.setDisabled();
            uploadEditor.hide();
            uploadEditor.addListener('beforeInsertImage', function (t, arg) {
                $.each(arg, function (index, item) {
                    photoListItem = '<div class="photo-list"><input type="text" name="img[]" value="' + item.src + '" class="layui-input layui-input-inline" style="display:none;"><img src="'+ item.src + '" style="width:200px;">';
                    photoListItem += '<button type="button" class="layui-btn layui-btn-danger remove-photo-btn">移除</button></div>';

                    $('#photo-container').append(photoListItem).on('click', '.remove-photo-btn', function () {
                        $(this).parent('.photo-list').remove();
                    });
                });
            });
        });

        $('#upload-photo-btn').on('click', function () {
            uploadImage = uploadEditor.getDialog("insertimage");
            uploadImage.open();
        });

    });

  function switchimg(id){
       console.log(id)
        $.ajax({
            cache: true,
            type: "POST",
            url: "http://admin1.mangtuyou.com/admin/spot/getCityimg/id/"+id+"",
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'JSON',
            data :  {},
            async : true,
            success : function(request){
               console.log(request)
            },
            error : function(request) {
                alert(request);
            },
        });
 }
</script>


</body>
</html>
