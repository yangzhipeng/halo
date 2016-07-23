@extends('admin.layout.master')

@section('title', '用户管理')

@section('nav')
    <li>用户管理</li>
@endsection


@section('page_title', '用户管理')

@section('page_description', '用户管理')

@section('user', 'active')

@section('user_index', 'active')

@section('content')

    <div class="row">
        <div class="col-xs-6">
            <form action="/admin/user" method="get" class="">
                {{--<input type="hidden" name="_method" value="POST">--}}
                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                <div class="input-group">
                    @if(isset($query))
                        <input class="form-control" type="text" name="query" id="query" placeholder="名字" value="{{ $query }}">
                    @else
                        <input class="form-control" type="text" name="query" id="query" placeholder="名字">
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
                    <h3 class="box-title">用户数据</h3>
                </div>

                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>名字</th>
                            <th>电话</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($users) > 0)
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->realname }}</td>
                                    <td>{{ $user->mobile }}</td>
                                    <td>{{ date('Y-m-d H:i:s', $user->creationtime) }}</td>
                                    <td>
                                        <a href="{{ URL::to('admin/user/log').'/'.$user->cid }}"><button class="btn btn-primary btn-xs">查看日志</button></a>
                                    </td>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-4">
                            <span>共{{ $users->total() }}条数据,共{{ $users->lastPage() }}页,当前显示第{{ $users->currentPage() }}页</span>
                        </div>
                        <div class="col-xs-8">
                            @if(isset($query))
                                <?php echo $users->appends(['query' => $query])->render(); ?>
                            @else
                                <?php echo $users->render(); ?>
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