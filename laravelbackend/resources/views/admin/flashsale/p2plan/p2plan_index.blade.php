<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-22
 * Time: 下午4:45
 */
?>
@extends('admin.layout.master')

@section('title', '秒杀计划的产品')

@section('page_title', '秒杀商品')

@section('nav')
    <li>秒杀计划的产品</li>
@endsection

@section('page_description', '秒杀计划的产品')

@section('flashsale', 'active')

@section('content')
    <div class="row">
        <div class="col-xs-6">
            <form action="/admin/flashsale/p2plan/p2planindex/{{ $planId }}" method="get" class="">
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
                    <h3 class="box-title">秒杀计划的产品</h3>
                </div>

                <div class="box-body">

                    <button class="btn btn-primary" id="subBtn" role="button" data-toggle="modal" data-target="#createModal">增加</button>
                    <a href="/admin/flashsale/plan/planindex"><button class="btn btn-primary" role="button" >返回秒杀计划列表</button></a>
                    @include('admin.flashsale.p2plan.create_modal_p2plan')
                    <table class="table table-bordered table-hover" style="table-layout:fixed">
                        <thead>
                        <tr>
                            <th>计划名称</th>
                            <th>商品名称</th>
                            <th>本次计划商品数量</th>
                            <th>销售价格</th>
                            <th>限制购买数量</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($product2plans) > 0)
                            @foreach($product2plans as $product2plan)
                                <tr>
                                    <td>{{ $planInfo[0]->title }}</td>
                                    <td>{{ $product2plan->productname }}</td>
                                    <td>{{ $product2plan->total_activity_quntity }}</td>
                                    <td>{{ $product2plan->activity_price }}</td>
                                    <td>{{ $product2plan->limit }}</td>
                                    <td>
                                        <a href="#updateBtn{{ $product2plan->id }}"><button name="updateBtn{{ $product2plan->id }}" class="btn btn-primary btn-xs"role="button" data-toggle="modal" data-target="#updateModal{{ $product2plan->id }}">修改</button></a>
                                        <a href="#delBtn{{ $product2plan->id }}"><button name="delBtn{{ $product2plan->id }}" class="btn btn-danger btn-xs" onclick="delP2PlanConfigOnClickLintener({{ $product2plan->id }})">删除</button></a>
                                    </td>
                                @include('admin.flashsale.p2plan.update_modal_p2plan')
                            @endforeach
                            @include('admin.layout.widgets.comfirm_modal')
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-4">
                            <span>共{{ $product2plans->total() }}条数据,共{{ $product2plans->lastPage() }}页,当前显示第{{ $product2plans->currentPage() }}页</span>
                        </div>
                        <div class="col-xs-8">
                            @if(isset($query))
                                <?php echo $product2plans->appends(['query' => $query])->render(); ?>
                            @else
                                <?php echo $product2plans->render(); ?>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection

@section('js')

    <script>

        function delP2PlanConfigOnClickLintener(id)
        {
            $("#modal-content").text("你确定删除么?");
            $("#comfirmModal").modal('show');
            $("#confirSpan").empty();
            $("#confirSpan").append("<button class=\"btn btn-primary pull-left\" id=\"confirmBtn\" onclick=\"p2planComfirmAction("+ id +")\" data-dismiss=\"modal\">确定</button>")
        }

        function p2planComfirmAction(id)
        {
            location.href = '/admin/flashsale/p2plan/deletep2plan/' + id;
        }


    </script>
    <script>
        function check_create(){
            quntity = $("#cr_quntity").val();
            activity_price = $("#cr_activity_price").val();
            limit = $("#cr_limit").val();
            if(quntity.length == 0) {
                $("#tip_quntity").show();
                return false;
            }else{
                $("#tip_quntity").hide();
            }

            if(activity_price.length == 0) {
                $("#tip_activity_price").show();
                return false;
            }else{
                $("#tip_activity_price").hide();
            }

            if(limit.length == 0) {
                $("#tip_limit").show();
                return false;
            }else {
                $("#tip_limit").hide();
            }
        }
        function check_update(id){
            quntity = $("#up_quntity_"+id).val();
            activity_price = $("#up_activity_price_"+id).val();
            limit = $("#up_limit_"+id).val();
            if(quntity.length == 0) {
                $("#tip_upquntity_"+id).show();
                return false;
            }else{
                $("#tip_upquntity_"+id).hide();
            }

            if(activity_price.length == 0) {
                $("#tip_upactivity_price_"+id).show();
                return false;
            }else{
                $("#tip_upactivity_price_"+id).hide();
            }

            if(limit.length == 0) {
                $("#tip_uplimit_"+id).show();
                return false;
            }else {
                $("#tip_uplimit_"+id).hide();
            }
        }
    </script>

@endsection