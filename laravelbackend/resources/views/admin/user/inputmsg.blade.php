@extends('admin.layout.master')


@section('title', '用户管理')

@section('nav')
    <li>消息推送</li>
@endsection


@section('page_title', '用户管理')

@section('page_description', '用户管理')

@section('user', 'active')

@section('user_push', 'active')

@section('content')

    <div class="box-header">
        <i class="fa fa-envelope"></i>
        <h3 class="box-title">推送信息</h3>

    </div>
    <div class="box-body">
        <form action="{{ URL::to('admin/user/pushmsg') }}" method="post" i>
            <input type="hidden" name="schoolid" id="schoolid" value="0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label>信息接受者选项</label>
                <select id="sel_school" class="form-control select2" style="width: 100%;" onchange="selectSchool()">
                    <option selected="selected" value="0">广播所有人</option>
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


    </script>


@endsection