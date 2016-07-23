@extends('admin.layout.master')

@section('title', '学校管理')

@section('page_title')
    {{ $schoolName or '学校' }}
@endsection

@section('nav')
    <li>学校管理</li>
    <li class="active">{{ $schoolName or '学校' }}</li>
@endsection

@section('circleuser', 'active')

@section('circleuser_school', 'active')

@section('content')
    @include('admin.layout.widgets.comfirm_modal')
    <div class="row">
        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">功能导航</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li id="dashboard_li"><a id="dashboard_li_a" href="#"><i class="fa fa-dashboard"></i> 数据报表 </a></li>
                        <li id="home_confing_li"><a id="home_confing_li_a" href="#"><i class="fa fa-cog"></i> 首页配置 </a></li>
                        <li id="adv_top_li"><a id="adv_top_li_a" href="#"><i class="fa fa-file-text-o"></i> 顶部Banner广告 </a></li>
                        <li id="adv_mul_li"><a id="adv_mul_li_a" href="#"><i class="fa fa-file-text-o"></i> 多样式广告 </a></li>
                        <li id="bizcard_li"><a id="bizcard_li_a" href="#"><i class="fa fa-thumbs-o-up"></i> 推荐会员卡 </a></li>
                        <li id="youliMsg_li"><a id="youliMsg_li_a" href="#"><i class="fa fa-envelope-o"></i> 优里短信 </a></li>
                        <li id="task_li"><a id="task_li_a" href="#"><i class="fa fa-envelope-o"></i> 群发任务 </a></li>
                    </ul>
                </div><!-- /.box-body -->
            </div><!-- /. box -->
        </div>

        <div class="col-md-9">

            {{--@yield('schoolContent')--}}
            @if(isset($schoolMoudelId))
                @if(Config::get('uni.school_dashboard') == $schoolMoudelId)
                    @include('admin.circleschool.dashboard.index')
                @elseif(Config::get('uni.school_home_config') == $schoolMoudelId)
                    @include('admin.circleschool.home_config.index')
                @elseif(Config::get('uni.school_adv_top_banner') == $schoolMoudelId)
                    @include('admin.circleschool.adv.top_banner_index')
                @elseif(Config::get('uni.school_msg') == $schoolMoudelId)
                    @include('admin.circleschool.youliMsg.index')
                @elseif(Config::get('uni.school_bizcard') == $schoolMoudelId)
                    @include('admin.circleschool.bizcard.index')
                @elseif(Config::get('uni.school_task') == $schoolMoudelId)
                    @include('admin.circleschool.task.index')
                @elseif(Config::get('uni.school_adv_multiple') == $schoolMoudelId)
                    @include('admin.circleschool.adv.multi_style_index')
                @else
                    @include('admin.circleschool.dashboard.index')
                @endif
            @else
                @include('admin.circleschool.dashboard.index')
            @endif

        </div>
    </div>

@endsection

@section('js')

    <script src="{{ asset ("/bower_components/AdminLTE/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js") }}" type="text/javascript"></script>

    <script src="https://cdn.bootcss.com/raphael/2.1.0/raphael-min.js"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/morris/morris.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js") }}" type="text/javascript"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js") }}" type="text/javascript"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js") }}" type="text/javascript"></script>

    <script>


        var chart = new Morris.Area({
            element: 'revenue-chart',
            resize: true,
            data: [],
            xkey: 'x',
            ykeys: ['item1'],
            labels: ['新增人数'],
            lineColors: ['#a0d0e0'],
            hideHover: 'auto'
        });

        var chartYear = new Morris.Area({
            element: 'revenue-chart-year',
            resize: true,
            data: [],
            xkey: 'x',
            ykeys: ['y'],
            labels: ['新增人数'],
            lineColors: ['#a0d0e0'],
            hideHover: 'auto'
        });


        $(function(){
            $("#day").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
        })

        function changeDayAjax()
        {
            var schoolid = '{{ $schoolid or 0}}';
            var day = $("#day").prop('value');

            if(day != '')
            {
                $.ajax({

                    type : 'post',
                    url : '/admin/circleschool/dashboard/changeday',
                    data : { 'date' : day, 'schoolid': schoolid  },
                    dataType : 'json',
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },

                    success : function(data){


                        if(data.dataArray.length > 0)
                        {
                            $.each(data.dataArray, function(index, item){

                                var newData = [
                                    {x: (item.one).x, item1:parseInt((item.one).y)},
                                    {x: (item.tow).x, item1:parseInt((item.tow).y)},
                                    {x: (item.three).x, item1:parseInt((item.three).y)},
                                    {x: (item.four).x, item1:parseInt((item.four).y)},
                                    {x: (item.five).x, item1:parseInt((item.five).y)},
                                    {x: (item.six).x, item1:parseInt((item.six).y)},
                                    {x: (item.seven).x, item1:parseInt((item.seven).y)},
                                ];

                                chart.setData(newData);

                            })
                        }
                    },

                    error : function(xhr, type){
                        alert('ajax error!');
                    }

                });
            }else{
                alert('日期为空!');
            }
        }

        function changeYearAjax()
        {

            var year = $("#year").prop('value');
            var schoolid = '{{ $schoolid or 0}}';
            if(year != '')
            {
                $.ajax({

                    type : 'post',
                    url : '/admin/circleschool/dashboard/changeyear',
                    data : { 'date' : year,'schoolid': schoolid },
                    dataType : 'json',
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },

                    success : function(data){

                        chartYear.setData(data.dataArray);

                    },

                    error : function(xhr, type){
                        alert('ajax error!');
                    }

                });
            }else{
                alert('日期为空!');
            }
        }
        changeDayAjax();
        changeYearAjax();
    </script>

    <script>

        //时间选择器
        $("#task_form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});

        var schoolModelId = parseInt('{{ $schoolMoudelId or 101}}');
        var schoolId = '{{ $schoolid or 0}}';

        function selectedLi()
        {
            switch (schoolModelId){

                case 101:
                    $('#dashboard_li').prop('class', 'active');
                    $("#dashboard_li_a").prop('href', '#');
                    $("#home_confing_li_a").prop('href', '/admin/circleschool/' + schoolId + '/homeconfig');
                    $("#adv_top_li_a").prop('href', '/admin/circleschool/' + schoolId + '/top-adv');
                    $("#adv_mul_li_a").prop('href', '/admin/circleschool/' + schoolId + '/mul-adv');
                    $("#youliMsg_li_a").prop('href','/admin/circleschool/' + schoolId + '/youlimsg');
                    $("#bizcard_li_a").prop('href', '/admin/circleschool/' + schoolId + '/bizcard');
                    $("#task_li_a").prop('href', '/admin/circleschool/' + schoolId + '/task');
                    break;
                case 102:
                    $('#home_confing_li').prop('class', 'active');
                    $("#dashboard_li_a").prop('href', '/admin/circleschool/' + schoolId + '/dashboard');
                    $("#home_confing_li_a").prop('href', '#');
                    $("#adv_top_li_a").prop('href', '/admin/circleschool/' + schoolId + '/top-adv');
                    $("#adv_mul_li_a").prop('href', '/admin/circleschool/' + schoolId + '/mul-adv');
                    $("#youliMsg_li_a").prop('href','/admin/circleschool/' + schoolId + '/youlimsg');
                    $("#bizcard_li_a").prop('href', '/admin/circleschool/' + schoolId + '/bizcard');
                    $("#task_li_a").prop('href', '/admin/circleschool/' + schoolId + '/task');
                    break;
                case 103:
                    $('#adv_top_li').prop('class', 'active');
                    $("#dashboard_li_a").prop('href', '/admin/circleschool/' + schoolId + '/dashboard');
                    $("#home_confing_li_a").prop('href', '/admin/circleschool/' + schoolId + '/homeconfig');
                    $("#youliMsg_li_a").prop('href','/admin/circleschool/' + schoolId + '/youlimsg');
                    $("#adv_top_li_a").prop('href', '#');
                    $("#adv_mul_li_a").prop('href', '/admin/circleschool/' + schoolId + '/mul-adv');
                    $("#bizcard_li_a").prop('href', '/admin/circleschool/' + schoolId + '/bizcard');
                    $("#task_li_a").prop('href', '/admin/circleschool/' + schoolId + '/task');
                    break;
                case 104:
                    $('#youliMsg_li').prop('class', 'active');
                    $("#dashboard_li_a").prop('href', '/admin/circleschool/' + schoolId + '/dashboard');
                    $("#home_confing_li_a").prop('href', '/admin/circleschool/' + schoolId + '/homeconfig');
                    $("#adv_top_li_a").prop('href', '/admin/circleschool/' + schoolId + '/top-adv');
                    $("#adv_mul_li_a").prop('href', '/admin/circleschool/' + schoolId + '/mul-adv');
                    $("#youliMsg_li_a").prop('href', '#');
                    $("#bizcard_li_a").prop('href', '/admin/circleschool/' + schoolId + '/bizcard');
                    $("#task_li_a").prop('href', '/admin/circleschool/' + schoolId + '/task');
                    break;
                case 105:
                    $('#bizcard_li').prop('class', 'active');
                    $("#dashboard_li_a").prop('href', '/admin/circleschool/' + schoolId + '/dashboard');
                    $("#home_confing_li_a").prop('href', '/admin/circleschool/' + schoolId + '/homeconfig');
                    $("#adv_top_li_a").prop('href', '/admin/circleschool/' + schoolId + '/top-adv');
                    $("#adv_mul_li_a").prop('href', '/admin/circleschool/' + schoolId + '/mul-adv');
                    $("#youliMsg_li_a").prop('href','/admin/circleschool/' + schoolId + '/youlimsg');
                    $("#bizcard_li_a").prop('href', '#');
                    $("#task_li_a").prop('href', '/admin/circleschool/' + schoolId + '/task');
                    break;
                case 106:
                    $('#task_li').prop('class', 'active');
                    $("#dashboard_li_a").prop('href', '/admin/circleschool/' + schoolId + '/dashboard');
                    $("#home_confing_li_a").prop('href', '/admin/circleschool/' + schoolId + '/homeconfig');
                    $("#adv_top_li_a").prop('href', '/admin/circleschool/' + schoolId + '/top-adv');
                    $("#adv_mul_li_a").prop('href', '/admin/circleschool/' + schoolId + '/mul-adv');
                    $("#youliMsg_li_a").prop('href','/admin/circleschool/' + schoolId + '/youlimsg');
                    $("#bizcard_li_a").prop('href', '/admin/circleschool/' + schoolId + '/bizcard');
                    $("#task_li_a").prop('href', '#');
                    break;
                case 107:
                    $('#adv_mul_li').prop('class', 'active');
                    $("#dashboard_li_a").prop('href', '/admin/circleschool/' + schoolId + '/dashboard');
                    $("#home_confing_li_a").prop('href', '/admin/circleschool/' + schoolId + '/homeconfig');
                    $("#youliMsg_li_a").prop('href','/admin/circleschool/' + schoolId + '/youlimsg');
                    $("#adv_top_li_a").prop('href', '/admin/circleschool/' + schoolId + '/top-adv');
                    $("#adv_mul_li_a").prop('href', '#');
                    $("#bizcard_li_a").prop('href', '/admin/circleschool/' + schoolId + '/bizcard');
                    $("#task_li_a").prop('href', '/admin/circleschool/' + schoolId + '/task');
                    break;
                default :
                    $('#dashboard_li').prop('class', 'active');
                    $("#dashboard_li_a").prop('href', '#');
                    $("#home_confing_li_a").prop('href', '/admin/circleschool/' + schoolId + '/homeconfig');
                    $("#adv_top_li_a").prop('href', '/admin/circleschool/' + schoolId + '/top-adv');
                    $("#adv_mul_li_a").prop('href', '/admin/circleschool/' + schoolId + '/mul-adv');
                    $("#youliMsg_li_a").prop('href','/admin/circleschool/' + schoolId + '/youlimsg');
                    $("#bizcard_li_a").prop('href', '/admin/circleschool/' + schoolId + '/bizcard');
                    $("#task_li_a").prop('href', '/admin/circleschool/' + schoolId + '/task');
                    break;
        }
    }

    selectedLi();


</script>

@endsection
