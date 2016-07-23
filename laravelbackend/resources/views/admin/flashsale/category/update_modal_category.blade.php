<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-20
 * Time: 下午5:05
 */
?>
<div class="modal fade" id="updateModal{{ $category->id }}" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>商品类别详情</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="" action="{{ URL::to('admin/flashsale/category/updatecategory'.'/'.$category->id) }}" name="update" onsubmit="return check_update({{ $category->id }})" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">


                            <div class="form-group">
                                <label for="medicineName">名称</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control" type="text" name="name" id="up_name_{{ $category->id }}" value="{{ $category->name }}">
                                <span id="tip_upname_{{ $category->id }}" style="display:none;color: #ff0000; "> 请填写类别名称</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">简介</label> <span style="color:#ff0000;">*</span>
                                <textarea class="form-control" type="text" rows="3" name="description" id="up_description_{{ $category->id }}" >{{ $category->description }}</textarea>
                                <span id="tip_updescription_{{ $category->id }}" style="display:none;color: #ff0000; "> 请填写简介</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">图片</label>
                                <input class="form-control" type="file" name="file" id="file">
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



