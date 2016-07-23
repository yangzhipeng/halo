<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-21
 * Time: 下午3:08
 */
?>
<div class="modal fade" id="createModal" role="dialog" aria-hidden="">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h4>新增商品计划</h4>
   </div>
   <div class="modal-body">
    <div class="box box-primary">
     <div class="box-body">
      <form class="form" id="create_form" action="{{ URL::to('admin/flashsale/plan/create-plan') }}" name="create" onsubmit="return check_create()" method="post" enctype="multipart/form-data">
       <input type="hidden" name="_method" value="POST">
       <input type="hidden" name="_token" value="{{ csrf_token() }}">
       <div class="form-group">
        <label for="medicineName">计划标题</label> <span style="color:#ff0000;">*</span>
        <input class="form-control" type="text" name="title" id="cr_title" value="">
        <span id="tip_title" style="display:none;color: #ff0000; "> 请填写计划标题</span>
       </div>
       <div class="form-group">
        <label for="medicineName">学校</label> <span style="color:#ff0000;">*</span>
        <select class="form-control"  name="school" id="school">
         <option value="0" selected>所有学校</option>
         @foreach($schools as $school)
          <option value ="{{ $school->bid }}">{{ $school->name }}</option>
          <!--$school['id'] $school['xxmc'] -->
         @endforeach
        </select>
       </div>
       <div class="form-group"> <span style="color:#ff0000;">*</span>
        <label for="medicineCoposition">开始时间</label>
        <input class="form-control cr_starttime" type="text" name="starttime" id="datetimepicker_start" value="">
        <span id="tip_starttime" style="display:none;color: #ff0000; "> 请选择开始时间</span>
       </div>
       <div class="form-group"> <span style="color:#ff0000;">*</span>
        <label for="medicineCoposition">结束时间</label>
        <input class="form-control cr_endtime" type="text" name="endtime" id="datetimepicker_end" value="">
        <span id="tip_endtime" style="display:none;color: #ff0000; "> 请选择结束时间</span>
        <span id="tip_time" style="display:none;color: #ff0000; ">结束时间不能早于开始时间</span>
       </div>
       <div class="form-group"><span style="color:#ff0000;">*</span>
        <label for="medicineCoposition">计划描述</label>
        <textarea class="form-control" type="text" rows="3" name="description" id="cr_description"></textarea>
        <span id="tip_description" style="display:none;color: #ff0000; "> 请填写计划描述</span>
       </div>
       <div class="form-group">
        <label for="medicineCoposition">其他说明</label>
        <textarea class="form-control" type="text" rows="2" name="memo" id="memo"></textarea>
       </div>
       <div class="form-group">
        <label for="medicineCoposition">图标</label>
        <input class="form-control" type="file" name="file" id="file">
       </div>
       <input class="btn btn-primary" type="submit" id="subbtn" value="提交">
       <button class="btn btn-default pull-right"  data-dismiss="modal">取消</button>
      </form>
     </div>
    </div>
   </div>
  </div>
 </div>
</div>



