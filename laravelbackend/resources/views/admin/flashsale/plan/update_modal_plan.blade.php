<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-21
 * Time: 下午3:08
 */
?>
<div class="modal fade" id="updateModal{{ $plan->id }}" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>商品类别详情</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="" action="{{ URL::to('admin/flashsale/plan/updateplan'.'/'.$plan->id) }}" name="update" onsubmit="return check_update({{$plan->id }})" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="medicineName">计划标题</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control" type="text" name="title" id="up_title_{{$plan->id }}" value="{{ $plan->title }}">
                                <span id="tip_uptitle_{{$plan->id }}" style="display:none;color: #ff0000; "> 请填写计划标题</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineName">学校</label> <span style="color:#ff0000;">*</span>
                                <select class="form-control"  name="school" id="school">
                                    <option value="0">所有学校</option>
                                    @foreach($schools as $school)
                                        <option value ="{{ $school->bid }}"
                                            @if($plan->school_id == $school->bid){{'selected'}}
                                            @endif>{{ $school->name }}</option>
                                        <!--$school['id'] $school['xxmc'] -->
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style = " display:
                            @if($plan->status == 0) {{ 'none' }}
                            @else {{ 'block' }}
                            @endif">
                                <label for="medicineCoposition">开始时间</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control up_starttime_{{$plan->id }}" type="text" name="starttime" id="datetimepicker_upstart_{{ $plan->id }}" value="{{ date('Y-m-d H:i:s',$plan->starttime) }}" >
                                <span id="tip_upstarttime_{{$plan->id }}" style="display:none;color: #ff0000; "> 请选择开始时间</span>
                            </div>
                            <div class="form-group" style = " display:
                            @if($plan->status == 0) {{ 'none' }}
                            @else {{ 'block' }}
                            @endif">
                                <label for="medicineCoposition">结束时间</label> <span style="color:#ff0000;">*</span>
                                <input class="form-control up_endtime_{{$plan->id }}" type="text" name="endtime" id="datetimepicker_upend_{{  $plan->id  }}" value="{{ date('Y-m-d H:i:s',$plan->endtime) }}">
                                <span id="tip_upendtime_{{$plan->id }}" style="display:none;color: #ff0000; "> 请选择结束时间</span>
                                <span id="tip_uptime_{{$plan->id }}" style="display:none;color: #ff0000; "> 结束时间不能早于开始时间</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">计划描述</label> <span style="color:#ff0000;">*</span>
                                <textarea class="form-control" type="text" rows="3" name="description" id="up_description_{{$plan->id }}">{{ $plan->description }}</textarea>
                                <span id="tip_updescription_{{$plan->id }}" style="display:none;color: #ff0000; "> 请填写计划描述</span>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">其他说明</label>
                                <textarea class="form-control" type="text" rows="2" name="memo" id="memo">{{ $plan->memo }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">图片</label>
                                <input class="form-control" type="file" name="file" id="file">
                            </div>
                            <input class="btn btn-primary" type="submit" id="subbtn" value="修改">
                            <button class="btn btn-default pull-right"  data-dismiss="modal">取消</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



