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
            <li><a href="{{ url('security_label/' . $pro_unit_id) }}">防伪标签</a></li>
            <li class="active">添加防伪标签</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">添加防伪标签</div>
                </div>
                <div class="panel-body">

                    <form  method="post"  id="addForm">
                        <input type="hidden" name="id" value="{{ $id or 0 }}"/>
                        <input type="hidden" name="pro_unit_id" value="{{ $pro_unit_id or 0 }}"/>
                        <div class="form-group" style="display: none;">
                            <label>状态</label>
                            <div class="row">
                                <div class="col-xs-3">
                                    <select  name="status"  class="form-control">
                                        <option value="0" selected>请选择类别</option>
                                        <option value="0"  @if($status == 0) selected @endif>未使用</option>
                                        <option value="1"  @if($status == 1) selected @endif>已使用</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>防伪标签</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    @if ( $id <= 0)
                                        <textarea name="security_label_num" rows="20"  class="form-control text-con" placeholder="请输入防伪标签;多个换行，一行一个，最多100个。">{{ $security_label_num or '' }}</textarea>
                                    @else
                                        <input type="text"  name="security_label_num" value="{{ $security_label_num or '' }}" class="form-control" placeholder="请输入防伪标签">
                                    @endif
                                </div>
                            </div>
                            @if ( $id <= 0)
                            <div class="help-block">单个防伪标签10-30个字符;多个换行，一行一个，最多100个。</div>
                            @endif
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
    const SAVE_URL = "{{ url('api/security_label/ajax_save') }}";
    const LIST_URL = "{{url('security_label/' . $pro_unit_id . '/')}}";
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
<script src="{{ asset('/js/lanmu/security_label_edit.js') }}"  type="text/javascript"></script>
@endpush
@push('footlast')
@component('component.upfileincludejs')
@endcomponent
@endpush