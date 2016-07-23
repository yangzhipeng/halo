{{--@if ($errors->any())--}}
{{--<div class="alert alert-error alert-block">--}}
    {{--<button type="button" class="close" data-dismiss="alert">&times;</button>--}}
    {{--<h4>错误</h4>--}}
    {{--请检查下面的表单中的错误！--}}
{{--</div>--}}
{{--@endif--}}

@if (count($errors) > 0)
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>成功</h4>
    {{ $message }}
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-error alert-block">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>错误</h4>
    {{ $message }}
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>警告</h4>
    {{ $message }}
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-block">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>信息</h4>
    {{ $message }}
</div>
@endif