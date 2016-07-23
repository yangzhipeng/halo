@extends('admin.layout.master')

@section('title', '用户账户管理')

@section('nav')
    <li>用户管理</li>
@endsection


@section('page_title', '账户管理')

@section('page_description', '账户管理')

@section('account', 'active')

@section('account_charge', 'active')

@section('content')

    <div class="row">
        <div class="col-xs-6">
            <form action="/admin/account/charge" method="get" class="">
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
                            <th>状态</th>
                            <th>说明</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($UserChargeRecords) > 0)
                            @foreach($UserChargeRecords as $UserChargeRecord)
                                <tr>
                                    @if($UserChargeRecord != NULL)<td>{{ $UserChargeRecord->transaction_id }}</td> @else <td></td> @endif
                                    @if($UserChargeRecord != NULL) <td>{{ $UserChargeRecord->realname }}</td> @else <td></td> @endif
                                    @if($UserChargeRecord != NULL) <td>{{ $UserChargeRecord->mobile }}</td> @else <td></td> @endif
                                    @if($UserChargeRecord != NULL)<td>{{ date('Y-m-d H:i:s', $UserChargeRecord->modifiedtime) }}</td> @else <td></td> @endif
                                    @if($UserChargeRecord != NULL)<td>{{ $UserChargeRecord->fee }}</td> @else <td></td> @endif
                                    @if($UserChargeRecord != NULL)<td>{{ $UserChargeRecord->pay_type }}</td> @else <td></td> @endif
                                    @if($UserChargeRecord != NULL)<td>{{ $UserChargeRecord->status }}</td> @else <td></td> @endif
                                    @if($UserChargeRecord != NULL)<td>{{ $UserChargeRecord->memo }}</td> @else <td></td> @endif
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-4">
                            <span>共{{ $UserChargeRecords->total() }}条数据,共{{ $UserChargeRecords->lastPage() }}页,当前显示第{{ $UserChargeRecords->currentPage() }}页</span>
                        </div>
                        <div class="col-xs-8">
                            @if(isset($query))
                                <?php echo $UserChargeRecords->appends(['query' => $query])->render(); ?>
                            @else
                                <?php echo $UserChargeRecords->render(); ?>
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