@extends('admin.layout.master')

@section('title', '用户管理')

@section('nav')
    <li><a href="#">用户管理</a></li>
    <li class="active">用户日志</li>
@endsection

@section('page_title', '用户日志')

@section('page_description', $user->realname)

@section('user_admin', 'active')

@section('content')

    <div class="row" style="margin-top: 20px">

        <div class="col-xs-12">
            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">{{ $user->realname }}的日志</h3>
                </div>

                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>操作类型</th>
                            <th>备注</th>
                            <th>创建时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($logs) > 0)
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log->type }}</td>
                                    <td>{{ $log->memo }}</td>
                                    <td>{{ date('Y-m-d H:i:s', $log->creationtime) }}</td>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-4">
                            <span>共{{ $logs->total() }}条数据,共{{ $logs->lastPage() }}页,当前显示第{{ $logs->currentPage() }}页</span>
                        </div>
                        <div class="col-xs-8">
                            @if(isset($query))
                                <?php echo $logs->appends(['query' => $query])->render(); ?>
                            @else
                                <?php echo $logs->render(); ?>
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