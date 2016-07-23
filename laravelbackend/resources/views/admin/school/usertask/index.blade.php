<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-20
 * Time: 下午5:04
 */
?>
@extends('admin.layout.master')

@section('title', '任务管理')

@section('page_title', '任务管理')

@section('nav')
    <li>任务管理</li>
@endsection

@section('page_description', '任务管理')

@section('content')
    <div class="row">
        <div class="col-xs-6">
            <form action="/admin/flashsale/category/categoryindex" method="get" class="">
                <div class="input-group">

                </div>
            </form>
        </div>
    </div>
    <div class="row" style="margin-top: 20px">

        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">任务管理</h3>
                </div>

                <div class="box-body">

                    <button class="btn btn-primary" id="subBtn" role="button" data-toggle="modal" data-target="#createModal">增加</button>
                    @include('admin.school.usertask.create_modal')

                    <table class="table table-bordered table-hover" style="table-layout:fixed">
                        <thead>
                        <tr>
                            <th>任务标题</th>
                            <th>任务数量</th>
                            <th>分享次数</th>
                            <th>发布</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($taskarr) > 0)
                            @foreach($taskarr as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->num }}</td>
                                    <td>{{ $task->share_num }}</td>
                                    @if($task->status == 0)
                                        <td><input id="statusCheckBtn{{ $task->id }}" type="checkbox" onchange="isForbiddenAjax({{ $task->id }})"></td>
                                    @else
                                        <td><input id="statusCheckBtn{{ $task->id }}" type="checkbox" onchange="isForbiddenAjax({{ $task->id }})" checked></td>
                                    @endif
                                    <td>
                                        <a href="#delBtn{{ $task->id }}"><button name="delBtn{{ $task->id }}" class="btn btn-danger btn-xs" onclick="delTaskConfigOnClickLintener({{ $task->id }})">删除</button></a>
                                    </td>
                            @endforeach
                            @include('admin.layout.widgets.comfirm_modal')
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-4">
                            <span>共1条数据,共1页,当前显示第1页</span>
                        </div>
                        <div class="col-xs-8">

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
                status = 1;
            }else{
                status = 0;
            }

            $.ajax({

                type : 'post',
                url : '/admin/school/usertask/postStatus',
                data : { 'taskid' : id, 'status' : status},
                dataType : 'json',
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },

                success : function(data){
                    if(data.code == 1){
                        $("#statusCheckBtn" + id).prop('checked', true)
                    }else if(data.code == 0){
                        $("#statusCheckBtn" + id).prop('checked', true)
                    }else if(data.code == 2){
                        $("#statusCheckBtn" + id).prop('checked', false)
                        alert('在这之前您已经发布过任务，如果想要发布新任务，请删除之前发布的任务');
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

        function delTaskConfigOnClickLintener(id)
        {
            $("#modal-content").text("你确定删除么?");
            $("#comfirmModal").modal('show');
            $("#confirSpan").empty();
            $("#confirSpan").append("<button class=\"btn btn-primary pull-left\" id=\"confirmBtn\" onclick=\"taskComfirmAction("+ id +")\" data-dismiss=\"modal\">确定</button>")
        }

        function taskComfirmAction(id)
        {
            location.href = '/admin/school/usertask/deletetask/' + id;
        }


    </script>

@endsection