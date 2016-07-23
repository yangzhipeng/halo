@extends('admin.layout.master')

@section('title', '用户管理')

@section('nav')
    <li><a href="#">用户管理</a></li>
    <li class="active">用户日志</li>
@endsection

@section('page_title', '用户日志')

@section('page_description', $user['nickName'])

@section('circleuser_admin', 'active')

@section('content')

    <div class="row" style="margin-top: 20px">

        <div class="col-xs-12">
            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">{{ $user['nickName'] }}的日志</h3>
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
                                    <td>{{ $log['type']==0?'login':'logout' }}</td>
                                    <td>{{ $log['loginType']==0?'正常登录':'第三方登录' }}</td>
                                    <td>{{ $log['createTime'] }}</td>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="row" >
                        <div class="col-xs-4">
                            <span>共{{ $total }}条数据,共{{ $pages }}页,当前显示第{{ $page }}页</span>
                        </div>
                        <div class="col-xs-8">
                            <nav>
                                <ul class="pagination">
                                    @if($pages>1)
                                        @if($page==1)
                                            <li class="disabled">
                                        @else
                                            <li>
                                        @endif
                                                <a href="/admin/circleuser/log/{{ $cid }}?page=1" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>

                                        @if($page<5)
                                            @if($pages>=5)
                                                @for($i=1;$i<=5;$i++)
                                                    <li class="{{ $page==$i?'active':'' }}"><a href="/admin/circleuser/log/{{ $cid }}?page={{ $i }}">{{ $i }}</a></li>
                                                @endfor
                                            @else
                                                @for($i=1;$i<=$pages;$i++)
                                                    <li class="{{ $page==$i?'active':'' }}"><a href="/admin/circleuser/log/{{ $cid }}?page={{ $i }}">{{ $i }}</a></li>
                                                @endfor
                                            @endif
                                        @else
                                            @if($page==$pages)
                                                @for($i=$page-4;$i<=$page;$i++)
                                                    <li class="{{ $page==$i?'active':'' }}"><a href="/admin/circleuser/log/{{ $cid }}?page={{ $i }}">{{ $i }}</a></li>
                                                @endfor
                                            @else
                                                @if($page>=$pages-2)
                                                    @for($i=$pages-4;$i<=$pages;$i++)
                                                        <li class="{{ $page==$i?'active':'' }}"><a href="/admin/circleuser/log/{{ $cid }}?page={{ $i }}">{{ $i }}</a></li>
                                                    @endfor
                                                @endif
                                                @if($page<$pages-2)
                                                    @for($i=$page-2;$i<=$page+2;$i++)
                                                        <li class="{{ $page==$i?'active':'' }}"><a href="/admin/circleuser/log/{{ $cid }}?page={{ $i }}">{{ $i }}</a></li>
                                                    @endfor
                                                @endif
                                            @endif
                                        @endif

                                        @if($page==$pages)
                                            <li class="disabled">
                                        @else
                                            <li>
                                        @endif
                                                <a href="/admin/circleuser/log/{{ $cid }}?page={{ $pages }}" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                    @endif
                                </ul>

                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection


@section('js')

@endsection