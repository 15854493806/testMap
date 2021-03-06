<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:30:"./themes/index/index/mark.html";i:1585361854;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <title>收藏的景区</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            list-style: none;
            color: #000000;
        }
        header {
            height: 40px;
            line-height: 40px;
            display: flex;
            align-items: center;
            background: #ffffff;
            border-bottom: 1px solid #cccccc;
        }
        header img {
            width: 15px;
            height: 15px;
            margin-left: 5px;
        }
        header div {
            display: flex;
            justify-content: space-around;
            width: 100%;
        }
        header p {
            font-size: 18px;
            text-align: center;
        }
        .list {
            position: absolute;
            height: 100%;
            width: 100%;
            background: #F1F1F1;
        }

        .list .item {
            display: flex;
            justify-content: space-around;
            padding: 8px;
            align-items: center;
            background: #ffffff;
            border: 1px solid #ffffff;
            margin-bottom: 10px;
          	border-radius: 8px;
   			margin: 7px 5px;
        }
        .list .item .left {
       		width: 70px;
            height: 70px;
        }

        .list .item .left img {
            width: 70px;
            height: 70px;
            position: relative;
            vertical-align: middle;
          	z-index:111;
        }
        .list .item .content {
			width: 174px;
            height: 70px;
        }
        .list .item .content p{
        }
        .list .item .content .editInput {
			width: 106px;
        }
        .list .item .content .over{
            /*display: none;*/

        }
         .list .item .content .over p {
            padding: 7px;
        }

        .list .item .content .over p:first-child {
            // border-bottom: 1px solid #cccccc;
        }

        .list .item .content .load{
            display: none;

        }
        .list .item .line {
            height: 1px;
            border-top: 1px solid;
            width: 80%;
            position: absolute;
            right: 5px;
            margin-top: -2px;
            color:rgba(153, 153, 153, 1);
        }
        .list .item .content .load {
            vertical-align: middle;
        }
        .list .item .content .load p{
            margin-bottom: 7px;
        }
        .list .item .content .load .load1 {
   			height:21px;
            line-height:21px;
        }
       .list .item .content .load .load2 {
           height:35px;
           line-height:35px;
        }
        .list .item .content .load span {
            margin-right: 7px;
            display: inline-block;
        }
        .list .item .content .load input{
            border-radius: 5px;
            border: none;
            padding: 5px;
        }
        .list .item .right p{
            margin-bottom: 7px;
        }
        .list .item .right .save {
            display: none;
        }
        .list .item .right img {
            width: 25px;
            height: 25px;
            vertical-align: middle;
        }
    </style>
</head>

<body>
<div class="list">
    <header>
        <img src="/public/image/back.png" alt="" onclick="window.history.back()">
        <div>
            <p>收藏</p>
        </div>
    </header>
    <div class="lists">
       
    </div>

</div>
</body>

</html>
<script src="/public/js/jquery.min.js"></script>

<script>
    // 初始化获取数据
    $(function () {
       getList()
    })
  //请求收藏列表
    function getList() {
        $.ajax({
            type: "get",
            dataType: "json",
            url: 'http://www.mangtuyou.com/index/index/getmark',
            data: {
            },
            success: function (data) {
                markData = data.data;
                //清空
                $(".lists").empty();
                data.data.forEach((v,i) => {
                    console.log(v)
                    $('.lists').append(
                        `
                          <div class="item">
                                <div class="left">
                                    <img src="${v.img[0]}" alt="">
                                </div>
                                <div class="content">
                                    <div class="over">
                                        <p>名称：<span class="name">${v.name_cn}</span></p>
                                        <p>备注：<span class="note">${v.note}</span></p>
                                    </div>
                                    <div class="load">
                                        <p>
                                         <p class="load1">名称：<span class="name">${v.name_cn}</span></p>
                                        </p>
                                        <p class="load2">
                                            <span>备注：</span><input class="editInput" type="text" placeholder="请输入您的备注信息" />
                                        </p>
                                    </div>
                                </div>
                                <div class="right">
                                    <p onclick="deleteItem(${i})" class="del">
                                        <img src="/public/image/delete.png" alt="">
                                    </p>
                                    <p onclick="edits(${i})" class="edit">
                                        <img src="/public/image/edit.png" alt="">
                                    </p>
                                    <p onclick="save(${i})" class="save">
                                        <img src="/public/image/saved.png" alt="">
                                    </p>
                                </div>
<div class='line'></div>
                            </div>
                        `
                    )
                })
            },
            error:function (err) {
                console.log("这是请求失败的");
            }
        });
    }
    //编辑
    function edits(i) {
        $('.content  .over')[i].style.display = 'none'; //
        $('.content  .load')[i].style.display = 'block'; // 编辑的
        $('.right  .edit')[i].style.display = 'none'; // 隐藏编辑按钮
        $('.right  .save')[i].style.display = 'block'; // 隐藏编辑按钮
    }
    function save(i) {
        console.log($('.editInput'))
        $.ajax({
            type: "post",
            dataType: "json",
            url: 'http://www.mangtuyou.com/index/index/updatemarks',
            data: {
                sid:markData[i].sid,
                id: markData[i].id,
                note: $('.editInput')[i].value
            },
            success: function (data) {
                getList()
            },
            error:function (err) {
                console.log("这是请求失败的");
            }
        });

        $('.content  .over')[i].style.display = 'block';//编辑完成的
        $('.content  .load')[i].style.display = 'none'; //编辑的
        $('.right  .edit')[i].style.display = 'block'; // 隐藏编辑按钮
        $('.right  .save')[i].style.display = 'none'; // 隐藏编辑按钮
    }
    // 删除景点
    function deleteItem(i) {
        $.ajax({
            type: "post",
            dataType: "json",
            url: 'http://www.mangtuyou.com/index/index/delmarks',
            data: {
                id: markData[i].id,
            },
            success: function (data) {
                getList()
            },
            error:function (err) {
                console.log("这是请求失败的");
            }
        });
        console.log(i)
    }
</script>