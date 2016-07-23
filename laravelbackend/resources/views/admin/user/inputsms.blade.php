@extends('admin.layout.master')


@section('title', '用户管理')

@section('nav')
    <li>消息推送</li>
@endsection


@section('page_title', '用户管理')

@section('page_description', '用户管理')

@section('user', 'active')

@section('user_sms', 'active')

@section('content')

    <div class="box-header">
        <i class="fa fa-envelope"></i>
        <h3 class="box-title">推送SMS</h3>

    </div>
    <div class="box-body">
        <form action="{{ URL::to('admin/user/pushsms') }}" method="post" i>
            <input type="hidden" name="schoolid" id="schoolid" value="0">
            <input type="hidden" name="lastlogin" id="lastlogin" value="0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label>信息接受者选项</label>
                <select id="sel_school" class="form-control select2" style="width: 100%;" onchange="selectSchool()">
                    <option selected="selected" value="0">广播所有学校</option>
                </select>

                <label>信息接受者选项</label>
                <select id="sel_login" class="form-control select2" style="width: 100%;" onchange="selectLoginFreq()">
                    <option selected="selected" value="0">1个月内登陆</option>
                    <option selected="selected" value="1">1个月－3个月内没登陆</option>
                    <option selected="selected" value="2">3个月－6个月内没登陆</option>
                    <option selected="selected" value="3">6个月以上没登陆</option>
                </select>
            </div><!-- /.form-group -->

            <div>
                <textarea name="msg" class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
            </div>

            <input class="pull-left btn btn-default" type="submit" id="subbtn" value="发送">

        </form>
    </div>


@endsection

@section('js')
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/select2/select2.full.min.js") }}"></script>

    <script>

        @if(count($schools) > 0)

            @foreach($schools as $school)

                @if($school->isforbidded == 0)
                      $("#sel_school").append("<option value='{{ $school->bid }}'>{{ $school->name }}</option>");
                @endif

            @endforeach

        @endif

        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();

        });

        function selectSchool(){
            $("#schoolid").val($("#sel_school").val());
        }

        function selectLoginFreq(){
            $("#lastlogin").val($("#sel_login").val());
        }


    </script>


@endsection