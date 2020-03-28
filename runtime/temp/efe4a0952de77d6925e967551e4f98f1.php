<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:31:"./themes/index/index/index.html";i:1585368024;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta content="" charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <title>盲兔游</title>
    <script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
    <script src="/public/js/navbarscroll.js"></script>
    <!-- 地图的css及js，不可缺少-->
    <!--    <link rel="stylesheet" href="/public/static/css/swiper.css">-->
    <!--    <script src="/public/js/swiper.js"></script>-->   
     <!--    <script src="/public/js/scrollmenu.js"></script>-->
     <!--    <link rel="stylesheet" href="/public/static/css/animate.css">-->
     <!--    <link rel="stylesheet" href="/public/static/css/scrollmenu.css">-->
    <link rel="stylesheet" href="http://cache.amap.com/lbs/static/main1119.css" />
    <link rel="stylesheet" href="http://cache.amap.com/lbs/static/main.css?v=1.0" />
    <script type="text/javascript" src="http://cache.amap.com/lbs/static/es5.min.js"></script>
    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=0b145e73de9f027a0ebe0a14241cd856&plugin=AMap.DistrictSearch"></script>
    <script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>
    <script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.15&key=0b145e73de9f027a0ebe0a14241cd856&plugin=AMap.Geocoder"></script>

    <!-- 弹出信息框样式-->
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        #container {
            position: relative;
        }

        /*信息窗口*/
        .mapWindowData {
            z-index: 999;
            position: absolute;
            top: 42%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 85%;
            height: 58%;
            display: none;
            background: #fff;
        }

        .tab {
            position: fixed;
            bottom: 0;
            z-index: 9999;
            width: 96%;
            height:174px;
            background: #ffffff;
            margin-left: 2%;
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 2px 2px 5px #333333;
        }

        .tab .tab_input {
            text-align: center;
            padding-top: 15px;
        }
        .tab .tab_input input {
            width: 95%;
            height: 35px;
            background: rgb(236, 241, 244);
            border-radius: 29px;
            margin: 0 auto;
            border: 1px solid #cccccc;
            padding: 5px;
            box-sizing: border-box;
            outline: none;
            text-indent:10px;
        }

        .tab .tab_imgAll {
            display: flex;
            justify-content: space-around;
            padding-bottom: 10px;
            margin-top: 7px;
        }

        .tab .tab_imgAll img {
            width: 30px;
            height: 30px;
        }

        .tab .tab_imgAll p {
            text-align: center;
            font-size: 13px;
        }
        .tab_imgItem {
            text-align: center;
            cursor: pointer;
        }

        #markerDiv {
            /*width: 200px;*/
            margin: 10px;
        }

        #markerDiv .top {
            display: flex;
            justify-content: space-between;
        }

        #markerDiv .top {
            padding: 5px;
            border-bottom: 1px solid #cccccc;
        }
        #markerDiv .markText {
            margin: 20px 0;
        }
        #markerDiv .markText p {
            overflow: auto;
            height: 170px;
        }
        #markerDiv .content {
            position: relative;
            height: 100px;
            /*width: 200px;*/
            overflow-y: scroll;
            margin: 0 auto;
            border-bottom: 1px solid #ccc;
        }
        #markerDiv .content .scroller {
            position: absolute;
        }
        #markerDiv .content .scroller ul li {
            width: 100%;
            height: 100px;
            overflow-y: scroll;
            white-space: nowrap;
            display: flex;
        }
        #markerDiv .content .scroller ul li img {
            width: 100px;
            height: 100px;
            margin-right: 10px;
        }
        #markerDiv .bottom {
            display: flex;
            justify-content: flex-end;
            cursor: pointer;
            position: absolute;
            bottom: 10px;
            right: 10px;
        }
        #markerDiv .bottom button {
            color: #fff;
            background: #e64340;
            border: none;
            border-radius: 4px;
            padding: 3px 5px;
        }

        .amap-geolocation-con {
            bottom: 145px !important;
            right: 10px !important;
            left: unset !important;
        }

        .amap-zoomcontrol {
            display: none !important;
        }
        .amap-logo {
            display: none !important;
        }
        .amap-copyright {
            display: none !important;
        }
        .amap-info-sharp {
            display: none !important;
        }
      .fadeToggles {
        position: absolute;
        bottom: 159px;
        /*bottom:164px;z-index:1111;*/
        left: 50%;
        transform: translate(-50%, -50%);
        width: 30px;
        height: 30px;
      }
    </style>
</head>

<body onload="mapInit()">
<div id="container">
    <div style="z-index: 99999" class="mapWindowData swiper-container">

    </div>
</div>
<!-- 底部选项 -->
<img onclick="fadeToggles()" class="fadeToggles" src="/public/image/downTriangle.png" alt />
<div class="tab">
    <div class="tab_input">
        <input type="text" placeholder="请输入景点" id="srearchId" />
    </div>

    <div class="tab_imgAll">
        <div class="tab_imgItem" onclick="goToItem(this, 0)">
            <img src="/public/image/city.png" alt />
            <p>城市</p>
        </div>
        <div class="tab_imgItem action" onclick="goToItem(this, 1)">
            <!--     <img src="/public/image/biyou.png" alt />     -->
            <!--默认显示第一个-->
            <img src="/public/image/biyou-select.png" alt />
            <p>必游</p>
        </div>
        <div class="tab_imgItem" onclick="goToItem(this, 2)">
            <img src="/public/image/tuijian.png" alt class="images" />
            <p>推荐</p>
        </div>
        <div class="tab_imgItem" onclick="goToItem(this, 3)">
            <img src="/public/image/zhoumo.png" alt />
            <p>周末</p>
        </div>
        <div class="tab_imgItem" onclick="goToItem(this, 4)">
            <img src="/public/image/marks.png" alt />
            <p>收藏</p>
        </div>
    </div>
    <div class="bannerImage" style="text-align: center;margin: 10px 0;">

    </div>
</div>

<script type="text/javascript">
    var lock = false;
    var types = 1;
    $(function() {
        getMarkList(1,false);
        getBanner()
    });
    //  跳转路由
    function goToItem(index, type) {
        console.log(arguments, 'arg')

        var data = [$('.tab_imgItem')[1], $('.tab_imgItem')[2], $('.tab_imgItem')[3],];
        if (type === 1 || type === 2 || type === 3) {
            data.forEach((v, i, arr) => {
                v.className = 'tab_imgItem';
                arr[type - 1].className = 'tab_imgItem action';
            });
        }
        switch (type) {
            case 0:
                window.location.href = '/index/index/drive.html'; //城市
                break;
            case 1:
                //biyou-select
                $('.tab_imgItem')[type].children[0].outerHTML = '<img src="/public/image/biyou-select.png" alt="">';
                $('.tab_imgItem')[2].children[0].outerHTML = '<img src="/public/image/tuijian.png" alt="">';
                $('.tab_imgItem')[3].children[0].outerHTML = '<img src="/public/image/zhoumo.png" alt="">'
                this.getMarkList(1, '');
                break;
            case 2:
                //tuijian-select
                $('.tab_imgItem')[type].children[0].outerHTML = '<img src="/public/image/tuijian-select.png" alt="">';
                $('.tab_imgItem')[1].children[0].outerHTML = '<img src="/public/image/biyou.png" alt="">';
                $('.tab_imgItem')[3].children[0].outerHTML = '<img src="/public/image/zhoumo.png" alt="">';
                this.getMarkList(2, '');
                break;
            case 3:
                //zhoumo-select
                $('.tab_imgItem')[type].children[0].outerHTML = '<img src="/public/image/zhoumo-select.png" alt="">';
                $('.tab_imgItem')[1].children[0].outerHTML = '<img src="/public/image/biyou.png" alt="">';
                $('.tab_imgItem')[2].children[0].outerHTML = '<img src="/public/image/tuijian.png" alt="">';
                this.getMarkList(3, '');
                break;
            case 4:
                window.location.href = '/index/index/mark.html'; // 景点收藏列表
                break;
        }
    }
  	// 底部菜单隐藏
    function fadeToggles () {
      if (!lock) {
          // lock false up
	      $(".tab").slideUp();
          setTimeout(() => {
	          $('.fadeToggles')[0].style.bottom = '-24px';
              $('.fadeToggles')[0].src = '/public/image/upTriangle.png';
          }, 300)
          lock = true;
      } else {
          // lock false down
	      $(".tab").slideDown();
          $('.fadeToggles')[0].src = '/public/image/downTriangle.png';
          setTimeout(() => {
            // 164
	         $('.fadeToggles')[0].style.bottom = '159px';
          }, 300)
          lock = false;
      }
    }
    // 广告位
    function getBanner () {
        $.ajax({
            type: 'get',
            dataType: 'json',
            url: 'http://www.mangtuyou.com/index/index/getBanner',
            data: {
            },
            success: function(data) {
                console.log(data)
                if (data.Code === 200) {
                    $('.bannerImage').empty()
                    $('.bannerImage').append(`<a href="${data.Url}"><img src="${data.Img}" style="height: 32px;
    max-width: 96%;"/></a>`)
                }
            },
            error: function(err) {
                console.log('这是请求失败的');
            }
        });
    }
    //    搜索
    $('#srearchId').keydown(function(e){
        // 回车事件
        if(e.keyCode==13){
            var srearchValue = $('#srearchId')[0].value;
            // todo 搜索接口
            getMarkList(1, srearchValue);
        }
    });
</script>

<script type="text/javascript">
    //添加Marker
    function AddMarkerBtn() {
        //获取经纬度
        var lnglat = document.getElementById('lnglat').value;
        //获取站点名
        var siteName = document.getElementById('siteName').value;
        //获取站点负责人
        var WorkerName = document.getElementById('WorkerName').value;
        //获取详细地址
        var DeiliteAddress = document.getElementById('tipinput').value;
        //定义经度
        var lng = '';
        //定义纬度
        var lat = '';
        //给经度赋值 从0开始到，结束
        lng = lnglat.substr(0, lnglat.indexOf(','));
        //给纬度赋值   从，后一位开始到数组的总长结束
        lat = lnglat.substr(lnglat.indexOf(',') + 1, lnglat.length - 1);

        if (lnglat == '' || lnglat == null) {
            alert('请单击地图获取坐标或输入相应地址或取坐标后重试！');
        } else {
            if (WorkerName != '' && siteName != '') {
                window.external.addMarker(siteName, WorkerName, lng, lat, DeiliteAddress); //getDebugPath()为c#方法
            } else {
                alert('请填写相关数据！');
            }
        }
    }
    //获取单击的点的经纬度
    function clearMarker(e) {
        //获取到单击的点坐标
        var lat = e.target.getPosition();
        //把坐标存入全局变量
        getlnglatPoint = lat;
    }

    //刷新页面
    function updateMarker() {
        window.external.FindUserMobilephone();
    }

    //全局变量，存储经纬度
    var getlnglatPoint = '';

    //获取参数说明， 定义一个变量，调用GetQueryString("传入参数名");方法即可，返回的是一个数组

    //------------------------------------------------------------------------------------------------接收参数
    //将字符转换为数组的方法,去除分割标志
    function string2Array(stringObj) {
        stringObj = stringObj.replace(/\[([\w, ]*)\]/, '$1');
        if (stringObj.indexOf('[') == 0) {
            // if has chinese
            stringObj = stringObj.substring(1, stringObj.length - 1);
        }
        var arr = stringObj.split('p'); //------------     !!!!!!!!!!!!注意：分割标志p
        var newArray = []; //new Array();
        for (var i = 0; i < arr.length; i++) {
            var arrOne = arr[i];
            newArray.push(arrOne);
        }
        // console.log(newArray);
        return newArray;
    }

    //  创建一个地图
    var map = new AMap.Map('container', {
        resizeEnable: false, //是否监控地图容器尺寸变化，默认值为false
        zoom: 9, //初始化大小，从国到街为3-18
        center: [120.415579, 36.219943] //初始化中心点，传入经纬度
    });

    //定义需要的地图控件，类似于实例化一个对象
    AMap.plugin(
        ['AMap.ToolBar', 'AMap.Scale', 'AMap.MapType', 'AMap.Geolocation'],
        //添加地图控件 若不需要，可直接删除代码
        function() {
            //集成了缩放、平移、定位等功能按钮在内的组合控件  界面操作集成(鼠标右键双击缩小，鼠标左键双击放大，移动，鼠标滑轮缩放)
            map.addControl(new AMap.ToolBar());

            //展示地图在当前层级和纬度下的比例尺 左下
            map.addControl(new AMap.Scale());
            //实现默认图层与卫星图、实施交通图层之间切换的控 右上
            //map.addControl(new AMap.MapType());

            //用来获取和展示用户主机所在的经纬度位置 左下
            map.addControl(new AMap.Geolocation());
        }
    );
    // ----------------------------------点击地图出信息窗口 begin
    var lnglats = [];
    var markData = [];
    var markList = [];
    //		var infoWindow = new AMap.InfoWindow({ offset: new AMap.Pixel(0, -30) });
    //请求景点数据列表
    function getMarkList(type,key) {
       var cityRouterParams = window.location.hash.slice(6) ? decodeURIComponent(window.location.hash.slice(6)) : '';
            //设置跳转到指定城市
            map.setCity(cityRouterParams);
            //设置缩放大小
            map.setZoom(9);
        key = key ? key : '';
        $.ajax({
            type: 'get',
            dataType: 'json',
            url: 'http://www.mangtuyou.com/index/index/getlist',
            data: {
                class: type,
                key:key,
            },
            success: function(data) {
                console.log(data)
                map.remove(markList);
                marker = [];
                lnglats = [];
                markData = [];
                markData = data.data;
                data.data.forEach(v => {
                    lnglats.push([v.lon, v.lat]);

                });
                if (lnglats.length) {
                    for (var i = 0; i < lnglats.length; i++) {
                        var marker = new AMap.Marker({
                            position: lnglats[i],
                            map: map
                        });
                        markList.push(marker);
                        marker.extData = markData[i];
                        marker.on('click', markerClick);
                        //	marker.emit('click', { target: marker });
                    }
                }
            },
            error: function(err) {
                console.log('这是请求失败的');
            }
        });

    }

    //景点收藏
    function markGoTo(id) {
        console.log(id, types);
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'http://www.mangtuyou.com/index/index/marks',
            data: {
                sid: id
            },
            success: function(data) {
                // 景点数据列表
                // getMarkList(types,'');
                if (data.Code > 0) {
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: 'http://www.mangtuyou.com/index/index/getDeatils',
                        data: {
                            id: id,
                        },
                        success: function(data) {
                            $('.mapWindowData').empty();
                            $('.mapWindowData')[0].style.display = 'block';
                            $('.mapWindowData').append(
                                `<div id="markerDiv">
							   <div class="top">
								   <p>${data.data.name_cn}</p>
								   <p onclick="closeMapWindowData()" ><svg class="icon" style="width: 1.5em; height: 1.5em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="603"><path d="M934.605505 139.472542 548.749484 525.343913l385.850905 385.859092-36.751019 36.769438L511.998465 562.099025 126.14756 947.971419l-36.751019-36.746926 385.856022-385.874441L89.392448 139.472542l36.751019-36.745902L512.004605 488.598011 897.85858 102.726639 934.605505 139.472542z" p-id="604"></path></svg></p>
							   </div>
							  <div class="content wrapper" id="wrapper1">
								 <div class="scroller">
									 <ul class="clearfix">
										<li>

										</li>
									 </ul>
								 </div>
							   </div>
							   <div class="markText">
								   <p>${data.data.content_cn}</p>
							   </div>
							   <div class="bottom">
								   <button onclick="markGoTo(${data.data.id})">${data.data.type === 0 ? '收藏' : '已收藏'}</button>
							   </div>
							</div>
                 <div style="width:100%;height:100%;position:fixed;top:0px;left:0px;background:#fff;display:none" id="divimg">
                      </div>
                  `
                            )
                          console.log(data.data.content_cn);
                            data.data.img.forEach((v,i) => {
                                $('.scroller .clearfix li').append(
                                    `<img src="${v}" style="width:200px;float:left;" class="swiper-slide" onclick="bigImage(${i})"/>`
                                )
                            })
                        },
                        error: function(err) {
                            console.log('这是请求失败的');
                        }
                    });
                }

            },
            error: function(err) {
                console.log('这是请求失败的');
            }
        });
    }
    // 点击标点
    function markerClick(e) {
        var outhtml;
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'http://www.mangtuyou.com/index/index/getDeatils',
            data: {
                id: e.target.extData.id,
            },
            success: function(data) {
                $('.mapWindowData').empty();
                $('.mapWindowData')[0].style.display = 'block';
                $('.mapWindowData').append(
                    `<div id="markerDiv">
							   <div class="top">
								   <p>${data.data.name_cn}</p>
								   <p onclick="closeMapWindowData()" ><svg class="icon" style="width: 1.5em; height: 1.5em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="603"><path d="M934.605505 139.472542 548.749484 525.343913l385.850905 385.859092-36.751019 36.769438L511.998465 562.099025 126.14756 947.971419l-36.751019-36.746926 385.856022-385.874441L89.392448 139.472542l36.751019-36.745902L512.004605 488.598011 897.85858 102.726639 934.605505 139.472542z" p-id="604"></path></svg></p>
							   </div>
							  <div class="content wrapper" id="wrapper1">
								 <div class="scroller">
									 <ul class="clearfix">
										<li>

										</li>
									 </ul>
								 </div>
							   </div>
							   <div class="markText">
							   </div>
							   <div class="bottom">
								   <button onclick="markGoTo(${data.data.id})">${data.data.type === 0 ? '收藏' : '已收藏'}</button>
							   </div>
							</div>
                 <div style="width:100%;height:100%;position:fixed;top:0px;left:0px;background:#fff;display:none" id="divimg">
                      </div>`
                )
        
              $('.markText')[0].innerHTML = data.data.content_cn;
                data.data.img.forEach((v,i) => {
                    $('.scroller .clearfix li').append(
                        `<img src="${v}" style="width:200px;float:left;" class="swiper-slide" onclick="bigImage(${i})"/>`
                    )
                })
            },
            error: function(err) {
                console.log('这是请求失败的');
            }
        });
    }
    function bigImage (index) {
        var img= $('.clearfix li img')[index].src;
        $("#divimg").show();
        $("#divimg").empty()
        $("#divimg").append(
            "<img src='"+img+"' style='width:100%;height:100%' onclick='closeImage()'>"
        );
    }
    function closeImage(){
        $("#divimg").hide();
    }
    //关闭当前窗口
    function closeMapWindowData () {
        $('.mapWindowData')[0].style.display = 'none';
    }
    map.setFitView();
    //自适应点分布位置，使点能够显示完全
    map.setFitView();
    // todo 点击收藏
    // $.ajax({
    //     type: "get",
    //     dataType: "json",
    //     url: 'http://www.mangtuyou.com/index/index/marks', // 收藏接口
    //     data: {收藏的城市},
    //     success: function (data) {
    //         console.log("data",data);
    //     },
    //     error:function (err) {
    //         console.log("这是请求失败的");
    //     }
    // });

    //------------------------------------------地址编码解析 begin
    var mapObj;
    var result;
    var marker = [];
    var windowsArr = [];
    function mapInit() {
        mapObj = new AMap.Map('iCenter'); //默认定位：初始化加载地图时，center及level属性缺省，地图默认显示用户所在城市范围
    }
    var MGeocoder;
    var key_11;
    var key_12;
    function geocoder2() {
        //POI搜索，关键字查询
        key_11 = document.getElementById('key_11').value;
        key_12 = document.getElementById('key_12').value;

        if (key_11 == '' || typeof key_11 == null || typeof key_11 == 'undefined') {
            alert('地图还未加载完成，无法获取相应点，请稍后...');
        }

        var lnglatXY = new AMap.LngLat(key_11, key_12);
        //加载地理编码插件
        mapObj.plugin(['AMap.Geocoder'], function() {
            MGeocoder = new AMap.Geocoder({
                radius: 1000,
                extensions: 'all'
            });
            //返回地理编码结果
            AMap.event.addListener(MGeocoder, 'complete', geocoder_CallBack2);
            //逆地理编码
            MGeocoder.getAddress(lnglatXY);
        });

        mapObj.setFitView();
    }

    function geocoder_CallBack2(data) {
        //回调函数
        var resultStr = '';
        var address;
        //返回地址描述
        address = data.regeocode.formattedAddress;
        //返回周边道路信息

        //返回结果拼接输出
        resultStr = '<div style="font-size: 12px;padding:0px 0 4px 2px; border-bottom:1px solid #C1FFC1;">' + '<b>地址</b>：' + address + '</div>';
        document.getElementById('tipinput').value = address;
        document.getElementById('result').innerHTML = resultStr;
    }

    //---------------------------------------------右键菜单    begin

    var contextMenu = new AMap.ContextMenu(); //创建右键菜单
    //右键放大
    contextMenu.addItem(
        '放大一级',
        function() {
            map.zoomIn();
        },
        0
    );
    //右键缩小
    contextMenu.addItem(
        '缩小一级',
        function() {
            map.zoomOut();
        },
        1
    );
    //右键显示全国范围
    contextMenu.addItem(
        '缩放至全国范围',
        function(e) {
            map.setZoomAndCenter(4, [108.946609, 34.262324]);
        },
        2
    );
    //右键添加Marker站点
    contextMenu.addItem(
        '添加站点',
        function(e) {
            addMarker(); //------------------------------------直接写方法，然后把上面的方法删了就行了
        },
        3
    );
    //右键添加Marker站点
    contextMenu.addItem('删除站点', function(e) {}, 4); //  ----------------------------------要添加跟多按钮的时候注意第三个参数不能重复

    //地图绑定鼠标右击事件——弹出右键菜单
    map.on('rightclick', function(e) {
        contextMenu.open(map, e.lnglat);
        contextMenuPositon = e.lnglat;
    });

    //---------------------------------------------右键菜单    begin
</script>
</body>
</html>
