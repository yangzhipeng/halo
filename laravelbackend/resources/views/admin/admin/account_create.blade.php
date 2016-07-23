@extends('admin.layout.master')

@section('title', '新增管理员帐号')

@section('page_title', '新增管理员帐号')

@section('nav')
    <li><a href="/admin/admin">管理员管理</a></li>
    <li class="active">新增管理员帐号</li>
@endsection

@section('page_description', '新增管理员帐号')

@section('admin_index', 'active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body">
                    <form class="form" action="{{ URL::to('admin/admin/create') }}" method="post">
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="name">管理员名称</label>
                            <input class="form-control" type="text" name="name" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="name">管理员帐号</label>
                            <input class="form-control" type="text" name="account" id="account" required>
                        </div>
                        <div class="form-group">
                            <label for="oldPassword">密码</label>
                            <input class="form-control" type="password" name="password"  id="password" required>
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
