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

@section('page_title', '订单状态')

@section('nav')
    <li>订单状态</li>
@endsection

@section('page_description', '订单')

@section('flashsale', 'active')

@section('content')
    <div class="row" style="margin-top: 20px">

        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{ $order->customer_name }}的订单状态</h3>
                </div>
                <div class="box-body">
                    @if(!isset($query))
                        @if($orderStatus == null)
                            <button class="btn btn-primary" id="subBtn" role="button" data-toggle="modal" data-target="#createModal">增加状态</button>
                            @include('admin.flashsale.order.create_status_modal')
                        @endif
                    @endif
                    <table class="table table-bordered table-hover" style="table-layout:fixed">
                        <thead>
                        <tr>
                            <th>订单id</th>
                            <th>订单状态</th>
                            <th>状态描述</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($orderStatus) > 0)
                                    <td>{{ $orderStatus->order_id }}</td>
                                    {{--<td>{{ $orderStatu->order_status_code }}</td>--}}
                                    @if($orderStatus->order_status_code == 0)
                                        <td>未审核</td>
                                    @elseif($orderStatus->order_status_code == 1)
                                        <td>完成审核</td>
                                    @elseif($orderStatus->order_status_code == 2)
                                        <td>备货中</td>
                                    @elseif($orderStatus->order_status_code == 3)
                                        <td>已发货</td>
                                    @elseif($orderStatus->order_status_code == 4)
                                        <td>已完成</td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>{{ $orderStatus->order_status_memo }}</td>
                                    <td>{{ date("Y-m-d H:i",$orderStatus->update_time)  }}</td>
                                    <td>
                                        <a href="#updateBtn{{ $orderStatus->order_id }}"><button name="updateBtn{{ $orderStatus->order_id }}" class="btn btn-primary btn-xs"role="button" data-toggle="modal" data-target="#updateModal{{ $orderStatus->order_id }}">更新状态</button></a>
                                    </td>
                                    @include('admin.flashsale.order.update_modal_order')
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<script>

    function changeorderStatu(typeId)
    {

        var index = arguments[1] ? arguments[1] : '';

        var text = '';
        switch (parseInt(typeId)){
            case 0 :
                text = '未审核';
                break;
            case 1 :
                text = '完成审核';
                break;
            case 2 :
                text = '备货中';
                break;
            case 3 :
                text = '已发货';
                break;
            case 4 :
                text = '已完成';
                break;
            default :
                text = '';
        }
        $("#orderStatusBtn" + index).text(text + ' ');
        $("#orderStatusBtn" + index).append("<span class='caret'></span>");
        $("#order_status_code" + index).prop('value', parseInt(typeId));
    }

</script>

@endsection