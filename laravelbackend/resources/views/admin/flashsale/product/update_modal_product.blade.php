<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-21
 * Time: 上午9:34
 */
?>
<div class="modal fade" id="updateModal{{ $product->id }}" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>商品详情</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="" action="{{ URL::to('admin/flashsale/product/updateproduct'.'/'.$product->id) }}" name="update" onsubmit="return check_update({{ $product->id }})" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="medicineName">名称</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control" type="text" name="name" id="up_name_{{ $product->id }}" value="{{ $product->name }}">
                                <span id="tip_upname_{{ $product->id }}" style="display:none;color: #ff0000; "> 请填写商品名称</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineName">商品识别码</label>
                                <input class="form-control" type="text" name="product_code" id="product_code" value="{{ $product->product_code }}">
                            </div>
                            <div class="form-group">
                                <label for="medicineName">品牌</label> <span style="color:#ff0000;">*</span>
                                <select class="form-control" name="brand" id="brand">
                                    @foreach($brands as $brand)
                                        <option value ="{{ $brand->id }}"
                                        @if($product->brand_id == $brand->id){{'selected'}}
                                                @endif>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="medicineName">类别</label> <span style="color:#ff0000;">*</span>
                                <select class="js-example-basic-multiple" style="width:100%" name="category[]" id="category" multiple="multiple">
                                    @foreach($categorys as $category)
                                        <?php
                                            $blag = 0;
                                            $categorys_id = explode(',',$product->categorys_id);
                                            foreach($categorys_id as $categoryid){
                                                if($categoryid == $category->id){
                                                    $blag = 1;
                                                    break;
                                                }
                                            }
                                        ?>
                                        <option value ="{{ $category->id }}"
                                        @if($blag == 1)
                                            {{'selected'}}
                                        @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="medicineName">库存</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control" type="text" name="quantity" id="up_quantity_{{ $product->id }}" value="{{ $product->quantity }}">
                                <span id="tip_upquantity_{{ $product->id }}" style="display:none;color: #ff0000; "> 请填写商品库存</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineN">市场价格</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control" type="text" name="market_price" id="up_market_price_{{ $product->id }}" value="{{ $product->market_price }}">
                                <span id="tip_upmarket_price_{{ $product->id }}" style="display:none;color: #ff0000; "> 请填写商品的市场价格</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineN">参考价格</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control" type="text" name="reference_price" id="up_reference_price_{{ $product->id }}" value="{{ $product->reference_price }}">
                                <span id="tip_upreference_price_{{ $product->id }}" style="display:none;color: #ff0000; "> 请填写商品的参考价格</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineN">重量</label>
                                <input class="form-control" type="text" name="weight" id="weight" value="{{ $product->weight }}">
                            </div>
                            <div class="form-group">
                                <label for="medicineN">重量单位</label>
                                <input class="form-control" type="text" name="weight_unit" id="weight_unit" value="{{ $product->weight_unit }}">
                            </div>
                            <div class="form-group">
                                <label for="medicineN">尺寸</label>
                                <input class="form-control" type="text" name="dimension" id="dimension" value="{{ $product->dimension }}">
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">商品简介</label> <span style="color:#ff0000;">*</span>
                                <textarea class="form-control" type="text" rows="2" name="description_short" id="up_description_short_{{ $product->id }}">{{ $product->description_short }}</textarea>
                                <span id="tip_updescription_short_{{ $product->id }}" style="display:none;color: #ff0000; "> 请填写商品的简介</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">商品详细描述</label>
                                <textarea class="form-control" type="text" rows="2" name="description" id="description">{{ $product->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">其他说明</label>
                                <textarea class="form-control" type="text" rows="2" name="memo" id="memo">{{ $product->memo }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">图片</label>
                                <input class="form-control" type="file" name="file" id="file">
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">图片集</label>
                                <input class="form-control" type="file" name="edit_file_upload" id="edit_file_upload_{{ $product->id }}">
                            </div>

                            <input type="hidden" name="edit_file_path" id="edit_file_path_{{ $product->id }}" value="">
                            <input class="btn btn-primary" type="submit" id="subbtn" value="修改">
                            <button class="btn btn-default pull-right"  data-dismiss="modal">取消</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



