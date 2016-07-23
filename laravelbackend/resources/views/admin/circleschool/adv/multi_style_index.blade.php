<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">多样式广告</h3>
    </div>

    <div class="box-body">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Style 1</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Style 2</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Style 3</a></li>
                    <li><a href="#tab_4" data-toggle="tab">Style 4</a></li>
                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">

                        <button class="btn btn-primary" id="subBtn" role="button" data-toggle="modal" data-target="#createModalStyle1">增加</button>
                        @include('admin.circleschool.adv.create_modal_style1')

                        <table class="table table-bordered table-hover" style="table-layout:fixed">
                            <thead>
                            <tr>
                                <th>标题</th>
                                <th>外部链接</th>
                                <th>图片</th>
                                <th>类别</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($advs_style1) > 0)
                                @foreach($advs_style1 as $adv)
                                    <tr>
                                        <td>{{ $adv->title }}</td>
                                        <td style="WORD-WRAP: break-word" width="20">{{ $adv->outerurl }}</td>
                                        <td><img src="{{ Config::get('uni.image_base_url').$adv->imageurl }}" style="width: 100px;height: 100px"></td>
                                        @if($adv->content_type == 1)
                                            <td>外部广告</td>
                                        @else
                                            <td>内部广告</td>
                                        @endif
                                        <td>
                                            <a href="#updateBtn{{ $adv->id }}"><button name="updateBtn{{ $adv->id }}" class="btn btn-primary btn-xs"role="button" data-toggle="modal" data-target="#updateModal{{ $adv->id }}">修改</button></a>
                                            <a href="#delBtn{{ $adv->id }}"><button name="delBtn{{ $adv->id }}" class="btn btn-danger btn-xs" onclick="delAdvConfigOnClickLintener({{ $adv->id }})">删除</button></a>
                                        </td>
                                    @include('admin.circleschool.adv.update_modal')
                                @endforeach
                                @include('admin.layout.widgets.comfirm_modal')
                            @endif
                            </tbody>
                        </table>
                    </div><!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <button class="btn btn-primary" id="bnt_style2_create" role="button" data-toggle="modal" data-target="#createModalStyle2">增加</button>
                        @include('admin.circleschool.adv.create_modal_style2')
                        @if( count($advs_style2) > 0)
                            @foreach($advs_style2 as $adv_group)
                                <table id="{{ $adv_group[0] }}" class="table table-bordered table-hover" style="table-layout:fixed">
                                    <thead>
                                    <tr>
                                        <th>标题</th>
                                        <th>外部链接</th>
                                        <th>图片</th>
                                        <th>类别</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for ($i = 1; $i < count($adv_group); $i++)
                                        <tr>
                                            <td>{{ $adv_group[$i]->title }}</td>
                                            <td style="WORD-WRAP: break-word" width="20">{{ $adv_group[$i]->outerurl }}</td>
                                            <td><img src="{{ Config::get('uni.image_base_url').$adv_group[$i]->imageurl }}" style="width: 100px;height: 100px"></td>
                                            @if($adv_group[$i]->content_type == 1)
                                                <td>外部广告</td>
                                            @else
                                                <td>内部广告</td>
                                            @endif
                                            <td>
                                                <a href="#updateBtn{{ $adv_group[$i]->id }}"><button name="updateBtn{{ $adv_group[$i]->id }}" class="btn btn-primary btn-xs"role="button" data-toggle="modal" data-target="#updateModal{{ $adv_group[$i]->id }}">修改</button></a>
                                            </td>
                                        @include('admin.circleschool.adv.update_modal_multi_style')
                                    @endfor
                                    </tbody>
                                </table>
                                <button class="btn btn-primary" id="bnt_style2_del" role="button" data-toggle="modal" data-target="#createModal" onclick="delTable({{ $adv_group[0] }})">删除</button>

                            @endforeach
                        @endif
                    </div><!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">
                        <button class="btn btn-primary" id="bnt_style3_create" role="button" data-toggle="modal" data-target="#createModalStyle3">增加</button>
                        @include('admin.circleschool.adv.create_modal_style3')
                        @if( count($advs_style3) > 0)
                            @foreach($advs_style3 as $adv_group)
                                <table id="{{ $adv_group[0] }}" class="table table-bordered table-hover" style="table-layout:fixed">
                                    <thead>
                                    <tr>
                                        <th>标题</th>
                                        <th>外部链接</th>
                                        <th>图片</th>
                                        <th>类别</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for ($i = 1; $i < count($adv_group); $i++)
                                        <tr>
                                            <td>{{ $adv_group[$i]->title }}</td>
                                            <td style="WORD-WRAP: break-word" width="20">{{ $adv_group[$i]->outerurl }}</td>
                                            <td><img src="{{ Config::get('uni.image_base_url').$adv_group[$i]->imageurl }}" style="width: 100px;height: 100px"></td>
                                            @if($adv_group[$i]->content_type == 1)
                                                <td>外部广告</td>
                                            @else
                                                <td>内部广告</td>
                                            @endif
                                            <td>
                                                <a href="#updateBtn{{ $adv_group[$i]->id }}"><button name="updateBtn{{ $adv_group[$i]->id }}" class="btn btn-primary btn-xs"role="button" data-toggle="modal" data-target="#updateModal{{ $adv_group[$i]->id }}">修改</button></a>
                                            </td>
                                        @include('admin.circleschool.adv.update_modal_multi_style')
                                    @endfor
                                    </tbody>
                                </table>
                                <button class="btn btn-primary" id="bnt_style2_del" role="button" data-toggle="modal" data-target="#createModal" onclick="delTable({{ $adv_group[0] }})">删除</button>

                            @endforeach
                        @endif
                    </div><!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_4">
                        <button class="btn btn-primary" id="bnt_style4_create" role="button" data-toggle="modal" data-target="#createModalStyle4">增加</button>
                        @include('admin.circleschool.adv.create_modal_style4')
                        @if( count($advs_style4) > 0)
                            @foreach($advs_style4 as $adv_group)
                                <table id="{{ $adv_group[0] }}" class="table table-bordered table-hover" style="table-layout:fixed">
                                    <thead>
                                    <tr>
                                        <th>标题</th>
                                        <th>外部链接</th>
                                        <th>图片</th>
                                        <th>类别</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for ($i = 1; $i < count($adv_group); $i++)
                                        <tr>
                                            <td>{{ $adv_group[$i]->title }}</td>
                                            <td style="WORD-WRAP: break-word" width="20">{{ $adv_group[$i]->outerurl }}</td>
                                            <td><img src="{{ Config::get('uni.image_base_url').$adv_group[$i]->imageurl }}" style="width: 100px;height: 100px"></td>
                                            @if($adv_group[$i]->content_type == 1)
                                                <td>外部广告</td>
                                            @else
                                                <td>内部广告</td>
                                            @endif
                                            <td>
                                                <a href="#updateBtn{{ $adv_group[$i]->id }}"><button name="updateBtn{{ $adv_group[$i]->id }}" class="btn btn-primary btn-xs"role="button" data-toggle="modal" data-target="#updateModal{{ $adv_group[$i]->id }}">修改</button></a>
                                            </td>
                                        @include('admin.circleschool.adv.update_modal_multi_style')
                                    @endfor
                                    </tbody>
                                </table>
                                <button class="btn btn-primary" id="bnt_style2_del" role="button" data-toggle="modal" data-target="#createModal" onclick="delTable({{ $adv_group[0] }})">删除</button>

                            @endforeach
                        @endif
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
        </div><!-- /.col -->

</div>


<script>
    function delAdvConfigOnClickLintener(id)
    {
        $("#modal-content").text("你确定删除么?");
        $("#comfirmModal").modal('show');
        $("#confirSpan").empty();
        $("#confirSpan").append("<button class=\"btn btn-primary pull-left\" id=\"confirmBtn\" onclick=\"advComfirmAction("+ id +")\" data-dismiss=\"modal\">确定</button>")
    }

    function advComfirmAction(id)
    {
        location.href = '/admin/circleschool/adv/delete/' + id;
    }

    function delTable(id)
    {
        if(confirm("确定要清空数据吗？")) {
            location.href = '/admin/circleschool/adv/delete-multi-style/' + id;
        }
    }

</script>
