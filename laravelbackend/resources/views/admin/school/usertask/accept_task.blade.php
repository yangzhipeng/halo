<!doctype html>
<html class="no-js">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta name="keywords" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>task</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link href="{{ asset("/bower_components/AdminLTE/amaze/css/amazeui.min.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("/bower_components/AdminLTE/amaze/css/app.css") }}" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="am-g">
    <div data-am-widget="tabs" class="myAppTab am-tabs am-tabs-d2"  >
        <!--START-->
        <div class="am-tabs-bd" style="border: none;width:100%;margin-left:auto; margin-right:auto;">
            <div data-tab-panel-1 class="myAppTabPanel">
                <div class="myAppImgNews">
                    <!--background-->
                    <img style="width: 100%;" src="{{ asset("/bower_components/AdminLTE/amaze/images/bg.png") }}">
                    <div style="position:absolute;left:30%;top:27%;width:40%;text-align:center;">
                        <h1 style="">分享有礼</h1>
                    </div>
                    <div style="position:absolute;left:20%;top:40%;width: 60%;">
                        <span style="color: #555; font-size: 1em;">您已成功领取任务，目前您的分享人数为<span style="color:#ff0000 "> {{ $num }} </span>人</span>
                    </div>
                    <div style="position:absolute;left:33%;top:57%;width: 34%">
                        <img style="width:100%" src="{{ asset("/bower_components/AdminLTE/amaze/images/already_accept.png") }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset ("/bower_components/AdminLTE/amaze/js/jquery.min.js") }}"></script>
<script src="{{ asset ("/bower_components/AdminLTE/amaze/js/geetest.js") }}"></script>
<script src="{{ asset ("/bower_components/AdminLTE/amaze/js/amazeui.min.js") }}"></script>
<script src="{{ asset ("/bower_components/AdminLTE/amaze/js/app.js") }}"></script>
<script type="text/javascript">


</script>
</body>
</html>
