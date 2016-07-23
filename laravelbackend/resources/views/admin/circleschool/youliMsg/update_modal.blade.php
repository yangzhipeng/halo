<div class="modal fade" id="updateModal{{ $msg->mid }}" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>短信详情</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="" action="{{ URL::to('admin/circleschool/youliMsg/update'.'/'.$msg->schoolid) }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            
                            <div class="form-group">
                                <label for="medicineCoposition">短信内容</label>
                                <textarea class="form-control" type="text" rows="3" name="contents" >{{ $msg->contents }}</textarea>
                            </div>
                
                            <input class="btn btn-primary" type="submit" id="subbtn" value="修改">
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
