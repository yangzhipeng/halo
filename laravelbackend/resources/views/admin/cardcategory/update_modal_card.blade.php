<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-3-9
 * Time: 上午11:53
 */
?>
<div class="modal fade" id="updateModal{{ $card->id }}" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>会员卡分类详情</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="" action="{{ URL::to('admin/cardcategory/updatecard'.'/'.$card->id) }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">


                            <div class="form-group">

                                <label for="medicineName">学校</label>
                                <select class="form-control" name="school" id="school_1">
                                    <option value="0">所有学校</option>
                                    @foreach($schools as $school)
                                        <option value ="{{ $school->bid }}"
                                        @if($card->school_id == $school->bid){{'selected'}}
                                        @endif>{{ $school->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="medicineName">标题</label>
                                <input class="form-control" type="text" name="name" id="name" value="{{ $card->name }}">
                            </div>
                            <div class="form-group">
                                <label for="medicineSubcategory">行业分类</label>
                                <select class="form-control" name="industry" id="upindustry_{{$card->id}}" onchange="updatesubindustry(this.value,{{$card->id}})">
                                    @foreach($industrys as $industry)
                                        <option value ="{{ $industry->id }}"
                                        @if($card->industryid == $industry->id){{'selected'}}
                                        @endif>{{ $industry->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="medicineCategory">详细分类</label>
                                <select class="form-control" name="subindustry" id="upsubindustry_{{$card->id}}">
                                    @foreach($allsubindustrys as $allsubindustry)
                                        @if($card->industryid == $allsubindustry->industryid)
                                            <option value ="{{ $allsubindustry->id }}"
                                            @if($card->subindustryid == $allsubindustry->id){{'selected'}}
                                            @endif>{{ $allsubindustry->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">外部链接</label>
                                <textarea class="form-control" type="text" rows="3" name="actionurl" id="actionurl">{{ $card->actionurl }}</textarea>
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



