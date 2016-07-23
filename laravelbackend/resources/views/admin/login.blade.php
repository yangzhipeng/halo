<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Uni后台管理系统</title>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    {{--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />--}}
    <link href="//cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Ionicons -->
    {{--<link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />--}}
    <link href="//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <!-- Theme style -->
    <link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->

    <script src="//cdn.bootcss.com/html5shiv/3.7.3/html5shiv-printshiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="hold-transition login-page">

{{--<div class="container">--}}

    {{--<div class="row">--}}

        {{--<div id="loginModal" class="modal show">--}}
            {{--<div class="modal-dialog">--}}
                {{--<div class="modal-content">--}}
                    {{--<div class="modal-header">--}}
                        {{--<h1 class="text-center text-primary">XX后台管理系统</h1>--}}
                    {{--</div>--}}
                    {{--<div class="modal-body">--}}
                        {{--@include('errors.list')--}}
                        {{--<form action="" class="form col-md-12 center-block" method="post">--}}

                            {{--<input type="hidden" name="_method" value="POST">--}}
                            {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}

                            {{--<div class="form-group">--}}
                                {{--<input type="text" class="form-control input-lg" name="account" id="account" placeholder="管理员账号" required>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<input type="password" class="form-control input-lg" name="password" id="password" placeholder="登录密码" required>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<input class="btn btn-primary btn-lg btn-block" type="submit" value="登录">--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                    {{--<div class="modal-footer">--}}

                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}


    {{--</div>--}}
    {{----}}
    {{----}}
{{--</div>--}}

    <div class="login-box">
        <div class="login-logo">
            <b>Uni后台管理系统</b>
        </div><!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">管理员登录</p>
            @include('admin.notifications')
            <form action="" method="post">

                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="account" id="account" value="{{ old('account')}}" placeholder="管理员账号">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" id="password" placeholder="密码">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                    </div><!-- /.col -->
                </div>
            </form>

        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->


    <!-- jQuery 2.1.4 -->
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
    <!-- Bootstrap 3.3.5 JS -->
    <script src="{{ asset ("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset ("/bower_components/AdminLTE/dist/js/app.min.js") }}" type="text/javascript"></script>

</body>

</html>