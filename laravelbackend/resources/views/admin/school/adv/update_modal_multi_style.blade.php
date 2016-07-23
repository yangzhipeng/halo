<div class="modal fade" id="updateModal{{ $adv_group[$i]->id }}" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>广告详情</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="" action="{{ URL::to('admin/adv/update'.'/'.$adv_group[$i]->id) }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="medicineName">标题</label>
                                <input class="form-control" type="text" name="title" id="name" value="{{ $adv_group[$i]->title }}">
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">外部链接</label>
                                <textarea class="form-control" type="text" rows="3" name="outerurl" id="outerurl">{{ $adv_group[$i]->outerurl }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">图片</label>
                                <input class="form-control" type="file" name="file" id="file">
                            </div>
                            @if($adv_group[$i]->content_type != 3)
                            @endif
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
