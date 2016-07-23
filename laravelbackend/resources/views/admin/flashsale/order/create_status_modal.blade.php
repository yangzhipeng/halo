
<div class="modal fade" id="createModal" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>添加状态</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="" action="{{ URL::to('admin/flashsale/order/orderDetail/orderStatus'.'/'.$order->order_id.'/create') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="medicineName">订单状态</label> <span style="color:#ff0000;">*</span>
                                <select class="form-control"  name="order_status_code" id="order_status_code">
                                        <option value ="0">未审核</option>
                                        <option value ="1">完成审核</option>
                                        <option value ="2">备货中</option>
                                        <option value ="3">已发货</option>
                                        <option value ="4">已完成</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition"><h5>编辑订单状态</h5></label><span style="color:#ff0000;">*</span>
                                <textarea class="form-control" name="order_status_memo" type="text" rows="3"></textarea>
                            </div>
                            <input class="btn btn-primary" type="submit" id="subbtn" value="提交">
                            <button class="btn btn-default pull-right"  data-dismiss="modal">取消</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
