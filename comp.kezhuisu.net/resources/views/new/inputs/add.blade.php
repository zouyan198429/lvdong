@extends('layouts.app')

@push('headscripts')
    {{--  本页单独使用 --}}
    <link href="{{asset('dist/lib/datetimepicker/datetimepicker.min.css')}}" rel="stylesheet">
    <script src="{{asset('dist/lib/datetimepicker/datetimepicker.min.js')}}"></script>
@endpush

@section('content')
    <div class="content-header">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="icon icon-home"></i></a></li>
            <li><a href="{{ url('inputs/' . $pro_unit_id) }}">生产投入品</a></li>
            <li class="active">添加生产投入品</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">添加生产投入品</div>
                </div>
                <div class="panel-body">

                    <form  method="post"  id="addForm">
                        <input type="hidden" name="id" value="{{ $id or 0 }}"/>
                        <input type="hidden" name="pro_unit_id" value="{{ $pro_unit_id or 0 }}"/>
                        <div class="form-group">
                            <label>产品全称</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text"  name="pro_input_name" value="{{ $pro_input_name or '' }}" class="form-control" placeholder="请输入产品名称">
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="display: none;">
                            <label>类别</label>
                            <div class="row">
                                <div class="col-xs-3">
                                    <select  name="site_input_id"  class="form-control">
                                        <option value="0">请选择类别</option>
                                        @foreach ($SiteProInputs as $SiteProInput)
                                        <option value="{{ $SiteProInput['id'] }}" @if($SiteProInput['id'] == $site_input_id) selected @endif>{{ $SiteProInput['pro_input_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>上传图片</label>
                            <div class="row">
                                {{--上传图片--}}
                                @component('component.upfileone.piconecode')
                                @slot('fileList')
                                grid
                                @endslot
                                @endcomponent
                                {{--
                                <div class="col-xs-6">
                                    <input type="file" class="form-control" value="">
                                </div>
                                --}}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>品牌</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" name="pro_input_brand" value="{{ $pro_input_brand or '' }}" class="form-control" placeholder="请输入品种/品牌">
                                </div>
                            </div>
                            <div class="help-block">如：红富士</div>
                        </div>
                        <div class="form-group">
                            <label>厂家/来源</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text"  name="pro_input_factory" value="{{ $pro_input_factory or '' }}" class="form-control" placeholder="请输入生产厂家">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>简介及使用</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <textarea name="pro_input_intro"  class="form-control text-con" placeholder="请输入简介及使用">{{ $pro_input_intro or '' }}</textarea>
                                </div>
                            </div>
                            <div class="help-block">不超过250字为宜</div>
                        </div>
                        <button type="button" id="submitBtn" class="btn btn-primary">提交</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('footscripts')
<script>
    const SAVE_URL = "{{ url('api/inputs/ajax_save') }}";
    const LIST_URL = "{{url('inputs/' . $pro_unit_id . '/')}}";
    // 仅选择日期
    $(".form-date").datetimepicker(
    {
        language:  "zh-CN",
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,
        format: "yyyy-mm-dd"
    });
    var SUBMIT_FORM = true;//防止多次点击提交
    $(function(){
        // 一张图片上传
        @component('component.upfileone.piconejsinitincludeone')
        @slot('site_resources')
        @json($site_resources ?? [])
        @endslot
        @endcomponent
        //提交
        $(document).on("click","#submitBtn",function(){
            //var index_query = layer.confirm('您确定提交保存吗？', {
            //    btn: ['确定','取消'] //按钮
            //}, function(){
            ajax_form();
            //    layer.close(index_query);
            // }, function(){
            //});
            return false;
        })

    })
</script>
<script src="{{ asset('/js/lanmu/inputs_edit.js') }}"  type="text/javascript"></script>
@endpush
@push('footlast')
@component('component.upfileincludejs')
@endcomponent
@endpush