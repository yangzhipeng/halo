@extends('admin.layout.master')

@section('title', '用户账户管理')

@section('nav')
    <li>用户管理</li>
@endsection


@section('page_title', '账户管理')

@section('page_description', '账户管理')

@section('account', 'active')

@section('account_inline', 'active')

@section('content')

    <div class="row">
        <div class="col-xs-6">
            <form action="/admin/account/transaction_records" method="get" class="">
                {{--<input type="hidden" name="_method" value="POST">--}}
                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                <div class="input-group">
                    @if(isset($query))
                        <input class="form-control" type="text" name="query" id="query" placeholder="交易订单号" value="{{ $query }}">
                    @else
                        <input class="form-control" type="text" name="query" id="query" placeholder="交易订单号">
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
                    <h3 class="box-title">校里交易数据</h3>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-info">交易类型</button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ URL::to('admin/account/transType').'/0' }}">收入</a></li>
                        <li><a href="{{ URL::to('admin/account/transType').'/1' }}">支出</a></li>
                    </ul>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-info">交易状态</button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ URL::to('admin/account/transStatu').'/0' }}">交易成功</a></li>
                        <li><a href="{{ URL::to('admin/account/transStatu').'/1' }}">交易失败</a></li>
                        <li><a href="{{ URL::to('admin/account/transStatu').'/2' }}">交易取消</a></li>
                    </ul>
                </div>

                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>交易订单号</th>
                            <th>创建时间</th>
                            <th>校里账户名</th>
                            <th>交易金额</th>
                            <th>交易方式</th>
                            <th>交易类型</th>
                            <th>交易状态</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($transactionInfos) > 0)
                            @foreach($transactionInfos as $transInfo)
                                <tr>
                                    @if($transInfo != NULL)<td>{{ $transInfo->transaction_id }}</td> @else <td></td> @endif
                                    @if($transInfo != NULL)<td>{{ date('Y-m-d H:i:s', $transInfo->creationtime) }}</td> @else <td></td> @endif
                                    @if($transInfo != NULL) <td>{{ $transInfo->realname }}</td> @else <td></td> @endif
                                    @if($transInfo != NULL)<td>{{ $transInfo->fee }}</td> @else <td></td> @endif
                                    @if($transInfo != NULL)<td>{{ $transInfo->pay_type }}</td> @else <td></td> @endif
                                    @if($transInfo != NULL) <td>{{ $transInfo->transaction_type }}</td> @else <td></td> @endif
                                    @if($transInfo != NULL)<td>{{ $transInfo->status }}</td> @else <td></td> @endif
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-4">
                            <span>共{{ $transactionInfos->total() }}条数据,共{{ $transactionInfos->lastPage() }}页,当前显示第{{ $transactionInfos->currentPage() }}页</span>
                        </div>
                        <div class="col-xs-8">
                            @if(isset($query))
                                <?php echo $transactionInfos->appends(['query' => $query])->render(); ?>
                            @else
                                <?php echo $transactionInfos->render(); ?>
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