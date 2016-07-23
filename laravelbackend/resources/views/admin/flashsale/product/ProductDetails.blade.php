<div class="modal fade" id="detailModal{{ $product->id }}" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>商品具体详情</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="">
                            <div class="form-group">
                                <label for="medicineName">商品id：</label> {{ $product->id}}
                            </div>
                            <div class="form-group">
                                <label for="medicineName">名称：</label> {{ $product->name }}
                            </div>
                            <div class="form-group">
                                <label for="medicineName">商品识别码：</label> {{ $product->product_code }}
                            </div>
                            <div class="form-group">
                                <label for="medicineName">商品品牌id：</label> {{ $product->brand_id  }}
                            </div>
                            <div class="form-group">
                                <label for="medicineName">商品信息描述：</label> {{ $product->description  }}
                            </div>
                            <div class="form-group">
                                <label for="medicineName">商品简介：</label> {{ $product->description_short  }}
                            </div>
                            <div class="form-group">
                                <label for="medicineName">商品图片：</label> <img src="{{ Config::get('uni.image_base_url').$product->icon }}" style="width: 30%;height: auto">
                            </div>
                            <div class="form-group">
                                <label for="medicineN">库存：</label> {{ $product->quantity }}
                             </div>
                            <div class="form-group">
                                <label for="medicineN">市场价格：</label> {{ $product->market_price }}
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">商品参考价格：</label> {{ $product->reference_price }}
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">重量(单位)：</label> {{ $product->weight }}({{ $product->weight_unit }})
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">尺寸：</label> {{ $product->dimension }}
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">历史销售数量：</label> {{ $product->sales_num }}
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">其他说明：</label> {{ $product->memo }}
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">录入时间：</label> {{ date("Y-m-d H:i", $product->creation_time) }}
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">更新时间：</label> {{ date("Y-m-d H:i", $product->update_time)}}
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">状态（0为active,1为inactive）：</label>{{ $product->status }}
                            </div>
                            <button class="btn btn-default pull-right"  data-dismiss="modal">返回</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



