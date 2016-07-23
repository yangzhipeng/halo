<?php
/**
 * Created by PhpStorm.
 * User: YOUNG
 */
?>
<div class="modal fade" id="updateModal{{ $orderStatus->order_id }}" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>订单状态</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="" action="{{ URL::to('admin/flashsale/order/orderDetail/orderStatus/updateStatu'.'/'.$orderStatus->order_id) }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="medicineCoposition">订单状态</label>
{{--
                                <input class="form-control" type="text" rows="3" name="order_status_code" id="order_status_code" value="{{ $orderStatu->order_status_code }}">
--}}
                                <input class="form-control" type="hidden" name="order_status_code" id="order_status_code{{ $orderStatus->order_id }}" value="{{ $orderStatus->order_status_code }}">
                                <div class="btn-group">
                                    <button id="orderStatusBtn{{ $orderStatus->order_id }}" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        @if($orderStatus->order_status_code == 0)
                                            未审核
                                        @elseif($orderStatus->order_status_code == 1)
                                            完成审核
                                        @elseif($orderStatus->order_status_code == 2)
                                            备货中
                                        @elseif($orderStatus->order_status_code == 3)
                                            已发货
                                        @elseif($orderStatus->order_status_code == 4)
                                            已完成
                                        @endif
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" id="" name="" >
                                        <li id="" onclick="changeorderStatu(0, '{{ $orderStatus->order_id }}')"><a href="#">未审核</a></li>
                                        <li id="" onclick="changeorderStatu(1, '{{ $orderStatus->order_id }}')"><a href="#">完成审核</a></li>
                                        <li id="" onclick="changeorderStatu(2, '{{ $orderStatus->order_id }}')"><a href="#">备货中</a></li>
                                        <li id="" onclick="changeorderStatu(3, '{{ $orderStatus->order_id }}')"><a href="#">已发货</a></li>
                                        <li id="" onclick="changeorderStatu(4, '{{ $orderStatus->order_id }}')"><a href="#">已完成</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">订单状态描述</label>
                                <textarea class="form-control" type="text" rows="3" name="order_status_memo" id="order_status_memo" >{{ $orderStatus->order_status_memo }}</textarea>
                            </div>

                            <input class="btn btn-primary" type="submit" id="subbtn" value="修改">
                            <button class="btn btn-default pull-right"  data-dismiss="modal">取消</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
