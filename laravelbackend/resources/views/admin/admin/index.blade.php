@extends('admin.layout.master')

@section('title', '管理员管理')

@section('page_title', '管理员管理')

@section('nav')
    <li>管理员管理</li>
@endsection

@section('page_description', '管理员管理')

@section('admin_index', 'active')

@section('content')

    <div class="row">
        <div class="col-xs-6">
            <form action="/admin/admin" method="get" class="">
                {{--<input type="hidden" name="_method" value="POST">--}}
                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                <div class="input-group">
                    @if(isset($query))
                        <input class="form-control" type="text" name="query" id="query" placeholder="账号" value="{{ $query }}">
                    @else
                        <input class="form-control" type="text" name="query" id="query" placeholder="账号">
                    @endif
                    <span class="input-group-btn">
                        <button type='submit' name='search' id='search-btn' class="btn btn-primary">查询</button>
                    </span>
                </div>
            </form>
        </div>
    </div>

    <div class="row" style="margin-top: 20px">

        <div class="col-xs-12">
            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">管理员列表</h3>
                </div>

                <div class="box-body">
                    @if(!isset($query))
                        <a href="/admin/admin/create"><button class="btn btn-primary" role="button">增加</button></a>
                    @endif
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>账号</th>
                            <th>管理员名称</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($adminAccounts) > 0)
                            @foreach($adminAccounts as $adminAccount)
                                <tr>
                                    <td>{{ $adminAccount->account }}</td>
                                    @if($adminAccount->hasOneAdminInfo)
                                        <td>{{ $adminAccount->hasOneAdminInfo->admin_name }}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if($adminAccount->status == 0)
                                        <td>启用</td>
                                    @else
                                        <td>禁用</td>
                                    @endif
                                    <td>
                                        @if($adminAccount->status == 0)
                                            <a href="{{ URL::to('admin/admin/ban/'.$adminAccount->id) }}"><button class="btn btn-danger btn-xs">禁用</button></a>
                                        @else
                                            <a href="{{ URL::to('admin/admin/ban/'.$adminAccount->id) }}"><button class="btn btn-info btn-xs">启用</button></a>
                                        @endif
                                        <a href="{{ URL::to('admin/admin/update/'.$adminAccount->id) }}"><button class="btn btn-info btn-xs">修改</button></a>
                                    </td>
                                </tr>

                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-4">
                            <span>共{{ $adminAccounts->total() }}条数据,共{{ $adminAccounts->lastPage() }}页,当前显示第{{ $adminAccounts->currentPage() }}页</span>
                        </div>
                        <div class="col-xs-8">
                            @if(isset($query))
                                <?php echo $adminAccounts->appends(['query' => $query])->render(); ?>
                            @else
                                <?php echo $adminAccounts->render(); ?>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('js')

@endsection