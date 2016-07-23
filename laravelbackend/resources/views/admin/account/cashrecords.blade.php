@extends('admin.layout.master')

@section('title', '用户账户管理')

@section('nav')
    <li>用户管理</li>
@endsection


@section('page_title', '账户管理')

@section('page_description', '账户管理')

@section('account', 'active')

@section('account_cash', 'active')

@section('content')

    <div class="row">
        <div class="col-xs-6">
            <form action="/admin/account/cash" method="get" class="">
                {{--<input type="hidden" name="_method" value="POST">--}}
                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                <div class="input-group">
                    @if(isset($query))
                        <input class="form-control" type="text" name="query" id="query" placeholder="订单号、名字或电话" value="{{ $query }}">
                    @else
                        <input class="form-control" type="text" name="query" id="query" placeholder="订单号、名字或电话">
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
                    <h3 class="box-title">用户账户数据</h3>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-info">状态</button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ URL::to('admin/account/cashsel').'/0' }}">成交成功</a></li>
                        <li><a href="{{ URL::to('admin/account/cashsel').'/1' }}">成交失败</a></li>
                        <li><a href="{{ URL::to('admin/account/cashsel').'/2' }}">成交取消</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ URL::to('admin/account/cashsel').'/3' }}">待处理</a></li>
                    </ul>
                </div>


                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>订单号</th>
                            <th>名字</th>
                            <th>电话</th>
                            <th>时间</th>
                            <th>金额</th>
                            <th>支付方式</th>
                            <th>提现账号</th>
                            <th>状态</th>
                            <th>说明</th>
                            <th>提现操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($UserCashRecords) > 0)
                            @foreach($UserCashRecords as $UserCashRecord)
                                <tr>
                                    @if($UserCashRecord != NULL) <td>{{ $UserCashRecord->transaction_id }}</td> @else <td></td> @endif
                                    @if($UserCashRecord != NULL) <td>{{ $UserCashRecord->realname }}</td> @else <td></td> @endif
                                    @if($UserCashRecord != NULL) <td>{{ $UserCashRecord->mobile }}</td> @else <td></td> @endif
                                    @if($UserCashRecord != NULL) <td>{{ date('Y-m-d H:i:s', $UserCashRecord->modifiedtime) }}</td>@else <td></td> @endif
                                    @if($UserCashRecord != NULL) <td>{{ $UserCashRecord->fee }}</td> @else <td></td> @endif
                                    @if($UserCashRecord != NULL) <td>{{ $UserCashRecord->pay_type }}</td> @else <td></td> @endif
                                    @if($UserCashRecord != NULL) <td>{{ $UserCashRecord->third_no }}</td> @else <td></td> @endif
                                    @if($UserCashRecord != NULL) <td>{{ $UserCashRecord->status }}</td> @else <td></td> @endif
                                    @if($UserCashRecord != NULL) <td>{{ $UserCashRecord->memo }}</td> @else <td></td> @endif
                                    @if($UserCashRecord->status == "submit")
                                        <td>
                                            <a href="{{ URL::to('admin/account/cashoutdetail').'/'.$UserCashRecord->transaction_id }}"><button class="btn btn-primary btn-xs">确认提现</button></a>
                                        </td>
                                    @else
                                        <td></td>
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
                            <span>共{{ $UserCashRecords->total() }}条数据,共{{ $UserCashRecords->lastPage() }}页,当前显示第{{ $UserCashRecords->currentPage() }}页</span>
                        </div>
                        <div class="col-xs-8">
                            @if(isset($query))
                                <?php echo $UserCashRecords->appends(['query' => $query])->render(); ?>
                            @else
                                <?php echo $UserCashRecords->render(); ?>
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