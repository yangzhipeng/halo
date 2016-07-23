<div class="modal fade" id="createModal" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>新增首页配置</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="createMedicineForm" action="{{ URL::to('admin/circleschool/homeconfig/create') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="schoolid" value="{{ $schoolid }}">
                            <div class="form-group">
                                <label for="medicineName">功能名称</label>
                                <input class="form-control" type="text" name="name" id="name">
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">图片</label>
                                <input class="form-control" type="file" name="file" id="file">
                            </div>
                            <div class="form-group">
                                <label for="packaging">Action-Android</label>
                                <input class="form-control" type="text" name="actionandroid" id="actionandroid" value="">
                            </div>
                            <div class="form-group">
                                <label for="specification">Action-Ios</label>
                                <input class="form-control" type="text" name="actionios" id="actionios" value="">
                            </div>
                            <div class="form-group">
                                <label for="indications">Action-Url</label>
                                <input class="form-control" type="text" name="actionurl" id="actionurl" value="">
                            </div>
                            <div class="form-group">
                                <label for="usage">操作类型</label>
                                <input class="form-control" type="hidden" name="actiontype" id="actiontype" value="">
                                <div class="btn-group">
                                    <button id="actionTypeBtn" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        请选择
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" id="" name="" >
                                        <li id="" onclick="changeActionType(0)"><a href="#">HTML5</a></li>
                                        <li id="" onclick="changeActionType(1)"><a href="#">原生</a></li>
                                        <li id="" onclick="changeActionType(2)"><a href="#">第三方应用</a></li>
                                        <li id="" onclick="changeActionType(3)"><a href="#">特殊处理</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="notes">排序</label>
                                <input class="form-control" type="hidden" name="weight" id="weight" value="{{ count($modules) + 1 }}">
                                <div class="btn-group">
                                    <button id="WeightBtn" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                        {{ count($modules) + 1 }}
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" id="" name="" >
                                        @for($i = 1; $i <= (count($modules) + 1);$i++)
                                            <li id="" onclick="changeWeight('{{ $i }}')"><a href="#">{{ $i }}</a></li>
                                        @endfor
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="adverseReaction">功能类型</label>
                                <input class="form-control" type="hidden" name="mtype" id="mtype" value="">
                                <div class="btn-group">
                                    <button id="typeBtn" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        请选择
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" id="" name="" >
                                        @if(count($moduleTypes) > 0)
                                            @foreach($moduleTypes as $moduleType)
                                                <li id="type{{ $moduleType->id }}" onclick="changeType('{{ $moduleType->id }}')"><a href="#">{{ $moduleType->name }}</a></li>
                                            @endforeach
                                        @endif
                                        <li id="type{{ 0 }}" onclick="changeType(0)"><a href="#">更多</a></li>
                                    </ul>
                                </div>
                            </div>
                            <input class="btn btn-primary" type="submit" id="subbtn" value="提交">
                            <button class="btn btn-default pull-right"  data-dismiss="modal">取消</button>
                        </form>
                    </div><!-- /.box-body -->
                    <!-- Loading (remove the following to stop the loading)-->
                    {{--<div class="overlay">--}}
                    {{--<i class="fa fa-refresh fa-spin"></i>--}}
                    {{--</div>--}}
                    <!-- end loading -->
                </div>
            </div>
        </div>
    </div>
</div>
