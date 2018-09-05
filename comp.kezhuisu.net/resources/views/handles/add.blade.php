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
            <li><a href="{{ url('handles/' . $pro_unit_id) }}">农事记录</a></li>
            <li class="active">添加日志</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">添加日志</div>
                </div>
                <div class="panel-body">
                    <div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <p>一次最多上传9张图片。</p>
                    </div>
                    <form method="post"  id="addForm">
                        <input type="hidden" name="id" value="{{ $id or 0 }}"/>
                        <div class="form-group">
                            <label>上传图片</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    @component('component.upfileone.piconecode')
                                    @slot('fileList')
                                    grid
                                    @endslot
                                    @endcomponent
                                    {{--
                                    <input type="file" class="form-control" value="">
                                    --}}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>是否显示</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="switch">
                                        <input name="is_node" value="1" type="checkbox"  value="1"  @if(($is_node == 1) or 0) checked="checked" @endif>
                                        <label>显示</label>
                                    </div>
                                </div>
                            </div>
                            <div class="help-block">不超过250字为宜</div>
                        </div>

                        <div class="form-group">
                            <label>内容</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <textarea  name="record_intro" class="form-control text-con" style="height:10em" placeholder="请输入内容">{{ $record_intro or '' }}</textarea>
                                </div>
                            </div>
                            <div class="help-block">不超过250字为宜</div>
                        </div>

                        <div class="form-group">
                            <label><span class="red">*</span> 添加日期</label>
                            <div class="row">
                                <div class="col-xs-3">
                                    <input type="text" name="created_at" value="{{ $created_at or '' }}"  class="form-control form-date" placeholder="选择或者输入一个日期：yyyy-MM">
                                </div>
                            </div>
                            <div class="help-block"></div>
                        </div>
                        <button  type="button" id="submitBtn"  class="btn btn-primary">提交</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('footscripts')

<script>
    const SAVE_URL = "{{ url('api/handles/' . $pro_unit_id . '/ajax_save') }}";
    const LIST_URL = "{{url('handles/' . $pro_unit_id)}}";
    // 仅选择日期
    $(".form-date").datetimepicker(
            {
                language:  "zh-CN",
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 0,
                minuteStep:1,
                forceParse: 0,
                format: "yyyy-mm-dd hh:ii:ss"
            });


    var SUBMIT_FORM = true;//防止多次点击提交
    $(function(){
        // 九张图片上传
        @include('component.upfileone.piconejsinitincludenine')
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

    });

</script>
<script src="{{ asset('/js/lanmu/handles_edit.js') }}"  type="text/javascript"></script>
@endpush
@push('footlast')
    @component('component.upfileincludejs')
    @endcomponent
@endpush