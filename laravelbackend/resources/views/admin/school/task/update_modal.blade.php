<div class="modal fade" id="updateModal{{ $task->category_id }}" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>修改群发任务</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="" action="{{ URL::to('admin/school/task/update/'.$task->category_id) }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="medicineName">任务标题</label>
                                <input class="form-control" type="text" name="title" id="name" value="{{ $task->title }}">
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">描述</label>
                                <textarea class="form-control" type="text" rows="2" name="description" id="description">{{ $task->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">小秘密</label>
                                <textarea class="form-control" type="text" rows="2" name="privacy" id="privacy">{{ $task->privacy }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="medicineName">金额</label>
                                <input class="form-control" type="text" rows="2" name="decimal" id="decimal" value="{{ $task->decimal }}">
                            </div>
                            <div class="form-group">
                                <label for="expire">过期时间</label>
                                <input size="16" type="text" value="{{ $task->expire }}" readonly class="form-control" id="task_update_datetime{{ $task->category_id }}" name="expire">
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">图片</label>
                                <input class="form-control" type="file" name="file" id="file">
                            </div>
                            <input class="btn btn-primary" type="submit" id="subbtn" value="提交">
                            <button class="btn btn-default pull-right"  data-dismiss="modal">取消</button>
                        </form>
                    </div><!-- /.box-body -->
                    <!-- Loading (remove the following to stop the loading)-->
                    {{--<div class="overlay">--}}
                    {{--<i class="fa fa-refresh fa-spin"></i>--}}
                    {{--</div>--}}
                    <!-- end loading -->
                </div>
            </div>
        </div>
    </div>
</div>
