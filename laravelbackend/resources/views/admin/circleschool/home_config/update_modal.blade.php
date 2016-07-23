<div class="modal fade" id="updateModal{{ $module->id }}" role="dialog" aria-hidden="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>首页配置详情</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form" id="createMedicineForm" action="{{ URL::to('admin/circleschool/homeconfig/update'.'/'.$module->id) }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="medicineName">功能名称</label>
                                <input class="form-control" type="text" name="name" id="name" value="{{ $module->name }}">
                            </div>
                            <div class="form-group">
                                <label for="medicineCoposition">图片</label>
                                <input class="form-control" type="file" name="file" id="file">
                            </div>
                            <div class="form-group">
                                <label for="packaging">Action-Android</label>
                                <input class="form-control" type="text" name="actionandroid" id="actionandroid" value="{{ $module->actionandroid }}">
                            </div>
                            <div class="form-group">
                                <label for="specification">Action-Ios</label>
                                <input class="form-control" type="text" name="actionios" id="actionios" value="{{ $module->actionios }}">
                            </div>
                            <div class="form-group">
                                <label for="indications">Action-Url</label>
                                <input class="form-control" type="text" name="actionurl" id="actionurl" value="{{ $module->actionurl }}">
                            </div>
                            <div class="form-group">
                                <label for="usage">操作类型</label>
                                <input class="form-control" type="hidden" name="actiontype" id="actiontype{{ $module->id }}" value="{{ $module->actiontype }}">
                                <div class="btn-group">
                                    <button id="actionTypeBtn{{ $module->id }}" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        @if($module->actiontype == 0)
                                            HTML5
                                        @elseif($module->actiontype == 1)
                                            原生
                                        @elseif($module->actiontype == 2)
                                            第三方应用
                                        @elseif($module->actiontype == 3)
                                            特殊处理
                                        @else
                                            请选择
                                        @endif
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" id="" name="" >
                                        <li id="" onclick="changeActionType(0, '{{ $module->id }}')"><a href="#">HTML5</a></li>
                                        <li id="" onclick="changeActionType(1, '{{ $module->id }}')"><a href="#">原生</a></li>
                                        <li id="" onclick="changeActionType(2, '{{ $module->id }}')"><a href="#">第三方应用</a></li>
                                        <li id="" onclick="changeActionType(3, '{{ $module->id }}')"><a href="#">特殊处理</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="notes">排序</label>
                                <input class="form-control" type="hidden" name="weight" id="weight{{ $module->id }}" value="{{ $module->weight }}">
                                <div class="btn-group">
                                    <button id="WeightBtn{{ $module->id }}" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                        {{ $module->weight }}
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" id="" name="" >
                                        @for($i = 1; $i <= count($modules);$i++)
                                            <li id="" onclick="changeWeight('{{ $i }}', '{{ $module->id }}')"><a href="#">{{ $i }}</a></li>
                                        @endfor
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="adverseReaction">功能类型</label>
                                <input class="form-control" type="hidden" name="mtype" id="mtype{{ $module->id }}" value="{{ $module->mtype }}">
                                <div class="btn-group">
                                    <button id="typeBtn{{ $module->id }}" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        {{ $module->belongsToModuleType->name or '更多'}}
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" id="" name="" >
                                        @if(count($moduleTypes) > 0)
                                            @foreach($moduleTypes as $moduleType)
                                                <li id="type{{ $moduleType->id }}{{ $module->id }}" onclick="changeType('{{ $moduleType->id }}', '{{ $module->id }}')"><a href="#">{{ $moduleType->name }}</a></li>
                                            @endforeach
                                        @endif
                                        <li id="type{{ 0 }}{{ $module->id }}" onclick="changeType(0, '{{ $module->id }}')"><a href="#">更多</a></li>
                                    </ul>
                                </div>
                            </div>
                            <input class="btn btn-primary" type="submit" id="subbtn" value="修改">
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
