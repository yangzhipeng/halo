<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">物流短信</h3>
    </div>

    <div class="box-body">
        @if(!isset($query))
            @if($msg == null)
            <button class="btn btn-primary" id="subBtn" role="button" data-toggle="modal" data-target="#createModal">增加</button>
            @include('admin.school.youliMsg.create_modal')
            @endif
        @endif
        <table class="table table-bordered table-hover" style="table-layout:fixed">
            <thead>
            <tr>
                <th>信息内容</th>
                <th>是否禁用</th>
                <th>短信操作</th>
            </tr>
            </thead>
            <tbody>
            @if(count($msg) > 0)
               <td>{{ $msg->contents }}</td>
                @if($msg->isValid == 1)
                            <td><input id="statusCheckBtn{{ $msg->mid }}" type="checkbox" onchange="isForbiddenAjax({{ $msg->mid }})"></td>
                        @else
                            <td><input id="statusCheckBtn{{ $msg->mid }}" type="checkbox" onchange="isForbiddenAjax({{ $msg->mid }})" checked></td>
                @endif
               <td>
                 <a href="#updateBtn{{ $msg->mid }}"><button name="updateBtn{{ $msg->mid }}" class="btn btn-primary btn-xs"role="button" data-toggle="modal" data-target="#updateModal{{ $msg->mid }}">更新信息</button></a>
                 <a href="#delBtn{{ $msg->mid }}"><button name="delBtn{{ $msg->mid }}" class="btn btn-danger btn-xs" onclick="delmsgConfigOnClickLintener({{ $msg->mid }})">删除信息</button></a>
               </td>
                @include('admin.school.youliMsg.update_modal')
                @include('admin.layout.widgets.comfirm_modal')
            @endif
            </tbody>
        </table>
    </div>
</div>
<script>

    function isForbiddenAjax(id)
    {
        var isValid;

        if($("#statusCheckBtn" + id).prop('checked'))
        {
            isValid = 0;
        }else{
            isValid = 1;
        }

        $.ajax({

            type : 'post',
            url : '/admin/school/youliMsg/change-usestatus',
            data : { 'mid' : id, 'isValid' : isValid},
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

    function delmsgConfigOnClickLintener(mid)
    {
        $("#modal-content").text("你确定删除么?");
        $("#comfirmModal").modal('show');
        $("#confirSpan").empty();
        $("#confirSpan").append("<button class=\"btn btn-primary pull-left\" mid=\"confirmBtn\" onclick=\"msgComfirmAction("+ mid +")\" data-dismiss=\"modal\">确定</button>")
    }

    function msgComfirmAction(mid)
    {
        location.href = '/admin/school/youliMsg/delete/' + mid;
    }

</script>