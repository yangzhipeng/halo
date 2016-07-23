<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-21
 * Time: 下午3:07
 */
?>
@extends('admin.layout.master')

@section('title', '商品计划')

@section('page_title', '秒杀商品')

@section('nav')
    <li>秒杀商品</li>
@endsection

@section('page_description', '商品计划')

@section('flashsale', 'active')

@section('content')
    <div class="row">
        <div class="col-xs-6">
            <form action="/admin/flashsale/plan/planindex" method="get" class="">
                <div class="input-group">
                    @if(isset($query))
                        <input class="form-control" type="text" name="query" id="query" placeholder="商品计划名称" value="{{ $query }}">
                    @else
                        <input class="form-control" type="text" name="query" id="query" placeholder="商品计划名称">
                    @endif
                    <span class="input-group-btn">
                        <button type='submit' name='search' id='search-btn' class="btn btn-primary">查询</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <div class="row" style="margin-top: 20px">

        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">商品计划</h3>
                </div>

                <div class="box-body">

                    <button class="btn btn-primary" id="subBtn" role="button" data-toggle="modal" data-target="#createModal">增加</button>
                    @include('admin.flashsale.plan.create_modal_plan')

                    <table class="table table-bordered table-hover" style="table-layout:fixed">
                        <thead>
                        <tr>
                            <th>标题</th>
                            <th>描述</th>
                            <th>图标</th>
                            <th>学校</th>
                            <th>开始时间</th>
                            <th>结束时间</th>
                            <th>其他说明</th>
                            <th>发布计划</th>
                            <th style="width:16%;text-align: center;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($plans) > 0)
                            @foreach($plans as $plan)
                                <tr>
                                    <td>{{ $plan->title }}</td>
                                    <td>{{ $plan->description }}</td>
                                    <td><img src="{{ Config::get('uni.image_base_url').$plan->icon }}" style="width: 80%;"></td>
                                    <td>{{ $plan->schoolname ? $plan->schoolname : '所有学校' }}</td>
                                    <td>{{ date('Y-m-d H:i:s',$plan->starttime) }}</td>
                                    <td>{{ date('Y-m-d H:i:s',$plan->endtime) }}</td>
                                    <td>{{ $plan->memo }}</td>
                                    @if($plan->status == 1)
                                        <td><input id="statusCheckBtn{{ $plan->id }}" type="checkbox" onchange="isForbiddenAjax({{ $plan->id }})"></td>
                                    @else
                                        <td><input id="statusCheckBtn{{ $plan->id }}" type="checkbox" onchange="isForbiddenAjax({{ $plan->id }})" checked></td>
                                    @endif
                                    <td>
                                        <a href="#updateBtn{{ $plan->id }}"><button name="updateBtn{{ $plan->id }}" class="btn btn-primary btn-xs"role="button" data-toggle="modal" onclick="updatemodal({{ $plan->id }})" data-target="">修改</button></a>
                                        <a href="#delBtn{{ $plan->id }}"><button name="delBtn{{ $plan->id }}" class="btn btn-danger btn-xs" onclick="delPlanConfigOnClickLintener({{ $plan->id }})">删除</button></a>
                                        <a href="/admin/flashsale/p2plan/p2planindex/{{ $plan->id }}"><button  class="btn btn-success btn-xs" >查看商品</button></a>
                                    </td>
                                @include('admin.flashsale.plan.update_modal_plan')
                            @endforeach
                            @include('admin.layout.widgets.comfirm_modal')
                            @include('admin.flashsale.plan.confirm_modal_status')
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-4">
                            <span>共{{ $plans->total() }}条数据,共{{ $plans->lastPage() }}页,当前显示第{{ $plans->currentPage() }}页</span>
                        </div>
                        <div class="col-xs-8">
                            @if(isset($query))
                                <?php echo $plans->appends(['query' => $query])->render(); ?>
                            @else
                                <?php echo $plans->render(); ?>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection

@section('js')
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js") }}" type="text/javascript"></script>
    <script>
        $('#datetimepicker_start').datetimepicker({lang:'ch'});
        $('#datetimepicker_end').datetimepicker({lang:'ch'});
        function updatemodal(id){
            $('button[name="updateBtn'+id+'"]').attr('data-target','#updateModal'+id);
            $('#datetimepicker_upstart_'+id).datetimepicker({lang:'ch'});
            $('#datetimepicker_upend_'+id).datetimepicker({lang:'ch'});
        }
    </script>
    <script>
        function isForbiddenAjax(id)
        {
            var status;
            if($("#statusCheckBtn" + id).prop('checked'))
            {
                status = 0;
                $("#comfirmModal_status").modal('show');
                $("#confirmBtn_status").click(function(){


                    $.ajax({

                        type : 'post',
                        url : '/admin/flashsale/plan/planstatus',
                        data : { 'planId' : id, 'status' : status},
                        dataType : 'json',
                        headers : {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },

                        success : function(data){
                            if(data.code == 1){
                                $("#statusCheckBtn" + id).prop('checked', true);
                                alert('商品计划发布之后不能更改计划状态');return false;
                            }else if(data.code == 0){
                                $("#statusCheckBtn" + id).prop('checked', true)
                            }else if(data.code == 2){
                                $("#statusCheckBtn" + id).prop('checked', false);
                                alert("该活动计划下还没有添加商品,不能发布");
                            }else if(data.code == 3){
                                $("#statusCheckBtn" + id).prop('checked', false);
                                alert(data.message);
                            }else if(data.code == 4){
                                $("#statusCheckBtn" + id).prop('checked', false);
                                alert("该计划已经超过了发布时间，不能发布");
                            }else{
                                if($("#statusCheckBtn" + id).prop('checked')){
                                    $("#statusCheckBtn" + id).prop('checked', true)
                                }else{
                                    $("#statusCheckBtn" + id).prop('checked', false)
                                }
                            }
                        },

                        error : function(xhr, type){
                            alert('ajax error!')
                            $("#statusCheckBtn" + id).prop('checked', false)
                        }

                    });
                });

                $("#cancle_modal").click(function(){
                    $("#statusCheckBtn" + id).prop('checked', false)
                });

            }else{

                $("#statusCheckBtn" + id).prop('checked', true)
            }



        }

        function delPlanConfigOnClickLintener(id)
        {
            $("#modal-content").text("你确定删除么?");
            $("#comfirmModal").modal('show');
            $("#confirSpan").empty();
            $("#confirSpan").append("<button class=\"btn btn-primary pull-left\" id=\"confirmBtn\" onclick=\"planComfirmAction("+ id +")\" data-dismiss=\"modal\">确定</button>")
        }

        function planComfirmAction(id)
        {
            location.href = '/admin/flashsale/plan/deleteplan/' + id;
        }

    </script>
    <script>
        function check_create(){
            title = $("#cr_title").val();
            starttime = $(".cr_starttime").val();
            endtime = $(".cr_endtime").val();
            description = $("#cr_description").val();

            s_time = starttime.replace(/-/g,'/');
            s_time = new Date(s_time);
            s_time = s_time.getTime();

            e_time = endtime.replace(/-/g,'/');
            e_time = new Date(e_time);
            e_time = e_time.getTime();
            if(title.length == 0) {
                $("#tip_title").show();
                return false;
            }else{
                $("#tip_title").hide();
            }

            if(starttime.length == 0) {
                $("#tip_starttime").show();
                return false;
            }else{
                $("#tip_starttime").hide();
            }

            if(endtime.length == 0) {
                $("#tip_endtime").show();
                $("#tip_time").hide();
                return false;
            }else{
                $("#tip_endtime").hide();
            }

            if(e_time - s_time <=0){
                $("#tip_time").show();
                return false;
            }else{
                $("#tip_time").hide();
            }

            if(description.length == 0) {
                $("#tip_description").show();
                return false;
            }else {
                $("#tip_description").hide();
            }
        }

        function check_update(id){
            title = $("#up_title_"+id).val();
            starttime = $(".up_starttime_"+id).val();
            endtime = $(".up_endtime_"+id).val();
            description = $("#up_description_"+id).val();

            s_time = starttime.replace(/-/g,'/');
            s_time = new Date(s_time);
            s_time = s_time.getTime();

            e_time = endtime.replace(/-/g,'/');
            e_time = new Date(e_time);
            e_time = e_time.getTime();

            if(title.length == 0) {
                $("#tip_uptitle_"+id).show();
                return false;
            }else{
                $("#tip_uptitle_"+id).hide();
            }

            if(starttime.length == 0) {
                $("#tip_upstarttime_"+id).show();
                return false;
            }else{
                $("#tip_upstarttime_"+id).hide();
            }

            if(endtime.length == 0) {
                $("#tip_upendtime_"+id).show();
                $("#tip_uptime_"+id).hide();
                return false;
            }else{
                $("#tip_upendtime_"+id).hide();
            }

            if(e_time - s_time <=0){
                $("#tip_uptime_"+id).show();
                return false;
            }else{
                $("#tip_uptime_"+id).hide();
            }

            if(description.length == 0) {
                $("#tip_updescription_"+id).show();
                return false;
            }else {
                $("#tip_updescription_"+id).hide();
            }
        }
    </script>


@endsection