<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-20
 * Time: 下午4:01
 */
?>
@extends('admin.layout.master')

@section('title', '商品品牌')

@section('page_title', '秒杀商品')

@section('nav')
    <li>秒杀商品</li>
@endsection

@section('page_description', '商品品牌')

@section('flashsale', 'active')

@section('content')
    <div class="row">
        <div class="col-xs-6">
            <form action="/admin/flashsale/brand/brandindex" method="get" class="">
                <div class="input-group">
                    @if(isset($query))
                        <input class="form-control" type="text" name="query" id="query" placeholder="品牌名称" value="{{ $query }}">
                    @else
                        <input class="form-control" type="text" name="query" id="query" placeholder="品牌名称">
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
                    <h3 class="box-title">商品品牌列表</h3>
                </div>

                <div class="box-body">

                    <button class="btn btn-primary" id="subBtn" role="button" data-toggle="modal" data-target="#createModal">增加</button>
                    @include('admin.flashsale.brand.create_modal_brand')

                    <table class="table table-bordered table-hover" style="table-layout:fixed">
                        <thead>
                        <tr>
                            <th>名称</th>
                            <th>生产商</th>
                            <th>简介</th>
                            <th>图标</th>
                            <th>是否可用</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($brands) > 0)
                            @foreach($brands as $brand)
                                <tr>
                                    <td>{{ $brand->name }}</td>
                                    <td>{{ $brand->manufacture }}</td>
                                    <td>{{ $brand->description }}</td>
                                    <td><img src="{{ Config::get('uni.image_base_url').$brand->icon }}" style="width: 100px;height: 100px"></td>
                                    @if($brand->status == 1)
                                        <td><input id="statusCheckBtn{{ $brand->id }}" type="checkbox" onchange="isForbiddenAjax({{ $brand->id }})"></td>
                                    @else
                                        <td><input id="statusCheckBtn{{ $brand->id }}" type="checkbox" onchange="isForbiddenAjax({{ $brand->id }})" checked></td>
                                    @endif
                                    <td>
                                        <a href="#updateBtn{{ $brand->id }}"><button name="updateBtn{{ $brand->id }}" class="btn btn-primary btn-xs"role="button" data-toggle="modal" data-target="#updateModal{{ $brand->id }}">修改</button></a>
                                        <a href="#delBtn{{ $brand->id }}"><button name="delBtn{{ $brand->id }}" class="btn btn-danger btn-xs" onclick="delBrandConfigOnClickLintener({{ $brand->id }})">删除</button></a>
                                    </td>
                                @include('admin.flashsale.brand.update_modal_brand')
                            @endforeach
                            @include('admin.layout.widgets.comfirm_modal')
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-4">
                            <span>共{{ $brands->total() }}条数据,共{{ $brands->lastPage() }}页,当前显示第{{ $brands->currentPage() }}页</span>
                        </div>
                        <div class="col-xs-8">
                            @if(isset($query))
                                <?php echo $brands->appends(['query' => $query])->render(); ?>
                            @else
                                <?php echo $brands->render(); ?>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection

@section('js')

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
                url : '/admin/flashsale/brand/brandstatus',
                data : { 'brandId' : id, 'status' : status},
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
                        alert("该商品品牌下有所属商品,不能禁用该商品品牌");
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

        function delBrandConfigOnClickLintener(id)
        {
            $("#modal-content").text("你确定删除么?");
            $("#comfirmModal").modal('show');
            $("#confirSpan").empty();
            $("#confirSpan").append("<button class=\"btn btn-primary pull-left\" id=\"confirmBtn\" onclick=\"brandComfirmAction("+ id +")\" data-dismiss=\"modal\">确定</button>")
        }

        function brandComfirmAction(id)
        {
            location.href = '/admin/flashsale/brand/deletebrand/' + id;
        }


    </script>
    <script>
        function check_create(){
            name = $("#create_name").val();
            manufacture = $("#create_manufacture").val();
            description = $("#create_description").val();
            if(name.length == 0) {
                $("#tip_name").show();
                return false;
            }else{
                $("#tip_name").hide();
            }
            if(manufacture.length == 0) {
                $("#tip_manufacture").show();
                return false;
            }else {
                $("#tip_manufacture").hide();
            }
            if(description.length == 0) {
                $("#tip_description").show();
                return false;
            }else {
                $("#tip_description").hide();
            }
        }
        function check_update(id){
            name = $("#up_name_"+id).val();
            manufacture = $("#up_manufacture_"+id).val();
            description = $("#up_description_"+id).val();
            if(name.length == 0) {
                $("#tip_upname_"+id).show();
                return false;
            }else{
                $("#tip_upname_"+id).hide();
            }
            if(manufacture.length == 0) {
                $("#tip_upmanufacture_"+id).show();
                return false;
            }else {
                $("#tip_upmanufacture_"+id).hide();
            }
            if(description.length == 0) {
                $("#tip_updescription_"+id).show();
                return false;
            }else {
                $("#tip_updescription_"+id).hide();
            }
        }
    </script>

@endsection