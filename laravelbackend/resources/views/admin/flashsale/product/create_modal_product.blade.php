<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-21
 * Time: 下午6:17
 */
?>
<div class="modal fade" id="createModal" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>新增商品信息</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="" action="{{ URL::to('admin/flashsale/product/create-product') }}" name="create" onsubmit="return check_create()" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="medicineName">名称</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control" type="text" name="name" id="cr_name" value="">
                                <span id="tip_name" style="display:none;color: #ff0000; "> 请填写商品名称</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineName">商品识别码</label>
                                <input class="form-control" type="text" name="product_code" id="cr_product_code" value="">
                            </div>
                            <div class="form-group">
                                <label for="medicineName">品牌</label> <span style="color:#ff0000;">*</span>
                                <select class="form-control"  name="brand" id="cr_brand">
                                    @foreach($brands as $brand)
                                        <option value ="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group ">
                                <label for="medicineName">类别</label> <span style="color:#ff0000;">*</span>
                                <select class="js-example-basic-multiple" style="width:100%" name="category[]"  id="sel2Multi" multiple="multiple">
                                    @foreach($categorys as $category)
                                        <option value ="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="medicineName">库存</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control" type="text" name="quantity" id="cr_quantity" value=""  onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
                                <span id="tip_quantity" style="display:none;color: #ff0000; "> 请填写商品库存</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineN">市场价格</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control" type="text" name="market_price" id="cr_market_price" value="" onkeyup="value=value.replace(/[^\d.]/g,'')">
                                <span id="tip_market_price" style="display:none;color: #ff0000; "> 请填写商品的市场价格</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineN">参考价格</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control" type="text" name="reference_price" id="cr_reference_price" value="" onkeyup="value=value.replace(/[^\d.]/g,'')">
                                <span id="tip_reference_price" style="display:none;color: #ff0000; "> 请填写商品的参考价格</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineN">重量</label>
                                <input class="form-control" type="text" name="weight" id="cr_weight" value="" onkeyup="value=value.replace(/[^\d.]/g,'')">
                            </div>
                            <div class="form-group">
                                <label for="medicineN">重量单位</label>
                                <input class="form-control" type="text" name="weight_unit" id="cr_weight_unit" value="">
                            </div>
                            <div class="form-group">
                                <label for="medicineN">尺寸</label>
                                <input class="form-control" type="text" name="dimension" id="cr_dimension" value="">
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">商品简介</label> <span style="color:#ff0000;">*</span>
                                <textarea class="form-control" type="text" rows="2" name="description_short" id="cr_description_short"></textarea>
                                <span id="tip_description_short" style="display:none;color: #ff0000; "> 请填写商品的简介</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">商品详细描述</label>
                                <textarea class="form-control" type="text" rows="2" name="description" id="cr_description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">其他说明</label>
                                <textarea class="form-control" type="text" rows="2" name="memo" id="cr_memo"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">图片</label>
                                <input class="form-control" type="file" name="file" id="file">
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">图片集</label>
                                <input class="form-control" type="file" name="file_upload" id="file_upload">
                            </div>

                            <input type="hidden" name="file_path" id="file_path" value="">

                            <input class="btn btn-primary" type="submit" id="subbtn" value="提交">
                            <button class="btn btn-default pull-right"  data-dismiss="modal">取消</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


