<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:34:"./themes/admin/newscenic/edit.html";i:1577263898;s:24:"./themes/admin/base.html";i:1574737504;}*/ ?>
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
            <li class=""><a href="<?php echo url('admin/newscenic/index'); ?>">景区管理</a></li>
            <li class=""><a href="<?php echo url('admin/newscenic/add'); ?>">添加管理</a></li>
            <li class="layui-this">修改景区</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form class="layui-form form-container" action="<?php echo url('admin/newscenic/update'); ?>" method="post">

                  	<div class="layui-form-item">
                        <label class="layui-form-label">景区类别</label>
                        <div class="layui-input-block">
                            <select name="classid" lay-verify="required" lay-filter="typeSelect">
                                <option value="1" <?php if($scenic['classid'] == 1): ?>selected = "selected"<?php endif; ?>>必游</option>
                                <option value="2" <?php if($scenic['classid'] == 2): ?>selected = "selected"<?php endif; ?>>推荐</option>
                                <option value="3" <?php if($scenic['classid'] == 3): ?>selected = "selected"<?php endif; ?>>周末游</option>
                                <option value="4" <?php if($scenic['classid'] == 4): ?>selected = "selected"<?php endif; ?>>特色</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">中_景区名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="name_cn" value="<?php echo $scenic['name_cn']; ?>" required  lay-verify="required" placeholder="请输入景区名称" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">韩_景区名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="name_kr" value="<?php echo $scenic['name_kr']; ?>" required  lay-verify="required" placeholder="请输入景区名称" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">经度</label>
                            <div class="layui-input-inline">
                                <input id="lon" value="<?php echo $scenic['lon']; ?>" type="tel" name="lon" placeholder="点击地图获取经度" autocomplete="off" class="layui-input" readonly="true">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">纬度</label>
                            <div class="layui-input-inline">
                                <input id="lat"  value="<?php echo $scenic['lat']; ?>"type="text" name="lat" placeholder="点击地图获取纬度" autocomplete="off" class="layui-input" readonly="true">
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">地图:</label>
                        <div class="layui-input-block">
                            <div id="Map" class="layui-colla-content layui-show"  style="height: 400px;"></div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">景区图片</label>
                        <div class="layui-input-block">
                            <button type="button" id="upload-photo-btn" class="layui-btn">上传图片</button>
                            <div id="photo-container">
                                <?php if(is_array($scenic['img']) || $scenic['img'] instanceof \think\Collection || $scenic['img'] instanceof \think\Paginator): if( count($scenic['img'])==0 ) : echo "" ;else: foreach($scenic['img'] as $key=>$item): ?>
                                <div class="photo-list">
                                    <input type="text" name="img[]" value="<?php echo $item; ?>" class="layui-input layui-input-inline" style="display:none;">
                                    <img src="<?php echo $item; ?>" style="width:200px;">
                                    <button type="button" class="layui-btn layui-btn-danger remove-photo-btn">移除</button>
                                </div>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>
                        </div>
                    </div>
                  	<div class="layui-form-item">
                        <label class="layui-form-label">中_景区描述</label>
                        <div class="layui-input-block">
                            <textarea name="content_cn" placeholder="" class="layui-textarea" id="content_cn"><?php echo $scenic['content_cn']; ?></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">韩_景区描述</label>
                        <div class="layui-input-block">
                            <textarea name="content_kr" placeholder="" class="layui-textarea" id="content_kr"><?php echo $scenic['content_kr']; ?></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <input type="hidden"  name="id" value="<?php echo $scenic['id']; ?>">
                            <input type="hidden" id="city" name="city" value="<?php echo $scenic['city']; ?>">
                            <input type="hidden" id="district" name="district" value="<?php echo $scenic['district']; ?>">
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



<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.15&key=b76d1ab35b5b7512b730021ff06e0e25"></script>
<script>
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
        var ue = UE.getEditor('content_kr');
      var ue = UE.getEditor('content_cn'),
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

  $(function () {
      var map = new AMap.Map("Map", {
          resizeEnable: true,
          center: [<?php echo $scenic['lon']; ?>, <?php echo $scenic['lat']; ?>],
          zoom: 13
      });
      // 创建一个 Marker 实例：
      var marker = new AMap.Marker({
          position: new AMap.LngLat(<?php echo $scenic['lon']; ?>, <?php echo $scenic['lat']; ?>),   // 经纬度对象，也可以是经纬度构成的一维数组[116.39, 39.9]
          title: "当前位置",
          label:{
              offset: new AMap.Pixel(0, 0),  //设置文本标注偏移量
              content: "<div class='info'>当前选中</div>", //设置文本标注内容
              direction: 'top' //设置文本标注方位
          }
      });
      map.add(marker);
      map.on('click', function(e) {
          var pos = [e.lnglat.getLng(),e.lnglat.getLat()];
          document.getElementById("lon").value = pos[0];
          document.getElementById("lat").value = pos[1];
          map.remove(marker);
          marker = new AMap.Marker({
              position: new AMap.LngLat(e.lnglat.getLng(), e.lnglat.getLat()),   // 经纬度对象，也可以是经纬度构成的一维数组[116.39, 39.9]
              title: "当前选中",
              label:{
                  offset: new AMap.Pixel(0, 0),  //设置文本标注偏移量
                  content: "<div class='info'>当前选中</div>", //设置文本标注内容
                  direction: 'top' //设置文本标注方位
              }
          });

          //获取城市
          AMap.service('AMap.Geocoder',function(){
              //实例化Geocoder
              geocoder = new AMap.Geocoder({city: "" });
              geocoder.getAddress(pos, function(status, result) {
                  if (status === 'complete' && result.info === 'OK') {
                      document.getElementById("city").value = result.regeocode.addressComponent.city;
                      document.getElementById("district").value = result.regeocode.addressComponent.district;
                  }else
                      alert('获取城市失败');

              });
          });
          map.add(marker);
      });
// 将创建的点标记添加到已有的地图实例：

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
