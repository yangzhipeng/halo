@extends('admin.layout.master')

@section('title', '数据报表')

@section('page_title', '数据报表')

@section('nav')
    <li>数据报表</li>
@endsection

@section('page_description', '数据报表')

@section('dashboard', 'active')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">

                <div class="box-body">

                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>{{ $userCount }}</h3>
                                <p>用户总数</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div><!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{{ $newUser }}</h3>
                                <p>今天新增用户数</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div><!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>{{ $action_user_today }}</h3>
                                <p>今天活跃用户数</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-pulse-strong"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div><!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3>{{ $action_user_yesterday }}</h3>
                                <p>昨天活跃用户数</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-pulse"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div><!-- ./col -->

                </div>

                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-4 col-xs-offset-8" style="padding-right: 35px">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input id="day" type="text" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" value="{{ date('Y-m-d') }}" data-mask>
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-flat" type="button" onclick="changeDayAjax()">Go!</button>
                                        </span>
                                    </div><!-- /.input group -->
                                </div><!-- /.form group -->
                        </div>
                    </div>
                    <h4 style="width: 100%;text-align: center">周数据折线图</h4>
                    <div class="nav-tabs-custom">
                        <!-- Tabs within a box -->
                        <div class="tab-content no-padding">
                            <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
                        </div>
                    </div><!-- /.nav-tabs-custom -->

                    <div class="row" style="margin-top: 20px">
                        <div class="col-xs-4 col-xs-offset-8" style="padding-right: 35px">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="year" type="text" class="form-control" data-inputmask="'alias': 'yyyy'" value="{{ date('Y') }}" data-mask>
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-flat" type="button" onclick="changeYearAjax()">Go!</button>
                                        </span>
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->
                        </div>
                    </div>
                    <h4 style="width: 100%;text-align: center">年数据折线图</h4>
                    <div class="nav-tabs-custom">
                        <!-- Tabs within a box -->
                        <div class="tab-content no-padding">
                            <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" id="revenue-chart-year" style="position: relative; height: 300px;"></div>
                        </div>
                    </div><!-- /.nav-tabs-custom -->

                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdn.bootcss.com/raphael/2.1.0/raphael-min.js"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/morris/morris.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js") }}" type="text/javascript"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js") }}" type="text/javascript"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js") }}" type="text/javascript"></script>

    <script>


        var chart = new Morris.Area({
            element: 'revenue-chart',
            resize: true,
            data: [
                {x: '{{ $dataArray['one']['x']  }}', item1:parseInt('{{ $dataArray['one']['y']  }}')},
                {x: '{{ $dataArray['tow']['x']  }}', item1:parseInt('{{ $dataArray['tow']['y']  }}')},
                {x: '{{ $dataArray['three']['x']  }}', item1:parseInt('{{ $dataArray['three']['y']  }}')},
                {x: '{{ $dataArray['four']['x']  }}', item1:parseInt('{{ $dataArray['four']['y']  }}')},
                {x: '{{ $dataArray['five']['x']  }}', item1:parseInt('{{ $dataArray['five']['y']  }}')},
                {x: '{{ $dataArray['six']['x']  }}', item1:parseInt('{{ $dataArray['six']['y']  }}')},
                {x: '{{ $dataArray['seven']['x']  }}', item1:parseInt('{{ $dataArray['seven']['y']  }}')},
            ],
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

            var day = $("#day").prop('value');

            if(day != '')
            {
                $.ajax({

                    type : 'post',
                    url : '/admin/dashboard/changeday',
                    data : { 'date' : day },
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

            if(year != '')
            {
                $.ajax({

                    type : 'post',
                    url : '/admin/dashboard/changeyear',
                    data : { 'date' : year },
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

        changeYearAjax();
    </script>

@endsection