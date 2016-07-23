<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">群发任务</h3>
    </div>

    <div class="box-body">
        @if(!isset($query))
            <button class="btn btn-primary" id="subBtn" role="button" data-toggle="modal" data-target="#createModal">增加</button>
            @include('admin.circleschool.task.create_modal')
        @endif
            <button class="btn btn-primary" id="subBtn" role="button" onclick="send()">发送</button>
            <table class="table table-bordered table-hover" style="table-layout:fixed">
            <thead>
            <tr>
                <th></th>
                <th>任务标题</th>
                <th>任务描述</th>
                <th>小秘密</th>
                <th>金额</th>
                <th>图片</th>
                <th>过期时间</th>
                <th>数量</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @if(count($tasks) > 0)
                @foreach($tasks as $task)
                    <tr>
                        <td><input type="checkbox" class="checkboxSend" value="{{ $task->category_id }}"></td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->privacy }}</td>
                        <td>{{ $task->decimal }}</td>
                        @if($task->image_url)
                            <td><img src="{{ $task->image_url[0] }}" style="width: 50px;height: 50px"></td>
                        @else
                            <td></td>
                        @endif
                            <td>{{ $task->expire }}</td>
                        <td>
                            <div class="btn-group">
                                <input type="hidden" id="sendNum{{ $task->category_id }}" value="0">
                                <button id="numBtn{{ $task->category_id }}" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    0
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" id="" name="" style="height: 100px;overflow: scroll">
                                    @for($i = 0; $i <= 50; $i++)
                                    <li onclick="numItembtn('{{ $task->category_id }}','{{ $i }}')"><a href="#">{{ $i }}</a></li>
                                    @endfor
                                </ul>
                            </div>
                        </td>
                        <td>
                            <button id="updateBtn" onclick="initTimePicker({{ $task->category_id }})" class="btn btn-warning btn-xs" role="button" data-toggle="modal" data-target="#updateModal{{ $task->category_id }}">修改</button>
                            {{--<a href="#updateBtn{{ $task->category_id }}"><button name="" class="btn btn-primary btn-xs"role="button" data-toggle="modal" data-target="">修改</button></a>--}}
                            <a href="#delBtn{{ $task->category_id }}"><button name="" class="btn btn-danger btn-xs" onclick="delTaskOnClickLintener({{ $task->category_id }})">删除</button></a>
                        </td>
                    @include('admin.circleschool.task.update_modal')
                @endforeach
                @include('admin.layout.widgets.comfirm_modal')
            @endif
            </tbody>
        </table>
    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-xs-4">
                <span>共{{ $tasks->total() }}条数据,共{{ $tasks->lastPage() }}页,当前显示第{{ $tasks->currentPage() }}页</span>
            </div>
            <div class="col-xs-8">
                @if(isset($query))
                    <?php echo $tasks->appends(['query' => $query])->render(); ?>
                @else
                    <?php echo $tasks->render(); ?>
                @endif
            </div>
        </div>
    </div>
</div>


<script>

    function numItembtn(index, value)
    {
        $("#sendNum" + index).prop('value', value);
        $("#numBtn" + index).text(value + ' ');
        $("#numBtn" + index).append("<span class='caret'></span>");
    }

    function initTimePicker(id)
    {
        $("#task_update_datetime" + id).datetimepicker({format: 'yyyy-mm-dd hh:ii'});
    }

    function send()
    {
        var checkBoxs = $(".checkboxSend:checked:checked");

        var tasks = [];
        checkBoxs.each(function(index){
            tasks[index] = new Object();
            var categoryId = $(this).prop('value');
            tasks[index].category_id = categoryId;
            tasks[index].send_num = $("#sendNum" + categoryId).prop('value');
        });
//        var temp_tasks = JSON.stringify(tasks);
//        alert(temp_tasks);
        sendAjax(tasks);
    }

    function sendAjax(jsonData)
        {
            $.ajax({

                type : 'post',
                url : '/admin/circleschool/task/send',
                data : { 'temp_tasks' : JSON.stringify(jsonData) },
                dataType : 'json',
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },

                success : function(data){
                    alert('成功发布任务' + data.num + '条！');
                    window.location.reload();
                },

                error : function(xhr, type){
                    alert('ajax error!')
                }

            });
        }

        function delTaskOnClickLintener(id)
        {
            $("#modal-content").text("你确定删除么?");
            $("#comfirmModal").modal('show');
            $("#confirSpan").empty();
            $("#confirSpan").append("<button class=\"btn btn-primary pull-left\" id=\"confirmBtn\" onclick=\"taskComfirmAction("+ id +")\" data-dismiss=\"modal\">确定</button>")
        }

        function taskComfirmAction(id)
        {
            location.href = '/admin/circleschool/task/delete/' + id;
        }

</script>