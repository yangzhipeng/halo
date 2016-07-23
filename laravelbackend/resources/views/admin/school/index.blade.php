@extends('admin.layout.master')

@section('title', '学校列表')

@section('page_title', '学校列表')

@section('nav')
    <li>学校列表</li>
@endsection

@section('page_description', '学校列表')

@section('school_index', 'active')

@section('content')

    <div class="row">
        <div class="col-xs-6">
            <form action="/admin/school" method="get" class="">
                {{--<input type="hidden" name="_method" value="POST">--}}
                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                <div class="input-group">
                    @if(isset($query))
                        <input class="form-control" type="text" name="query" id="query" placeholder="学校名称" value="{{ $query }}">
                    @else
                        <input class="form-control" type="text" name="query" id="query" placeholder="学校名称">
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
                    <h3 class="box-title">学校列表</h3>
                </div>

                <div class="box-body">
                    @if(!isset($query))
                        <a href="/admin/school/create"><button class="btn btn-primary" role="button">增加</button></a>
                    @endif
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>学校名称</th>
                            <th>学校地址</th>
                            <th>是否禁止</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($schools) > 0)
                            @foreach($schools as $school)
                                <tr>
                                    <td>{{ $school->name }}</td>
                                    <td>{{ $school->address }}</td>
                                    @if($school->isforbidded == 0)
                                        <td><input id="banCheck{{ $school->bid }}" type="checkbox" onchange="changeBanStatus({{ $school->bid }})"></td>
                                    @else
                                        <td><input id="banCheck{{ $school->bid }}" type="checkbox" onchange="changeBanStatus({{ $school->bid }}) " checked></td>
                                    @endif
                                    <td>
                                        <a href="/admin/school/{{ $school->bid }}"><button class="btn btn-primary btn-xs">详情</button></a>
                                    </td>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-4">
                            <span>共{{ $schools->total() }}条数据,共{{ $schools->lastPage() }}页,当前显示第{{ $schools->currentPage() }}页</span>
                        </div>
                        <div class="col-xs-8">
                            @if(isset($query))
                                <?php echo $schools->appends(['query' => $query])->render(); ?>
                            @else
                                <?php echo $schools->render(); ?>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('js')

    <script type="text/javascript">

        function changeBanStatus(id)
        {
            var isBan;

            if($("#banCheck" + id).prop('checked'))
            {
                isBan = 1;
            }else{
                isBan = 0;
            }

            $.ajax({

                type : 'post',
                url : '/admin/school/change-ban',
                data : { 'schoolId' : id, 'isBan' : isBan},
                dataType : 'json',
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },

                success : function(data){
                    if(data.code == 1){
                        $("#banCheck" + id).prop('checked', true)
                    }else if(data.code == 0){
                        $("#banCheck" + id).prop('checked', false)
                    }else{
                        if($("#banCheck" + id).prop('checked')){
                            $("#banCheck" + id).prop('checked', false)
                        }else{
                            $("#banCheck" + id).prop('checked', true)
                        }
                    }
                },

                error : function(xhr, type){
                    alert('ajax error!')
                    $("#banCheck" + id).prop('checked', false)
                }

            });
        }

    </script>
@endsection