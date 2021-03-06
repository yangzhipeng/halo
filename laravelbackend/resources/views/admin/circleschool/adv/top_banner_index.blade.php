<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">广告</h3>
    </div>

    <div class="box-body">
        @if(!isset($query))
            <button class="btn btn-primary" id="subBtn" role="button" data-toggle="modal" data-target="#createModal">增加</button>
            @include('admin.circleschool.adv.create_modal')
        @endif
        <table class="table table-bordered table-hover" style="table-layout:fixed">
            <thead>
            <tr>
                <th>标题</th>
                <th>外部链接</th>
                <th>图片</th>
                <th>类别</th>
                <th>是否禁用</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @if(count($advs) > 0)
                @foreach($advs as $adv)
                    <tr>
                        <td>{{ $adv->title }}</td>
                        <td style="WORD-WRAP: break-word" width="20">{{ $adv->outerurl }}</td>
                        <td><img src="{{ Config::get('uni.image_base_url').$adv->imageurl }}" style="width: 100px;height: 100px"></td>
                        @if($adv->content_type == 1)
                            <td>外部广告</td>
                        @else
                            <td>内部广告</td>
                        @endif
                        @if($adv->status == 1)
                            <td><input id="statusCheckBtn{{ $adv->id }}" type="checkbox" onchange="isForbiddenAjax({{ $adv->id }})"></td>
                        @else
                            <td><input id="statusCheckBtn{{ $adv->id }}" type="checkbox" onchange="isForbiddenAjax({{ $adv->id }})" checked></td>
                        @endif
                        <td>
                            <a href="#updateBtn{{ $adv->id }}"><button name="updateBtn{{ $adv->id }}" class="btn btn-primary btn-xs"role="button" data-toggle="modal" data-target="#updateModal{{ $adv->id }}">修改</button></a>
                            <a href="#delBtn{{ $adv->id }}"><button name="delBtn{{ $adv->id }}" class="btn btn-danger btn-xs" onclick="delAdvConfigOnClickLintener({{ $adv->id }})">删除</button></a>
                        </td>
                    @include('admin.circleschool.adv.update_modal')
                @endforeach
                @include('admin.layout.widgets.comfirm_modal')
            @endif
            </tbody>
        </table>
    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-xs-4">
                <span>共{{ $advs->total() }}条数据,共{{ $advs->lastPage() }}页,当前显示第{{ $advs->currentPage() }}页</span>
            </div>
            <div class="col-xs-8">
                @if(isset($query))
                    <?php echo $advs->appends(['query' => $query])->render(); ?>
                @else
                    <?php echo $advs->render(); ?>
                @endif
            </div>
        </div>
    </div>
</div>

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
            url : '/admin/circleschool/adv/change-status',
            data : { 'advId' : id, 'status' : status},
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
        location.href = '/admin/circleschool/adv/delete/' + id;
    }

</script>