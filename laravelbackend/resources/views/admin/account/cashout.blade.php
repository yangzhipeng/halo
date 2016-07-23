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


    <link href="{{ asset("/bower_components/AdminLTE/dist/css/cashdetail.css")}}" rel="stylesheet" type="text/css" />

    <div class="cashrow" style="margin-top: 20px">

        <div class="col-xs-12">
            <div class="box box-primary">

                <div id="tab_box">
                    <div class="u-form-wrap">
                        <!--style="display: none;"-->
                        <div id="drawcash_apply_box" class="u-form-wrap">
                            <div class="uf-tips">
                                <p style="color: red;">
                                    提现说明：<br />
                                    &nbsp;&nbsp;&nbsp;&nbsp; 1、在正常工作日（00:00—22:00）操作的 提现，均为次日12—17点之间到账（周五及周末操作的提现，均在下周一到账）；<br />
                                    &nbsp;&nbsp;&nbsp;&nbsp; 2、充值未投标客户，充值24小时后即可进行 提现操作，完成操作后需收取未投标提现金额的1%为服务费。<br />
                                </p>
                            </div>
                            <div>
                                <div id="drawcash_apply_div" class="m-form-box mt20 newbg noborderleft" style="overflow: visible;">
                                    <div class="m-form-til">
                                        <strong>请认真核对提现信息</strong></div>
                                    <div class="i-item i-long-item nobordertop">
                                        <label class="i-til">
                                            账户可用余额：</label><div class="i-right">
                                            <div class="i-txt">
                                                <i id="user_money_now">{{ $UserCashRecord[0]->fee }}</i>元</div>
                                        </div>
                                    </div>
                                    <!-- /.i-item -->
                                    <div class="i-item i-long-item">
                                        <label class="i-til">可提现金额：</label>
                                        <div class="i-right">
                                            <div class="i-txt">
                                                <i id="user_okdraw">{{ $UserCashRecord[0]->fee }}</i>元 <span class="red" style="font-size: 12px;">(需收取服务费部分：<i
                                                            id="user_feedraw">0.00</i>元，无需收取服务费部分：0.00元。) </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.i-item -->
                                    <div class="i-item i-long-item">
                                        <label class="i-til">提现方式：</label>
                                        <div class="i-right">
                                            <div class="i-txt">
                                                <i id="user_okdraw">{{ $UserCashRecord[0]->pay_type }}</i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="i-item i-long-item">
                                        <label class="i-til">提现金额：</label>
                                        <div class="i-right">
                                            <div class="i-txt">
                                                <i id="user_okdraw">{{ $UserCashRecord[0]->fee }}</i>
                                            </div>
                                        </div>
                                    </div>



                                    {{--<div class="i-item i-long-item">--}}
                                        {{--<label class="i-til">--}}
                                            {{--<span class="red"></span>使&nbsp;用&nbsp;积&nbsp;分：</label><div class="i-right">--}}
                                            {{--<label class="i-choose">--}}
                                                {{--<input name="usescore" value="1" id="drawcash_use_score" type="checkbox">--}}
                                                {{--&nbsp;&nbsp; (可用积分：0.0，需要：<i id="drawcash_need_score">0</i> 积分)--}}
                                            {{--</label>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    <div class="i-item i-long-item">
                                        <label class="i-til">
                                            提现手续费：</label><div class="i-right">
                                            <div class="i-txt">
                                                <i class="red" id="drawcash_fee_show">0.00</i>元
                                            </div>
                                        </div>
                                    </div>

                                    <div class="i-item i-long-item">
                                        <label class="i-til">
                                            服&nbsp;&nbsp;&nbsp;务&nbsp;&nbsp;&nbsp;费：</label><div class="i-right">
                                            <div class="i-txt">
                                                <i class="red" id="drawcash_sfee_show">0.00</i>元 <span class="red f12">(收取服务费部分：<i
                                                            id="drawcash_sfee_money">0.00</i>元。)</span></div>
                                        </div>
                                    </div>

                                    <div class="i-item i-long-item">
                                        <label class="i-til">
                                            实际到账金额：</label><div class="i-right">
                                            <div class="i-txt">
                                                <i class="red" id="drawcash_money_show">{{ $UserCashRecord[0]->fee }}</i>元
                                            </div>
                                        </div>
                                    </div>

                                    {{--<div class="i-item i-long-item">--}}
                                        {{--<label class="i-til">--}}
                                            {{--提现后账户可用余额：</label><div class="i-right">--}}
                                            {{--<div class="i-txt">--}}
                                                {{--<i class="red" id="user_money_show">0.00</i>元</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    <!-- /.i-item -->
                                    <div class="i-item i-long-item hasborderbot">
                                        <label class="i-til">
                                            开&nbsp;&nbsp;&nbsp;户&nbsp;&nbsp;&nbsp;名：</label><div class="i-right">
                                            <div class="i-txt">
                                                <i id="I1">{{ $UserCashRecord[0]->cashoutAccount->realname }}</i>&nbsp;</div>
                                        </div>
                                    </div>

                                    <div class="i-item i-long-item hasborderbot">
                                        <label class="i-til">
                                            提现帐号：</label><div class="i-right">
                                            <div class="i-txt">
                                                <i id="I1">{{ $UserCashRecord[0]->third_no }}</i>&nbsp;</div>
                                        </div>
                                    </div>

                                    <div class="i-item i-long-item hasborderbot">
                                        <label class="i-til">
                                            确认提现：</label><div class="i-right">
                                            <div class="i-txt">
                                            <a href="{{ URL::to('admin/account/confirm').'/'.$UserCashRecord[0]->transaction_id }}"><button class="btn btn-primary btn-xs">确认</button></a>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

@endsection

@section('js')

@endsection