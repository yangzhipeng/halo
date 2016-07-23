<div class="box box-primary">
    <div class="box-header with-border">
            <h3 class="box-title">校里会员卡配置</h3>
    </div>

    <div class="box-body">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">所有会员卡</a></li>
                <li><a href="#tab_2" data-toggle="tab">校里推荐会员卡</a></li>
                <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <div class="col-xs-6">
                            <form action="/admin/circleschool/{{ $schoolid }}/bizcard" method="get" class="">
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

                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>商户ID</th>
                            <th>商铺名</th>
                            <th>地址</th>
                            <th>图片</th>
                            <th>是否为校里推荐</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($bizcards) > 0)
                            @foreach($bizcards as $bizcard)
                                <tr>
                                    <td>{{ $bizcard['bid'] }}</td>
                                    <td>{{ $bizcard['biz_name'] }}</td>
                                    <td>{{ $bizcard['biz_address'] }}</td>
                                    <td>
                                        <imag src="{{ $bizcard['frontimageurl'] }}"></imag>
                                    </td>
                                    <td>{{ $bizcard['isunirecommend'] }}</td>
                                    <td>
                                        @if($bizcard['isunirecommend'] == 'Y')
                                            <a href="#"><button class="btn btn-danger btn-xs" role="button" data-toggle="modal" onclick="removeUniRecommend({{ $schoolid }} , {{ $bizcard['bid'] }})">撤销校里推荐</button></a>
                                        @else
                                            <a href="#"><button class="btn btn-primary btn-xs" role="button" data-toggle="modal" onclick="setUniRecommend({{ $schoolid }} , {{ $bizcard['bid'] }})">设为校里推荐</button></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                        <div class="row">
                            <div class="col-xs-4">
                                <span>共{{ $bizcards->total() }}条数据,共{{ $bizcards->lastPage() }}页,当前显示第{{ $bizcards->currentPage() }}页</span>
                            </div>
                            <div class="col-xs-8">
                                @if(isset($query))
                                    <?php echo $bizcards->appends(['query' => $query])->render(); ?>
                                @else
                                    <?php echo $bizcards->render(); ?>
                                @endif
                            </div>
                        </div>
                </div>
                <div class="tab-pane " id="tab_2">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>商户ID</th>
                            <th>商铺名</th>
                            <th>图片</th>
                            <th>地址</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($unibizcards) > 0)
                            @foreach($unibizcards as $bizcard)
                                <tr>
                                    <td>{{ $bizcard->bid }}</td>
                                    <td>{{ $bizcard->biz_name }}</td>
                                    <td>
                                        <imag src="{{ $bizcard->frontimageurl }}"></imag>
                                    </td>
                                    <td>{{ $bizcard->biz_address }}</td>
                                    <td>
                                        <a href="#"><button class="btn btn-danger btn-xs" role="button" data-toggle="modal" onclick="removeUniRecommend({{ $schoolid }} , {{ $bizcard->bid }})">撤销校里推荐</button></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-xs-4">
                            <span>共{{ $unibizcards->total() }}条数据,共{{ $unibizcards->lastPage() }}页,当前显示第{{ $unibizcards->currentPage() }}页</span>
                        </div>
                        <div class="col-xs-8">
                            @if(isset($query))
                                <?php echo $unibizcards->appends(['query' => $query])->render(); ?>
                            @else
                                <?php echo $unibizcards->render(); ?>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
    function setUniRecommend(schoolid, bid){
        window.location.href = "{{ URL::to('admin/circleschool/') }}" + "/" + schoolid + "/bizcard/set-uni-recommend?bid=" + bid;
    }

    function removeUniRecommend(schoolid, bid){
        window.location.href = "{{ URL::to('admin/circleschool/') }}" + "/" + schoolid + "/bizcard/remove-uni-recommend?bid=" + bid;
    }
</script>

