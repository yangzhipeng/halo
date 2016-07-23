@extends('admin.layout.master')

@section('title', '新增学校')

@section('page_title', '新增学校')

@section('nav')
    <li><a href="/admin/school">学校管理</a></li>
    <li class="active">新增学校</li>
@endsection

@section('page_description', '新增学校')

@section('school_index', 'active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body">
                    <form class="form" action="" method="post">
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="name">名称</label>
                            <input class="form-control" type="text" name="name" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="mobile">电话</label>
                            <input class="form-control" type="text" name="mobile" id="mobile" required>
                        </div>
                        <div class="form-group">
                            <label>省份</label>
                            <input type="hidden" name="ProvinceID"  id="ProvinceID" value="0">
                            <select id="ProvinceSelect" class="form-control" onchange="selectProvince()">
                                <option value="0">省份</option>
                                @if(count($provinces) > 0)
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->provinceid }}">{{ $province->provincename }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>城市</label>
                            <input type="hidden" name="CityID"  id="CityID" value="0">
                            <select id="CitySelect" class="form-control" onchange="selectCity()">
                                <option value="0">城市</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>区县</label>
                            <input type="hidden" name="DistrictID"  id="DistrictID" value="0">
                            <select id="DistrictSelect" class="form-control" onchange="selectDistrict()">
                                <option value="0">县区</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Lon">经度</label>
                            <input class="form-control" type="text" name="Lon" id="Lon">
                        </div>
                        <div class="form-group">
                            <label for="Lat">纬度</label>
                            <input class="form-control" type="text" name="Lat" id="Lat">
                        </div>
                        <div class="form-group">
                            <label for="Addr">地址</label>
                            <input class="form-control" type="text" name="Addr" id="Addr" required>
                        </div>
                        <input  type="submit" class="btn btn-primary" id="subbtn"  value="提交">
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

@endsection

@section('js')

    <script>

        function selectProvince()
        {
            var provinceID = $("#ProvinceSelect").prop('value');
            $("#ProvinceID").prop('value', provinceID);

            $("#CitySelect").empty();
            $("#CitySelect").prop('value', 0);
            $("#CitySelect").append("<option value=\"0\">城市</option>");
            $("#DistrictSelect").empty();
            $("#DistrictSelect").prop('value', 0);
            $("#DistrictSelect").append("<option value=\"0\">县区</option>");

            $.ajax({
                type : 'post',
                url : '/admin/school/cities',
                data : { 'provinceId' : provinceID},
                dataType : 'json',
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },

                success : function(data){

                    if(data.cities.length > 0)
                    {
                        $.each(data.cities, function(index, item){

                            $("#CitySelect").append("<option value=\"" + item.cityid + "\">"+ item.cityname +"</option>");
                        });
                    }

                },

                error : function(xhr, type){
                    alert('ajax error!')
                }

            });
        }

        function selectCity()
        {
            var provinceID = $("#ProvinceSelect").prop('value');
            var CityID = $("#CitySelect").prop('value');
            $("#CityID").prop('value', CityID);

            $("#DistrictSelect").empty();
            $("#DistrictSelect").prop('value', 0);
            $("#DistrictSelect").append("<option value=\"0\">县区</option>");

            $.ajax({
                type : 'post',
                url : '/admin/school/districts',
                data : { 'provinceId' : provinceID, 'cityId' : CityID},
                dataType : 'json',
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },

                success : function(data){
                    if(data.districts.length > 0)
                    {
                        $.each(data.districts, function(index, item){

                            $("#DistrictSelect").append("<option value=\"" + item.districtid + "\">"+ item.districtname +"</option>");
                        });
                    }

                },

                error : function(xhr, type){
                    alert('ajax error!')
                }

            });
        }

        function selectDistrict()
        {
            var DistrictID = $("#DistrictSelect").prop('value');
            $("#DistrictID").prop('value', DistrictID);
        }


    </script>

@endsection
