@extends('admin.layout.master')

@section('title', '个人信息修改')

@section('page_title', '个人信息修改')

@section('nav')
    <li class="active">个人信息修改</li>
@endsection

@section('page_description', '个人信息修改')

@section('dashboard', 'active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body">
                    <form class="form" action="{{ URL::to('admin/admin/admininfo/update') }}" method="post">
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="name">管理员名称</label>
                            @if($adminAccount->hasOneAdminInfo)
                                <input class="form-control" type="text" name="name" id="name" value="{{ $adminAccount->hasOneAdminInfo->admin_name }}" required>
                            @else
                                <input class="form-control" type="text" name="name" id="name" required>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="oldPassword">旧密码</label>
                            <input class="form-control" type="password" name="oldPassword"  id="oldPassword">
                        </div>
                        <div class="form-group">
                            <label for="newPassword">新密码</label>
                            <input class="form-control" type="password" name="newPassword"  id="newPassword">
                        </div>
                        <input  type="submit" class="btn btn-primary" id="subbtn"  value="提交">
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

@endsection

@section('js')

@endsection
