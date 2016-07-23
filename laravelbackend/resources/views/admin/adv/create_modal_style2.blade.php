<div class="modal fade" id="createModalStyle2" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>新增广告</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="" action="{{ URL::to('admin/adv/create-style2') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="content_type" value="3">

                            <div class="form-group">
                                <label for="medicineName">Style2 广告标题1</label>
                                <input class="form-control" type="text" name="title0" id="title0" value="">
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">Style2 广告外部链接1</label>
                                <textarea class="form-control" type="text" rows="3" name="outerurl0" id="outerurl0"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">Style2 广告图片1</label>
                                <input class="form-control" type="file" name="file0" id="file0">
                            </div>

                            <div class="form-group">
                                <label for="medicineName">Style2 广告标题2</label>
                                <input class="form-control" type="text" name="title1" id="title1" value="">
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">Style2 广告外部链接2</label>
                                <textarea class="form-control" type="text" rows="3" name="outerurl1" id="outerurl1"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">Style2 广告图片2</label>
                                <input class="form-control" type="file" name="file1" id="file1">
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
