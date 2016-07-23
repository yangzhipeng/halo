@extends('admin.layout.master')
@section('title', '投诉与建议')
@section('nav')
    <li>投诉与建议</li>
@endsection
@section('page_title', '投诉与建议')
@section('page_description', '投诉与建议')
@section('content')
    @if($complaints[0]->status < 2)
        <div class="row">
            <div class="col-xs-6">
                <form action="/admin/complaint/commentP2PComplain" method="post" class="">
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="mytoken" value="{{ md5(time()) }}">
                    <input type="hidden" name="taskid" value="{{$complaints[0]->task_id}}">
                    <div class="input-group">
                        @if(isset($comment))
                            <input class="form-control" type="text" name="comment" id="comment" placeholder="回复" value="{{ $comment }}">
                        @else
                            <input class="form-control" type="text" name="comment" id="comment" placeholder="回复">
                        @endif
                        <span class="input-group-btn">
                        <button type='submit' name='search' id='search-btn' class="btn btn-primary">回复</button>
                    </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="row" style="margin-top: 10px;">
            @include('admin.contact.create_modal_end')
            <div class="col-xs-12 ">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button type='submit' name='search' id='search-btn' class="btn btn-primary" data-toggle="modal" data-target="#endModal">结束任务</button>
                    </span>
                </div>
            </div>
            @include('admin.contact.create_modal_tip')
            @if($task[0]->status !=3 && $task[0]->status !=4)
                <div class="col-xs-12" style="margin-top: 10px;">
                    <div class="input-group">
                    <span class="input-group-btn">
                        <button type='submit' name='search' id='search-btn' class="btn btn-primary" data-toggle="modal" data-target="#tipModal">初始化任务</button>
                    </span>
                    </div>
                </div>
            @endif
        </div>
    @endif
    <div style="margin: 8px auto 0px auto; width: 100%; font-family: 微软雅黑;">
        <div style="clear: both; margin-top: 8px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr align="center">
                    <td valign="top" style="width: 655px;">
                        <div style="padding-top: 18px; margin: 0px auto 0px auto; width: 642px;">
                            <div style="border-left: solid 1px #E9E9E9; border-right: solid 1px #E9E9E9; border-bottom: solid 1px #E9E9E9;
                                    background-color: #F8F8F8; padding: 24px 0px 21px 0px; text-align: center;">
                                <table style="width: 562px; border-collapse: collapse; background-color: White; margin: auto"
                                       bordercolor="#E9E9E9" border="1">
                                    <tr>
                                        <td style="width: 100px; height: 33px; text-align: center;">
                                            投 诉 人：
                                        </td>
                                        <td colspan="3" style="text-align: left; padding-left: 10px;">
                                            <span id="LabelLetterKind">{{$complaints[0]->user->realname}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px; height: 33px; text-align: center;">
                                            任 务 ID：
                                        </td>
                                        <td colspan="3" style="text-align: left; padding-left: 10px;">
                                            <span id="LabelLetterKind">{{$complaints[0]->task_id}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px; height: 33px; text-align: center;">
                                            发 布 时 间：
                                        </td>
                                        <td colspan="3" style="text-align: left; padding-left: 10px;">
                                            <span id="LabelSubmitTime">{{ date('Y-m-d H:i:s', $complaints[0]->task->creationtime) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px; height: 33px; text-align: center;">
                                            发 布 者：
                                        </td>
                                        <td style="width: 230px; text-align: left; padding-left: 10px;">
                                            <span id="LabelLetterKind">{{$complaints[0]->task->issuer->realname}}</span>
                                        </td>
                                        <td style="width: 100px; text-align: center;">
                                            电 话：
                                        </td>
                                        <td style="width: 112px; text-align: left; padding-left: 10px;">
                                            <span id="LabelSubmitTime">{{$complaints[0]->task->issuer->mobile}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px; height: 33px; text-align: center;">
                                            领 取 者：
                                        </td>
                                        <td style="width: 230px; text-align: left; padding-left: 10px;">
                                            <span id="LabelLetterKind">
                                                @if($complaints[0]->task->acceptor)
                                                    {{$complaints[0]->task->acceptor->realname}}
                                                @endif
                                            </span>
                                        </td>
                                        <td style="width: 100px; text-align: center;">
                                            电 话：
                                        </td>
                                        <td style="width: 112px; text-align: left; padding-left: 10px;">
                                            <span id="LabelSubmitTime">
                                                @if($complaints[0]->task->acceptor)
                                                    {{$complaints[0]->task->acceptor->mobile}}
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px; height: 33px; text-align: center;">
                                            任务描述：
                                        </td>
                                        <td colspan="3" valign="top" style="text-align: left; width: 442px; padding: 10px;
                                                line-height: 24px;">
                                            <span id="LabelContent">{{$complaints[0]->task->description}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px; height: 33px; text-align: center;">
                                            投 诉 时 间：
                                        </td>
                                        <td colspan="3" valign="top" style="text-align: left; width: 442px; padding: 10px;
                                                line-height: 24px;">
                                            <span id="LabelContent">{{$complaints[0]->creationtime}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px; height: 33px; text-align: center;">
                                            投 诉 内 容：
                                        </td>
                                        <td colspan="3" valign="top" style="text-align: left; width: 442px; padding: 10px;
                                                line-height: 24px;">
                                            <span id="LabelContent">{{$complaints[0]->content}}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            @if(count($complaints) > 1)
                                @foreach($complaints as $complaint)
                                    @if($complaint->status > 2)
                                        <div style="border-left: solid 1px #E9E9E9; border-right: solid 1px #E9E9E9; border-bottom: solid 1px #E9E9E9;
                                    background-color: #F8F8F8; padding: 24px 0px 21px 0px; text-align: center;">
                                            <table style="width: 562px; border-collapse: collapse; background-color: White; margin: auto"
                                                   bordercolor="#E9E9E9" border="1">
                                                <tr>
                                                    <td style="width: 100px; height: 33px; text-align: center;">
                                                        处 理 人：
                                                    </td>
                                                    <td style="width: 230px; text-align: left; padding-left: 10px;">
                                                        <span id="LabelNumberReUnit"> {{$complaint->admin->hasOneAdminInfo->admin_name}}</span>
                                                    </td>
                                                    <td style="width: 90px; text-align: center;">
                                                        处 理 时 间：
                                                    </td>
                                                    <td style="width: 112px; text-align: center;">
                                                        <span id="LabelNumberReTime">{{ date('Y-m-d H:i:s', $complaint->creationtime) }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 100px; height: 33px; text-align: center;">
                                                        信息内容：
                                                    </td>
                                                    <td colspan="3" valign="top" style="text-align: left; width: 442px; padding: 10px;
                                                line-height: 24px;">
                                                <span id="LabelReContent">
                                                    {{$complaint->content}}
                                                </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
@section('js')
@endsection