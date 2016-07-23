<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-3-7
 * Time: 下午6:17
 */
?>
<div class="modal fade" id="createModal" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>新增会员卡分类</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="" action="{{ URL::to('admin/cardcategory/create-card') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="medicineName">学校</label>
                                <select class="form-control" name="school" id="school">
                                    <option value ="0" selected>所有学校</option>
                                    @foreach($schools as $school)
                                        <option value ="{{ $school->bid }}">{{ $school->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="medicineName">标题</label>
                                <input class="form-control" type="text" name="name" id="name" value="">
                            </div>
                            <div class="form-group">
                                <label for="medicineSubcategory">行业分类</label>
                                <select class="form-control" name="industry" id="industry" onchange="changesubindustry(this.value)">
                                    @foreach($industrys as $industry)
                                        <option value ="{{ $industry->id }}">{{ $industry->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="medicineCategory">详细分类</label>
                                <select class="form-control" name="subindustry" id="subindustry">
                                    @foreach($subindustrys as $subindustry)
                                        <option value ="{{ $subindustry->id }}">{{ $subindustry->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">外部链接</label>
                                <textarea class="form-control" type="text" rows="3" name="actionurl" id="actionurl"></textarea>
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


