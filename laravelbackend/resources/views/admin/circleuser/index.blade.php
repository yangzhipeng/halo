@extends('admin.layout.master')

@section('title', '用户管理')

@section('nav')
    <li>用户管理</li>
@endsection


@section('page_title', '用户管理')

@section('page_description', '用户管理')

@section('circleuser', 'active')

@section('circleuser_index', 'active')

@section('content')

    <div class="row">
        <div class="col-xs-6">
            <form action="/admin/circleuser" method="get" class="">
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
                                    <td>{{ isset($user['nickName'])?$user['nickName']:'访客' }}</td>
                                    <td>{{ isset($user['phone'])?$user['phone']:'' }}</td>
                                    <td>{{ isset($user['createTime'])?$user['createTime']:'' }}</td>
                                    <td>
                                        <a href="{{ URL::to('admin/circleuser/log').'/'.$user['id'] }}"><button class="btn btn-primary btn-xs">查看日志</button></a>
                                    </td>
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
                                                <a href="/admin/circleuser?page=1&query={{ isset($query)?$query:'' }}" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>

                                        @if($page<5)
                                            @if($pages>=5)
                                                @for($i=1;$i<=5;$i++)
                                                    <li class="{{ $page==$i?'active':'' }}"><a href="/admin/circleuser?page={{ $i }}&query={{ isset($query)?$query:'' }}">{{ $i }}</a></li>
                                                @endfor
                                            @else
                                                @for($i=1;$i<=$pages;$i++)
                                                    <li class="{{ $page==$i?'active':'' }}"><a href="/admin/circleuser?page={{ $i }}&query={{ isset($query)?$query:'' }}">{{ $i }}</a></li>
                                                @endfor
                                            @endif
                                        @else
                                            @if($page==$pages)
                                                @for($i=$page-4;$i<=$page;$i++)
                                                    <li class="{{ $page==$i?'active':'' }}"><a href="/admin/circleuser?page={{ $i }}&query={{ isset($query)?$query:'' }}">{{ $i }}</a></li>
                                                @endfor
                                            @else
                                                @if($page>=$pages-2)
                                                    @for($i=$pages-4;$i<=$pages;$i++)
                                                        <li class="{{ $page==$i?'active':'' }}"><a href="/admin/circleuser?page={{ $i }}&query={{ isset($query)?$query:'' }}">{{ $i }}</a></li>
                                                    @endfor
                                                @endif
                                                @if($page<$pages-2)
                                                    @for($i=$page-2;$i<=$page+2;$i++)
                                                        <li class="{{ $page==$i?'active':'' }}"><a href="/admin/circleuser?page={{ $i }}&query={{ isset($query)?$query:'' }}">{{ $i }}</a></li>
                                                    @endfor
                                                @endif
                                            @endif
                                        @endif

                                        @if($page==$pages)
                                            <li class="disabled">
                                        @else
                                            <li>
                                        @endif
                                                <a href="/admin/circleuser?page={{ $pages }}&query={{ isset($query)?$query:'' }}" aria-label="Next">
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