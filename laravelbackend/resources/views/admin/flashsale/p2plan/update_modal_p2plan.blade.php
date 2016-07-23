<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-22
 * Time: 下午4:45
 */
?>
<div class="modal fade" id="updateModal{{ $product2plan->id }}" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>秒杀计划产品详情</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="" action="{{ URL::to('admin/flashsale/p2plan/updatep2plan'.'/'.$product2plan->id) }}" name="update" onsubmit="return check_update({{ $product2plan->id }})" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="productid" value="{{ $product2plan->productid }}">
                            <input type="hidden" name="original_quantity" value="{{ $product2plan->total_activity_quntity }}">
                            <div class="form-group">
                                <label for="medicineCoposition">本次计划商品数量</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control" type="text" name="quntity" id="up_quntity_{{ $product2plan->id }}" value="{{ $product2plan->total_activity_quntity }}" onkeyup="this.value=this.value.replace(/\D/g,'')">
                                <span id="tip_upquntity_{{ $product2plan->id }}" style="display:none;color: #ff0000; "> 请填写本次计划商品数量</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">销售价格</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control" type="text" name="activity_price" id="up_activity_price_{{ $product2plan->id }}" value="{{ $product2plan->activity_price }}" onkeyup="value=value.replace(/[^\d.]/g,'')">
                                <span id="tip_upactivity_price_{{ $product2plan->id }}" style="display:none;color: #ff0000; "> 请填写销售价格</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">限制每人的购买数量</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control" type="text" name="limit" id="up_limit_{{ $product2plan->id }}" value="{{ $product2plan->limit }}" onkeyup="this.value=this.value.replace(/\D/g,'')">
                                <span id="tip_uplimit_{{ $product2plan->id }}" style="display:none;color: #ff0000; "> 请填写购买数量</span>
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



