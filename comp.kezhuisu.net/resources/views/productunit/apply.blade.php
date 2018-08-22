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
            <li><a href="{{ url('productunit/') }}">生产单元</a></li>
            <li class="active">新建生产单元</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p>提交申请后，我们会在2个工作日内完成审核。</p>
            </div>
            <div class="panel">
                <div class="panel-body">
                    <form  method="post"  id="addForm">
                        <input type="hidden" name="id" value="{{ $id or 0 }}"/>
                        <div class="form-group">
                            <label>类别</label>
                            <div class="row">
                                <div class="col-xs-3">
                                    <select class="form-control" name="site_pro_unit_id">
                                        <option value="">请选择</option>
                                        @foreach ($unitcls as $key=>$item)
                                            <option value="{{ $key }}" @if ( $key == $site_pro_unit_id ) selected @endif>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xs-3">
                                    <select class="form-control"  name="site_pro_unit_id_two">
                                        <option value="">请选择</option>
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
                            <label><span class="red">*</span> 产品名称</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" name="pro_input_name" value="{{ $pro_input_name or '' }}"  class="form-control" placeholder="请输入产品名称">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>品种</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" name="pro_input_brand" value="{{ $pro_input_brand or '' }}"  class="form-control" placeholder="请输入品种">
                                </div>
                            </div>
                            <div class="help-block">如：红富士</div>
                        </div>
                        <div class="form-group">
                            <label>批次（选填）</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" name="pro_input_batch" value="{{ $pro_input_batch or '' }}"  class="form-control" placeholder="请输入生产批次">
                                </div>
                            </div>
                            <div class="help-block">如：第201801批</div>
                        </div>
                        <div class="form-group">
                            <label><span class="red">*</span> 生产周期</label>
                            <div class="row">
                                <div class="col-xs-3">
                                    <input type="text" name="begin_time" value="{{ $begin_time or '' }}"  class="form-control form-date" placeholder="选择或者输入一个日期：yyyy-MM">
                                </div>
                                <div class="col-xs-3">
                                    <input type="text"  name="end_time" value="{{ $end_time or '' }}"  class="form-control form-date" placeholder="选择或者输入一个日期：yyyy-MM">
                                </div>
                            </div>
                            <div class="help-block">可选择到月</div>
                        </div>
                        <div class="form-group">
                            <label><span class="red">*</span> 生产记录人</label>
                            <div class="{{--checkbox-custom--}} checkbox-primary selAccounts">
                                @foreach ($accountList as $account)
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="{{ $account['id'] or '' }}" name="accout_id[]"  @if($account['checked'] == 1) checked="checked" @endif > {{ $account['real_name'] or '' }}
                                </label>
                                @endforeach
                            </div>
                            <div class="help-block">可选择多人共同维护，如果没有请到<a href="{{ url('accounts/') }}">帐号管理</a>栏目进行添加。</div>
                        </div>
                        <div class="form-group">
                            <label>产品简介</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <textarea name="pro_input_intro"  class="form-control text-con" placeholder="产品简介">{{ $pro_input_intro or '' }}</textarea>
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
    const SAVE_URL = "{{ url('api/productunit/ajax_save') }}";
    const LIST_URL = "{{url('productunit/')}}";
    // 仅选择日期
    $(".form-date").datetimepicker({
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
        //当前省市区县
        @if ($site_pro_unit_id >0 )
            changeCls({{ $site_pro_unit_id }} ,{{ $site_pro_unit_id_two }});
        @endif
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

        //第一级分类值变动
        $(document).on("change",'select[name=site_pro_unit_id]',function(){
            var obj = $(this);
            var selval = obj.val();
            changeCls(selval,0);
            return false;
        });
    });
</script>
<script src="{{ asset('/js/lanmu/productunit_edit.js') }}"  type="text/javascript"></script>
@endpush
@push('footlast')
@component('component.upfileincludejs')
@endcomponent
@endpush