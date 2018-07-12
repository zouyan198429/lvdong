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
                            <label>类别</label>
                            <div class="row">
                                <div class="col-xs-3">
                                    <select  name="site_input_id"  class="form-control">
                                        <option value="">请选择类别</option>
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
                            <label>产品全称</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text"  name="pro_input_name" value="{{ $pro_input_name or '' }}" class="form-control" placeholder="请输入产品名称">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>品种/品牌</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" name="pro_input_brand" value="{{ $pro_input_brand or '' }}" class="form-control" placeholder="请输入品种/品牌">
                                </div>
                            </div>
                            <div class="help-block">如：红富士</div>
                        </div>
                        <div class="form-group">
                            <label>生产厂家</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text"  name="pro_input_factory" value="{{ $pro_input_factory or '' }}" class="form-control" placeholder="请输入生产厂家">
                                </div>
                            </div>
                            <div class="help-block">如：红富士</div>
                        </div>
                        <div class="form-group">
                            <label>产品简介</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <textarea name="pro_input_intro"  class="form-control text-con" placeholder="请输入关站描述">{{ $pro_input_intro or '' }}</textarea>
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
    //ajax提交表单
    function ajax_form(){
        if (!SUBMIT_FORM) return false;//false，则返回
        // 验证信息
        var pro_unit_id = $('input[name=pro_unit_id]').val();
        if(!judge_validate(4,'生产记录类别id',pro_unit_id,true,'digit','','')){
            return false;
        }

        var id = $('input[name=id]').val();
        if(!judge_validate(4,'生产记录id',id,true,'digit','','')){
            return false;
        }

        var site_input_id = $('select[name=site_input_id]').val();
        if(!judge_validate(4,'类别',site_input_id,true,'digit','','')){
            return false;
        }


        // 判断是否上传图片
        var uploader = $('#myUploader').data('zui.uploader');
        var files = uploader.getFiles();
        var filesCount = files.length;

        var imgObj = $('#myUploader').closest('.resourceBlock').find(".upload_img")

        if( (!judge_list_checked(imgObj,3)) && filesCount <=0 ) {//没有选中的
            layer_alert('请选择要上传的图片！',3,0);
            return false;
        }


        var pro_input_name = $('input[name=pro_input_name]').val();
        if(!judge_validate(4,'产品全称',pro_input_name,true,'length',2,40)){
            return false;
        }

        var pro_input_brand = $('input[name=pro_input_brand]').val();
        if(!judge_validate(4,'品种/品牌',pro_input_brand,true,'length',2,20)){
            return false;
        }

        var pro_input_factory = $('input[name=pro_input_factory]').val();
        if(!judge_validate(4,'生产厂家',pro_input_factory,true,'length',2,30)){
            return false;
        }


        var pro_input_intro = $('textarea[name=pro_input_intro]').val();
        if(!judge_validate(4,'备注',pro_input_intro,false,'length',3,250)){
            return false;
        }


        // 上传图片
        if(filesCount > 0){
            var layer_index = layer.load();
            uploader.start();
            var intervalId = setInterval(function(){
                var status = uploader.getState();
                console.log('获取上传队列状态代码',uploader.getState());
                if(status == 1){
                    layer.close(layer_index)//手动关闭
                    clearInterval(intervalId);
                    ajax_save();
                }
            },1000);
        }else{
            ajax_save();
        }
    }
    function ajax_save(){
        // 验证通过
        SUBMIT_FORM = false;//标记为已经提交过
        var data = $("#addForm").serialize();
        console.log("{{ url('api/inputs/ajax_save') }}");
        console.log(data);
        var layer_index = layer.load();
        $.ajax({
            'type' : 'POST',
            'url' : '{{ url('api/inputs/ajax_save') }}',
            'data' : data,
            'dataType' : 'json',
            'success' : function(ret){
                console.log(ret);
                if(!ret.apistatus){//失败
                    SUBMIT_FORM = true;//标记为未提交过
                    //alert('失败');
                    err_alert(ret.errorMsg);
                }else{//成功
                    go("{{url('inputs/' . $pro_unit_id . '/')}}");
                    // var supplier_id = ret.result['supplier_id'];
                    //if(SUPPLIER_ID_VAL <= 0 && judge_integerpositive(supplier_id)){
                    //    SUPPLIER_ID_VAL = supplier_id;
                    //    $('input[name="supplier_id"]').val(supplier_id);
                    //}
                    // save_success();
                }
                layer.close(layer_index)//手动关闭
            }
        })
        return false;
    }
</script>
@endpush
@push('footlast')
@component('component.upfileincludejs')
@endcomponent
@endpush