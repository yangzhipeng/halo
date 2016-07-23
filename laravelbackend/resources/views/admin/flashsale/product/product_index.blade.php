<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-21
 * Time: 上午9:30
 */
?>
@extends('admin.layout.master')

@section('title', '商品')

@section('page_title', '秒杀商品')

@section('nav')
    <li>秒杀商品</li>
@endsection

@section('page_description', '商品')

@section('flashsale', 'active')

@section('content')
    <div class="row">
        <div class="col-xs-6">
            <form action="/admin/flashsale/product/productindex" method="get" class="">
                <div class="input-group">
                    @if(isset($query))
                        <input class="form-control" type="text" name="query" id="query" placeholder="商品名称" value="{{ $query }}">
                    @else
                        <input class="form-control" type="text" name="query" id="query" placeholder="商品名称">
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
                    <h3 class="box-title">商品列表</h3>
                </div>

                <div class="box-body">

                    <button class="btn btn-primary" id="subBtn" role="button" data-toggle="modal" data-target="#createModal">增加</button>
                    @include('admin.flashsale.product.create_modal_product')

                    <table class="table table-bordered table-hover" style="table-layout:fixed">
                        <thead>
                        <tr>
                            <th>名称</th>
                            <th>品牌</th>
                            <th>类别</th>
                            <th>简介</th>
                            <th>图片</th>
                            <th>库存</th>
                            <th>市场价格</th>
                            <th>参考价格</th>
                            <th style="width:9%">重量(单位)</th>
                            <th>是否可用</th>
                            <th style="width:10%;margin: auto auto;">操作</th>
                            <th>具体详情</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($products) > 0)
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->brandname }}</td>
                                    <td>{{ $product->categorys }}</td>
                                    <td>{{ $product->description_short }}</td>
                                    <td><img src="{{ Config::get('uni.image_base_url').$product->icon }}" style="width: 100%;height: auto"></td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->market_price }}</td>
                                    <td>{{ $product->reference_price }}</td>
                                    <td>{{ $product->weight }}({{ $product->weight_unit }})</td>

                                    @if($product->status == 1)
                                        <td><input id="statusCheckBtn{{ $product->id }}" type="checkbox" onchange="isForbiddenAjax({{ $product->id }})"></td>
                                    @else
                                        <td><input id="statusCheckBtn{{ $product->id }}" type="checkbox" onchange="isForbiddenAjax({{ $product->id }})" checked></td>
                                    @endif
                                    <td>
                                        <a href="#updateBtn{{ $product->id }}"><button name="updateBtn{{ $product->id }}" class="btn btn-primary btn-xs"role="button" data-toggle="modal" data-target="#updateModal{{ $product->id }}"  onclick="uploadi({{ $product->id }})">修改</button></a>
                                        <a href="#delBtn{{ $product->id }}"><button name="delBtn{{ $product->id }}" class="btn btn-danger btn-xs" onclick="delProductConfigOnClickLintener({{ $product->id }})">删除</button></a>
                                    </td>
                                   @include('admin.flashsale.product.update_modal_product')
                                    <td>
                                        <a href="#detailBtn{{ $product->id }}"><button name="detailBtn{{ $product->id }}" class="btn btn-primary btn-xs"role="button" data-toggle="modal" data-target="#detailModal{{ $product->id }}">查看详情</button></a>
                                    </td>
                                    @include('admin.flashsale.product.ProductDetails')
                            @endforeach
                                    @include('admin.layout.widgets.comfirm_modal')

                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-4">
                            <span>共{{ $products->total() }}条数据,共{{ $products->lastPage() }}页,当前显示第{{ $products->currentPage() }}页</span>
                        </div>
                        <div class="col-xs-8">
                            @if(isset($query))
                                <?php echo $products->appends(['query' => $query])->render(); ?>
                            @else
                                <?php echo $products->render(); ?>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection

@section('js')

    <script src="{{ asset ("/bower_components/AdminLTE/plugins/select2/select2.min.js") }}" type="text/javascript"></script>
    <script>
        function isForbiddenAjax(id)
        {
            var status;

            if($("#statusCheckBtn" + id).prop('checked'))
            {
                status = 0;
            }else{
                status = 1;
            }

            $.ajax({

                type : 'post',
                url : '/admin/flashsale/product/productstatus',
                data : { 'productId' : id, 'status' : status},
                dataType : 'json',
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },

                success : function(data){
                    if(data.code == 1){
                        $("#statusCheckBtn" + id).prop('checked', false)
                    }else if(data.code == 0){
                        $("#statusCheckBtn" + id).prop('checked', true)
                    }else if(data.code == 2){
                        $("#statusCheckBtn" + id).prop('checked', true);
                        alert("已经有活动计划添加了该商品,不能禁用该商品");
                    }else{
                        if($("#statusCheckBtn" + id).prop('checked')){
                            $("#statusCheckBtn" + id).prop('checked', true)
                        }else{
                            $("#statusCheckBtn" + id).prop('checked', false)
                        }
                    }
                },

                error : function(xhr, type){
                    alert('ajax error!')
                    $("#statusCheckBtn" + id).prop('checked', false)
                }

            });
        }

        function delProductConfigOnClickLintener(id)
        {
            $("#modal-content").text("你确定删除么?");
            $("#comfirmModal").modal('show');
            $("#confirSpan").empty();
            $("#confirSpan").append("<button class=\"btn btn-primary pull-left\" id=\"confirmBtn\" onclick=\"productComfirmAction("+ id +")\" data-dismiss=\"modal\">确定</button>")
        }

        function productComfirmAction(id)
        {
            location.href = '/admin/flashsale/product/deleteproduct/' + id;
        }



    </script>

    <script type="text/javascript">
        $(".js-example-basic-multiple").select2();
    </script>

    <script type="text/javascript">
        <?php $timestamp = time();?>
		$(function() {
            $('#file_upload').uploadify({
                'formData'     : {
                    'timestamp' : '<?php echo $timestamp;?>',
                    'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
                },
                'swf'      : '/bower_components/AdminLTE/plugins/uploadify/uploadify.swf',
                'uploader' : '/bower_components/AdminLTE/plugins/uploadify/uploadify.php',
                'fileSizeLimit':'2MB',
                'onUploadSuccess' : function(file, data, response) {
                    if(data == 0) {
                        alert('Invalid file type.');return false;
                    }else{
                        var oldval = $("#file_path").val();
                        $("#file_path").val(oldval+','+data);
                    }
                }
            });


        });
        function uploadi(id) {
            $('#edit_file_upload_'+id).uploadify({
                'formData'     : {
                    'timestamp' : '<?php echo $timestamp;?>',
                    'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
                },
                'swf'      : '/bower_components/AdminLTE/plugins/uploadify/uploadify.swf',
                'uploader' : '/bower_components/AdminLTE/plugins/uploadify/uploadify.php',
                'fileSizeLimit':'100KB',
                'onUploadSuccess' : function(file, data, response) {
                    if(data == 0) {
                        alert('Invalid file type.');return false;
                    }else{
                        var oldval = $("#edit_file_path_"+id).val();
                        $("#edit_file_path_"+id).val(oldval+','+data);
                    }
                }
            });

        }

    </script>

    <script>
        function check_create(){
            name = $("#cr_name").val();
            quantity = $("#cr_quantity").val();
            market_price = $("#cr_market_price").val();
            reference_price = $("#cr_reference_price").val();
            description_short = $("#cr_description_short").val();
            if(name.length == 0) {
                $("#tip_name").show();
                return false;
            }else{
                $("#tip_name").hide();
            }

            if(quantity.length == 0) {
                $("#tip_quantity").show();
                return false;
            }else {
                $("#tip_quantity").hide();
            }

            if(market_price.length == 0) {
                $("#tip_market_price").show();
                return false;
            }else {
                $("#tip_market_price").hide();
            }

            if(reference_price.length == 0) {
                $("#tip_reference_price").show();
                return false;
            }else {
                $("#tip_reference_price").hide();
            }

            if(description_short.length == 0) {
                $("#tip_description_short").show();
                return false;
            }else {
                $("#tip_description_short").hide();
            }
        }
        function check_update(id){
            name = $("#up_name_"+id).val();
            quantity = $("#up_quantity_"+id).val();
            market_price = $("#up_market_price_"+id).val();
            reference_price = $("#up_reference_price_"+id).val();
            description_short = $("#up_description_short_"+id).val();

            if(name.length == 0) {
                $("#tip_upname_"+id).show();
                return false;
            }else{
                $("#tip_upname_"+id).hide();
            }

            if(quantity.length == 0) {
                $("#tip_upquantity_"+id).show();
                return false;
            }else {
                $("#tip_upquantity_"+id).hide();
            }

            if(market_price.length == 0) {
                $("#tip_upmarket_price_"+id).show();
                return false;
            }else {
                $("#tip_upmarket_price_"+id).hide();
            }

            if(reference_price.length == 0) {
                $("#tip_upreference_price_"+id).show();
                return false;
            }else {
                $("#tip_upreference_price_"+id).hide();
            }

            if(description_short.length == 0) {
                $("#tip_updescription_short_"+id).show();
                return false;
            }else {
                $("#tip_updescription_short_"+id).hide();
            }
        }
    </script>

@endsection