@extends('layouts.app')

@push('headscripts')
    {{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="content-header">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="icon icon-home"></i></a></li>
            <li class="active">检测报告</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">检测报告</div>
                </div>
                <div class="panel-body">
                    <div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <p>一次最多上传9张图片。</p>
                    </div>
                    <form method="post"  id="addForm">
                        <input type="hidden" name="id" value="{{ $id or 0 }}"/>
                        {{--上传图片--}}
                        @component('component.upfileone.piconecode')
                        @slot('fileList')
                        grid
                        @endslot
                        @endcomponent
                        {{--
                        <div id="uploaderExample" class="uploader">
                            <div class="file-list" data-drag-placeholder="请拖拽文件到此处"></div>
                            <button type="button" class="btn btn-primary uploader-btn-browse"><i class="icon icon-cloud-upload"></i> 选择文件</button>

                        </div>
                        --}}
                    </form>
                    <div class="cards">
                        @foreach ($reportsList as $report)
                        <div class="col-md-3 col-sm-4 col-lg-2 text-center">
                            <div class="text-center">
                                <img data-toggle="lightbox"  src="{{ $report['site_resources'][0]['resource_url'] or '' }}" alt="">
                                <p><a href="#" class="del" data-id="{{ $report['id'] }}"><i class="icon icon-times"></i></a></p>
                            </div>
                        </div>
                        @endforeach

                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection


@push('footscripts')
<script>
    $(function(){
        // 九张图片上传
        @include('component.upfileone.piconejsinitincludenine',[
            'uploadComplete' => 'uploadComplete();',
        ])
        // 一张图片上传
        {{--@component('component.upfileone.piconejsinitincludeone')--}}
        {{--@slot('uploadComplete')--}}
        {{--uploadComplete();--}}
        {{--@endslot--}}
        {{--@slot('site_resources')--}}
        {{--[]--}}
        {{--@endslot--}}
        {{--@endcomponent--}}
        //提交
        $(document).on("click",".del",function(){
            var id = $(this).data("id");
            var index_query = layer.confirm('您确定删除吗？不可恢复!', {
                btn: ['确定','取消'] //按钮
            }, function(){
                ajax_form(id);
                layer.close(index_query);
            }, function(){
            });
            return false;
        })
    });

    // 上传完后回调
    function uploadComplete(){
        // 判断是否上传图片
        var uploader = $('#myUploader').data('zui.uploader');
        var files = uploader.getFiles();
        var filesCount = files.length;

        var imgObj = $('#myUploader').closest('.resourceBlock').find(".upload_img")

        if( (!judge_list_checked(imgObj,3)) && filesCount <=0 ) {//没有选中的
            layer_alert('请选择要上传的图片！',3,0);
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

        console.log("{{ url('api/report/' . $pro_unit_id . '/ajax_save') }}");
        console.log(data);
        var layer_index = layer.load();
        $.ajax({
            'type' : 'POST',
            'url' : '{{ url('api/report/' . $pro_unit_id . '/ajax_save') }}',
            'data' : data,
            'dataType' : 'json',
            'success' : function(ret){
                console.log(ret);
                if(!ret.apistatus){//失败
                    SUBMIT_FORM = true;//标记为未提交过
                    //alert('失败');
                    err_alert(ret.errorMsg);
                }else{//成功
                    go("{{url('report/' . $pro_unit_id . '/')}}");
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
    //ajax提交表单
    function ajax_form(id){
        var data = {'id':id,'pro_unit_id':'{{ $pro_unit_id }}'};
        console.log("{{ url('api/report/ajax_del') }}");
        console.log(data);
        var layer_index = layer.load();
        $.ajax({
            'type' : 'POST',
            'url' : '{{ url('api/report/ajax_del') }}',
            'data' : data,
            'dataType' : 'json',
            'success' : function(ret){
                console.log(ret);
                if(!ret.apistatus){//失败
                    //alert('失败');
                    err_alert(ret.errorMsg);
                }else{//成功
                    go("{{url('report/' . $pro_unit_id)}}");
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