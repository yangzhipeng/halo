<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-20
 * Time: 下午4:02
 */
?>
<div class="modal fade" id="createModal" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>新增商品品牌</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="" action="{{ URL::to('admin/flashsale/brand/create-brand') }}" name="create" onsubmit="return check_create()" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="medicineName">名称</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control" type="text" name="name" id="create_name" value="">
                                <span id="tip_name" style="display:none;color: #ff0000; "> 请填写名称</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineSubcategory">生产商</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control" type="text" name="manufacture" id="create_manufacture" value="">
                                <span id="tip_manufacture" style="display:none;color: #ff0000; "> 请填写生产商</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">简介</label> <span style="color:#ff0000;">*</span>
                                <textarea class="form-control" type="text" rows="3" name="description" id="create_description"></textarea>
                                <span id="tip_description" style="display:none;color: #ff0000; "> 请填写简介</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">图标</label>
                                <input class="form-control" type="file" name="file" id="create_file">
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


