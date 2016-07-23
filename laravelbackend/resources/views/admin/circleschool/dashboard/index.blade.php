
  <div class="box box-primary">
                 <div class="box-header with-border">
                    <h3 class="box-title">数据报表</h3>
                 </div>
                <div class="box-body">

                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>{{ $schoolUserCount }}</h3>
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
                                <h3>{{ $schoolNewUser }}</h3>
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
                                <h3>{{ $school_action_user_today }}</h3>
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
                                <h3>{{ $school_action_user_yesterday }}</h3>
                                <p>昨天活跃用户数</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-pulse"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div><!-- ./col -->

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


