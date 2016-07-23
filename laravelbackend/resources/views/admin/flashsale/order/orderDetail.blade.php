<?php
/**
 * Created by PhpStorm.
 * User: YOUNG
 * Date: 2016-04-28
 * Time: 16:36
 */
?>
@extends('admin.layout.master')

@section('title', '订单')

@section('page_title', '订单详情')

@section('nav')
    <li>订单详情</li>
@endsection

@section('page_description', '订单')

@section('flashsale', 'active')

@section('content')
    <div class="row">
        <div class="col-xs-6">
            <form action="/admin/flashsale/order/orderDetail" method="get" class="">
                <div class="input-group">
                    @if(isset($query))
                        <input class="form-control" type="text" name="query" id="query" placeholder="订单名" value="{{ $query }}">
                    @else
                        <input class="form-control" type="text" name="query" id="query" placeholder="买家姓名或收件人手机">
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
                    <h3 class="box-title">订单列表</h3>
                </div>

                <div class="box-body">

                  <table class="table table-bordered table-hover" style="table-layout:fixed">
                        <thead>
                        <tr>
                            <th>买家姓名</th>
                            <th>买家学校</th>
                            <th>收件人姓名</th>
                            <th>收件人地址</th>
                            <th>收件人手机</th>
                            <th>邮编</th>
                            <th>发票抬头</th>
                            <th>发票寄址</th>
                            <th>收票人手机</th>
                            <th>订单总价</th>
                            <th>创建时间</th>
                            <th>订单状态</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($orders) > 0)
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>{{ $order->customer_school_name }}</td>
                                    <td>{{ $order->delivery_name }}</td>
                                    <td>{{ $order->delivery_address }}</td>
                                    <td>{{ $order->delivery_mobile }}</td>
                                    <td>{{ $order->delivery_postcode }}</td>
                                    <td>{{ $order->billing_company }}</td>
                                    <td>{{ $order->billing_to_address }}</td>
                                    <td>{{ $order->billing_mobile }}</td>
                                    <td>{{ $order->total_price }}</td>
                                    <td>{{ date("Y-m-d H:i",$order->creation_time)  }}</td>
                                    <td>
                                        <a href="{{ URL::to('admin/flashsale/order/orderDetail/orderStatus').'/'.$order->order_id }}"><button class="btn btn-primary btn-xs">点击查看</button></a>
                                    </td>
                                    @endforeach
                                @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-4">
                            <span>共{{ $orders->total() }}条数据,共{{ $orders->lastPage() }}页,当前显示第{{ $orders->currentPage() }}页</span>
                        </div>
                        <div class="col-xs-8">
                            @if(isset($query))
                                <?php echo $orders->appends(['query' => $query])->render(); ?>
                            @else
                                <?php echo $orders->render(); ?>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection