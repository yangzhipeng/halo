<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="UTF-8">
    <meta lang="zh-CN">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">-->
    <link href="//cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Ionicons -->
    <!--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
    <link href="//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">

    <link href="{{ URL::asset("/bower_components/AdminLTE/plugins/select2/select2.min.css")}}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ URL::asset("/bower_components/AdminLTE/plugins/morris/morris.css")}}">
    <link rel="stylesheet" href="{{ URL::asset("/bower_components/AdminLTE/plugins/select2/select2.min.css")}}">
    <link rel="stylesheet" href="{{ URL::asset("/bower_components/AdminLTE/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css")}}">
    <link rel="stylesheet" href="{{ URL::asset("/bower_components/AdminLTE/plugins/uploadify/uploadify.css")}}">


    <!-- Theme style -->
    <link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="{{ URL::asset("/bower_components/AdminLTE/dist/css/skins/skin-blue.min.css")}}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->

    <script src="//cdn.bootcss.com/html5shiv/3.7.3/html5shiv-printshiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>


    @yield('header_js')
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <!-- Header -->
    @include('admin.layout.header')

            <!-- Sidebar -->
    @include('admin.layout.sidebar')

            <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('page_title')
                <small>@yield('page_description')</small>
            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i> home </li>
                {{--<li class="active">Here</li>--}}
                @yield('nav')
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            @include('admin.notifications')
            @yield('content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Footer -->
    @include('admin.layout.footer')

</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset ("/bower_components/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
<!-- Bootstrap 3.3.5 JS -->
<script src="{{ asset ("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="{{ asset ("/bower_components/AdminLTE/dist/js/app.min.js") }}" type="text/javascript"></script>

<script src="{{ asset ("/bower_components/AdminLTE/dist/js/main.js") }}" type="text/javascript"></script>

<script src="{{ asset ("/bower_components/AdminLTE/dist/js/json2.js") }}" type="text/javascript"></script>

<script src="{{ asset ("/bower_components/AdminLTE/plugins/uploadify/jquery.uploadify.min.js") }}" type="text/javascript"></script>

@yield('js')

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->
</body>
</html>