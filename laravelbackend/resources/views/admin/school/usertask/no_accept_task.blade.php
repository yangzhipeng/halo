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
                    <div style="position:absolute;left:30%;top:25%;width:40%;text-align:center;">
                        <h1 style="">分享有礼</h1>
                    </div>
                    <div class="content" style="position:absolute;left:18%;top:31%;width: 65%;">
                        <span class="text" style="color: #555; font-size: 0.9em;">
                            1.点击“立即领取”按钮;<br />
                            2.返回首页找到校里推荐的商家"古春堂";<br/>
                            3.点击右下角"分享"按钮,分享会员卡给好友;<br/>
                            4.分享人数达 {{ $taskinfo->share_num }} 人即可领取现金红包。
                        </span>
                    </div>
                    <div style="position:absolute;left:33%;top:58%;width: 34%">
                        <img class="accept" style="width:100%" onclick="accept({{ $taskinfo->id }},{{ $cid }})" src="{{ asset("/bower_components/AdminLTE/amaze/images/accept.png") }}">
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
<script>
    function accept(taskid,cid)
    {

        $.ajax({

            type : 'post',
            url : '/admin/school/usertask/accepttask',
            data : { 'taskid' : taskid, 'cid' : cid},
            dataType : 'json',
            headers : {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },

            success : function(data){
                if(data.code == 1){
                    $(".accept").attr('src','{{ asset("/bower_components/AdminLTE/amaze/images/already_accept.png") }}');
                    $(".accept").attr('onclick','');
                }else if(data.code == 0){
                    window.location.href = '/admin/school/usertask/index?cid='+cid;
                }else if(data.code == 2){
                    alert('异常错误');
                    window.location.href = '/admin/school/usertask/index?cid='+cid;
                }
            },

            error : function(xhr, type){
                alert('ajax error!')
            }

        });
    }

</script>
</body>
</html>

