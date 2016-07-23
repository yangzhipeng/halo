<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-3-7
 * Time: 下午6:09
 */
?>
@extends('admin.layout.master')

@section('title', '会员卡')

@section('page_title', '全局会员卡')

@section('nav')
    <li>全局会员卡</li>
@endsection

@section('page_description', '会员卡设置')

@section('adv', 'active')

@section('content')
    <div class="row">
        <div class="col-xs-6">
            <form action="/admin/cardcategory/vipcard" method="get" class="">
                <div class="input-group">
                    @if(isset($query))
                        <input class="form-control" type="text" name="query" id="query" placeholder="学校" value="{{ $query }}">
                    @else
                        <input class="form-control" type="text" name="query" id="query" placeholder="学校">
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
                    <h3 class="box-title">会员卡分类</h3>
                </div>

                <div class="box-body">

                        <button class="btn btn-primary" id="subBtn" role="button" data-toggle="modal" data-target="#createModal">增加</button>
                        @include('admin.cardcategory.create_modal_vipcard')

                    <table class="table table-bordered table-hover" style="table-layout:fixed">
                        <thead>
                        <tr>
                            <th>学校</th>
                            <th>名称</th>
                            <th>外部链接</th>
                            <th>图片</th>
                            <th>行业分类</th>
                            <th>详细分类</th>
                            <th>是否禁用</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($cards) > 0)
                            @foreach($cards as $card)
                                <tr>
                                    <td>{{ $card->schoolname ?  $card->schoolname :"所有学校"}}</td>
                                    <td>{{ $card->name }}</td>
                                    <td style="WORD-WRAP: break-word" width="20">{{ $card->actionurl }}</td>
                                    <td><img src="{{ Config::get('uni.image_base_url').$card->iconurl }}" style="width: 100px;height: 100px"></td>
                                    <td>{{ $card->industryname }}</td>
                                    <td>{{ $card->subindustryname }}</td>
                                    @if($card->status == 1)
                                        <td><input id="statusCheckBtn{{ $card->id }}" type="checkbox" onchange="isForbiddenAjax({{ $card->id }})"></td>
                                    @else
                                        <td><input id="statusCheckBtn{{ $card->id }}" type="checkbox" onchange="isForbiddenAjax({{ $card->id }})" checked></td>
                                    @endif
                                    <td>
                                        <a href="#updateBtn{{ $card->id }}"><button name="updateBtn{{ $card->id }}" class="btn btn-primary btn-xs"role="button" data-toggle="modal" data-target="#updateModal{{ $card->id }}">修改</button></a>
                                        <a href="#delBtn{{ $card->id }}"><button name="delBtn{{ $card->id }}" class="btn btn-danger btn-xs" onclick="delAdvConfigOnClickLintener({{ $card->id }})">删除</button></a>
                                    </td>
                                @include('admin.cardcategory.update_modal_card')
                            @endforeach
                            @include('admin.layout.widgets.comfirm_modal')
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-4">
                            <span>共{{ $cards->total() }}条数据,共{{ $cards->lastPage() }}页,当前显示第{{ $cards->currentPage() }}页</span>
                        </div>
                        <div class="col-xs-8">
                            @if(isset($query))
                                <?php echo $cards->appends(['query' => $query])->render(); ?>
                            @else
                                <?php echo $cards->render(); ?>
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
                url : '/admin/cardcategory/cardstatus',
                data : { 'cardId' : id, 'status' : status},
                dataType : 'json',
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },

                success : function(data){
                    if(data.code == 1){
                        $("#statusCheckBtn" + id).prop('checked', false)
                    }else if(data.code == 0){
                        $("#statusCheckBtn" + id).prop('checked', true)
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

        function delAdvConfigOnClickLintener(id)
        {
            $("#modal-content").text("你确定删除么?");
            $("#comfirmModal").modal('show');
            $("#confirSpan").empty();
            $("#confirSpan").append("<button class=\"btn btn-primary pull-left\" id=\"confirmBtn\" onclick=\"advComfirmAction("+ id +")\" data-dismiss=\"modal\">确定</button>")
        }

        function advComfirmAction(id)
        {
            location.href = '/admin/cardcategory/deletecard/' + id;
        }
        //添加时调用
        function changesubindustry(id){
            $.ajax({
                type: "post",
                dataType:"json",
                url: "/admin/cardcategory/changecategory",
                data: { 'industryId' : id},
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){

                    $("#subindustry").empty();
                    var i;
                    for(i=0;i<data.length;i++)
                    {

                        $("#subindustry").append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");
                    }

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(XMLHttpRequest.status);
                    alert(XMLHttpRequest.readyState);
                    alert(textStatus);
                }
            });
        }
        //修改时调用
        function updatesubindustry(id,cardid){
            $.ajax({
                type: "post",
                dataType:"json",
                url: "/admin/cardcategory/changecategory",
                data: { 'industryId' : id},
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){

                    $("#upsubindustry_"+cardid).empty();
                    for(var i=0;i<data.length;i++)
                    {

                        $("#upsubindustry_"+cardid).append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");
                    }

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(XMLHttpRequest.status);
                    alert(XMLHttpRequest.readyState);
                    alert(textStatus);
                }
            });
        }
    </script>

@endsection