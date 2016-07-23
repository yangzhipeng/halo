@extends('admin.layout.master')

@section('title', '投诉与建议')

@section('nav')
    <li>用户管理</li>
@endsection


@section('page_title', '投诉与建议')

@section('page_description', '投诉与建议')


@section('contact_complaint', 'active')

@section('content')

    <div class="row" style="margin-top: 20px">

        <div class="col-xs-12">
            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">投诉与建议</h3>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-info">状态</button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ URL::to('admin/complaint/p2pcomplaintsel').'/0' }}">未处理</a></li>
                        <li><a href="{{ URL::to('admin/complaint/p2pcomplaintsel').'/1' }}">处理中</a></li>
                        <li><a href="{{ URL::to('admin/complaint/p2pcomplaintsel').'/2' }}">完成</a></li>
                    </ul>
                </div>

                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>投诉人名字</th>
                            <th>投诉人电话</th>
                            <th>投诉内容</th>
                            <th>任务描述</th>
                            <th>投诉时间</th>

                        </tr>
                        </thead>
                        <tbody>
                        @if(count($complaints) > 0)
                            @foreach($complaints as $complaint)
                                <tr>
                                    @if($complaint->user != NULL) <td>{{ $complaint->user->realname }}</td> @else <td></td> @endif
                                    @if($complaint->user != NULL) <td>{{ $complaint->user->mobile }}</td> @else <td></td> @endif
                                    <td>{{  $complaint->content }}</td>
                                        @if($complaint->task != NULL) <td>{{ $complaint->task->description }}</td> @else <td></td> @endif
                                        <td>{{ date('Y-m-d H:i:s', $complaint->creationtime) }}</td>

                                        @if($complaint->status == "0")
                                            <td>
                                                <a href="{{ URL::to('admin/complaint/p2pcomplaintdetail').'/'.$complaint->task_id }}"><button class="btn btn-primary btn-xs">未处理</button></a>
                                            </td>
                                        @elseif($complaint->status == "1")
                                            <td>
                                                <a href="{{ URL::to('admin/complaint/p2pcomplaintdetail').'/'.$complaint->task_id }}"><button class="btn btn-primary btn-xs">处理中</button></a>
                                            </td>
                                        @else
                                            <td>
                                                <a href="{{ URL::to('admin/complaint/p2pcomplaintdetail').'/'.$complaint->task_id }}"><button class="btn btn-primary btn-xs">完成</button></a>
                                            </td>
                                        @endif

                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-4">
                            <span>共{{ $complaints->total() }}条数据,共{{ $complaints->lastPage() }}页,当前显示第{{ $complaints->currentPage() }}页</span>
                        </div>
                        <div class="col-xs-8">
                            @if(isset($query))
                                <?php echo $complaints->appends(['query' => $query])->render(); ?>
                            @else
                                <?php echo $complaints->render(); ?>
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