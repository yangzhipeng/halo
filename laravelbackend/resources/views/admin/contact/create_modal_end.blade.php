<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-7
 * Time: 下午5:32
 */
?>
<div class="modal fade" id="endModal" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>注意</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="" action="{{ URL::to('/admin/complaint/closeP2PComplain') }}" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                确定要结束该任务?
                            </div>
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="taskid" value="{{$complaints[0]->task_id}}">
                            <input class="btn btn-primary" type="submit" id="subbtn" value="确定">
                            <button class="btn btn-default pull-right"  data-dismiss="modal">取消</button>
                        </form>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
</div>


