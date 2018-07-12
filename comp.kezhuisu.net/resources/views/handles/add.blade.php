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
                            <label>是否主节点</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="switch">
                                        <input name="is_node" value="1" type="checkbox"  value="1"  @if(($is_node == 1) or 0) checked="checked" @endif>
                                        <label>主节点</label>
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
                        <button  type="button" id="submitBtn"  class="btn btn-primary">提交</button>
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

    //ajax提交表单
    function ajax_form(){
        if (!SUBMIT_FORM) return false;//false，则返回
        // 判断是否上传图片
        var uploader = $('#myUploader').data('zui.uploader');
        var files = uploader.getFiles();
        var filesCount = files.length;

        var imgObj = $('#myUploader').closest('.resourceBlock').find(".upload_img")

        if( (!judge_list_checked(imgObj,3)) && filesCount <=0 ) {//没有选中的
            layer_alert('请选择要上传的图片！',3,0);
            return false;
        }

        var record_intro = $('textarea[name=record_intro]').val();
        if(!judge_validate(4,'内容',record_intro,true,'length',3,250)){
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

    // 验证通过后，ajax保存
    function ajax_save(){
        // 验证通过
        SUBMIT_FORM = false;//标记为已经提交过
        var data = $("#addForm").serialize();

        console.log("{{ url('api/handles/' . $pro_unit_id . '/ajax_save') }}");
        console.log(data);
        var layer_index = layer.load();
        $.ajax({
            'type' : 'POST',
            'url' : '{{ url('api/handles/' . $pro_unit_id . '/ajax_save') }}',
            'data' : data,
            'dataType' : 'json',
            'success' : function(ret){
                console.log(ret);
                if(!ret.apistatus){//失败
                    SUBMIT_FORM = true;//标记为未提交过
                    //alert('失败');
                    err_alert(ret.errorMsg);
                }else{//成功
                    go("{{url('handles/' . $pro_unit_id)}}");
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