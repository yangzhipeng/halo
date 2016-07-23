@extends('admin.layout.master')

@section('title', '管理员信息修改')

@section('page_title', '管理员信息修改')

@section('nav')
    <li><a href="/admin/admin">管理员管理</a></li>
    @if($adminAccount->hasOneAdminInfo)
        <li class="active">{{ $adminAccount->hasOneAdminInfo->admin_name  }}</li>
    @else
        <li class="active">管理员信息修改</li>
    @endif

@endsection

@section('page_description', '管理员信息修改')

@section('admin_index', 'active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body">
                    <form class="form" action="{{ URL::to('admin/admin/update') }}" method="post">
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="adminAccount_id" value="{{ $adminAccount->id }}">
                        <div class="form-group">
                            <label for="name">管理员名称</label>
                            @if($adminAccount->hasOneAdminInfo)
                                <input class="form-control" type="text" name="name" id="name" value="{{ $adminAccount->hasOneAdminInfo->admin_name }}" required>
                            @else
                                <input class="form-control" type="text" name="name" id="name" required>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="oldPassword">管理员账号</label>
                            <input class="form-control" type="text" name="account"  id="account" value="{{ $adminAccount->account }}" required>
                        </div>
                        <div class="form-group">
                            <label for="newPassword">密码</label>
                            <input class="form-control" type="password" name="password"  id="password" placeholder="需要修改密码，直接输入新密码，否则不填">
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
