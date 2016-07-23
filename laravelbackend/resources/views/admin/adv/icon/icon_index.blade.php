@extends('admin.layout.master')

@section('title', '全局广告')

@section('page_title', '全局Icon设置')

@section('nav')
    <li>全局广告</li>
@endsection

@section('page_description', 'Icon设置')

@section('adv', 'active')

@section('content')

    <div class="box box-primary">
    <div class="box-body">
        @if(!isset($query))
            <button class="btn btn-primary" id="subBtn" role="button" data-toggle="modal" data-target="#createModal">增加</button>
            @include('admin.adv.icon.create_modal_icon')
        @endif
        @include('admin.layout.widgets.comfirm_modal')
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>功能名称</th>
                <th>图片地址</th>
                <th>操作类型</th>
                <th>排序(倒序)</th>
                <th>功能类型</th>
                <th>是否禁用</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @if(count($modules) > 0)
                @foreach($modules as $module)
                    <tr>
                        <td>{{ $module->name }}</td>
                        <td>{{ $module->iconurl }}</td>
                        @if($module->actiontype == 0)
                            <td>HTML5</td>
                        @elseif($module->actiontype == 1)
                            <td>原生</td>
                        @elseif($module->actiontype == 2)
                            <td>第三方应用</td>
                        @elseif($module->actiontype == 3)
                            <td>特殊处理</td>
                        @else
                            <td></td>
                        @endif
                        <td>{{ $module->weight }}</td>
                        @if($module->belongsToModuleType)
                            <td>{{ $module->belongsToModuleType->name }}</td>
                        @else
                            <td>更多</td>
                        @endif
                        @if($module->status == 1)
                            <td><input id="forbiddenCheck{{ $module->id }}" type="checkbox" onchange="isForbiddenAjax({{ $module->id }})"></td>
                        @else
                            <td><input id="forbiddenCheck{{ $module->id }}" type="checkbox" onchange="isForbiddenAjax({{ $module->id }})" checked></td>

                        @endif
                        <td>
                            <a href="#"><button class="btn btn-primary btn-xs" role="button" data-toggle="modal" data-target="#updateModal{{ $module->id }}">详情</button></a>
                            @include('admin.adv.icon.update_modal_icon')
                            <a href="#"><button class="btn btn-danger btn-xs" onclick="suIconConfigOnClickLintener({{ $module->id }})">删除</button></a>
                        </td>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-xs-4">
                <span>共{{ $modules->total() }}条数据,共{{ $modules->lastPage() }}页,当前显示第{{ $modules->currentPage() }}页</span>
            </div>
            <div class="col-xs-8">
                @if(isset($query))
                    <?php echo $modules->appends(['query' => $query])->render(); ?>
                @else
                    <?php echo $modules->render(); ?>
                @endif
            </div>
        </div>
    </div>

</div>

<script>

    function isForbiddenAjax(id)
    {
        var isForbidden;

        if($("#forbiddenCheck" + id).prop('checked'))
        {
            isForbidden = 0;
        }else{
            isForbidden = 1;
        }

        $.ajax({

            type : 'post',
            url : '/admin/adv/icon/changestatus',
            data : { 'moduleId' : id, 'isForbidden' : isForbidden},
            dataType : 'json',
            headers : {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },

            success : function(data){
                if(data.code == 1){
                    $("#forbiddenCheck" + id).prop('checked', false)
                }else if(data.code == 0){
                    $("#forbiddenCheck" + id).prop('checked', true)
                }else{
                    if($("#forbiddenCheck" + id).prop('checked')){
                        $("#forbiddenCheck" + id).prop('checked', true)
                    }else{
                        $("#forbiddenCheck" + id).prop('checked', false)
                    }
                }
            },

            error : function(xhr, type){
                alert('ajax error!')
                $("#forbiddenCheck" + id).prop('checked', false)
            }

        });
    }

    function changeActionType(typeId)
    {

        var index = arguments[1] ? arguments[1] : '';

        var text = '';
        switch (parseInt(typeId)){
            case 0 :
                text = 'HTML5';
                break;
            case 1 :
                text = '原生';
                break;
            case 2 :
                text = '第三方应用';
                break;
            case 3 :
                text = '特殊处理';
                break;
            default :
                text = '';
        }
        $("#actionTypeBtn" + index).text(text + ' ');
        $("#actionTypeBtn" + index).append("<span class='caret'></span>");
        $("#actiontype" + index).prop('value', parseInt(typeId));
    }

    function changeWeight(weight)
    {
        var index = arguments[1] ? arguments[1] : '';
        $("#WeightBtn" + index).text(weight + ' ');
        $("#WeightBtn" + index).append("<span class='caret'></span>");
        $("#weight" + index).prop('value', weight);
    }

    function changeType(id)
    {
        var index = arguments[1] ? arguments[1] : '';
        $("#typeBtn" + index).text($("#type" + id + index).text() + ' ');
        $("#typeBtn" + index).append("<span class='caret'></span>");
        $("#mtype" + index).prop('value', id);
    }

    function suIconConfigOnClickLintener(id)
    {
        //alert('0000');
        $("#modal-content").text("你确定删除么?");
        $("#comfirmModal").modal('show');
        $("#confirSpan").empty();
        $("#confirSpan").append("<button class=\"btn btn-primary pull-left\" id=\"confirmBtn\" onclick=\"iconComfirmAction("+ id +")\" data-dismiss=\"modal\">确定</button>")
    }


    function iconComfirmAction(id)
    {
        location.href = '/admin/adv/icon/delete/' + id;
    }

</script>

@endsection