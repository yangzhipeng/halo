<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-22
 * Time: 下午4:45
 */
?>
<div class="modal fade" id="createModal" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>新增秒杀计划的商品</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="" action="{{ URL::to('admin/flashsale/p2plan/create-p2plan/') }}" name="create" onsubmit="return check_create()" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="planId" value="{{ $planId }}">
                            <div class="form-group">
                                <label for="medicineName">商品名称</label> <span style="color:#ff0000;">*</span>
                                <select class="form-control"  name="product" id="product">
                                    @foreach($products as $product)
                                        <option value ="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">本次计划商品数量</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control" type="text" name="quntity" id="cr_quntity" value="" onkeyup="this.value=this.value.replace(/\D/g,'')">
                                <span id="tip_quntity" style="display:none;color: #ff0000; "> 请填写本次计划商品数量</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">销售价格</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control" type="text" name="activity_price" id="cr_activity_price" value="" onkeyup="value=value.replace(/[^\d.]/g,'')">
                                <span id="tip_activity_price" style="display:none;color: #ff0000; "> 请填写销售价格</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">限制每人的购买数量</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control" type="text" name="limit" id="cr_limit" value="" onkeyup="this.value=this.value.replace(/\D/g,'')">
                                <span id="tip_limit" style="display:none;color: #ff0000; "> 请填写购买数量</span>
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


