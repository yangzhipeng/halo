<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-5-19
 * Time: 下午1:40
 */
?>
<div class="modal fade" id="createModal" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>新增任务</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="" action="{{ URL::to('admin/school/usertask/sendtask') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="medicineName">任务标题</label>
                                <input class="form-control" type="text" name="title" id="name" value="">
                            </div>
                            <div class="form-group">
                                <label for="medicineName">任务数量</label>
                                <input class="form-control" type="text" name="num" id="num" value="" >
                            </div>
                            <div class="form-group">
                                <label for="medicineName">分享次数</label>
                                <input class="form-control" type="text" name="share_num" id="share_num" value="" >
                                <span style="color: red;">该条件用于设定用户接受任务后要分享的次数</span>
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
