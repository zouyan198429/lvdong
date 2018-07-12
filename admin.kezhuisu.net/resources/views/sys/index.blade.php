@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="tpl-content-page-title">
        系统基本设置
    </div>

    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 系统基本设置
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-8">
                    <form class="am-form am-form-horizontal"  method="post"  id="addForm">
                        @foreach ($dataList as $info)
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">{{ $info['site_name'] }}</label>
                            <div class="am-u-sm-9">
                                <input type="hidden"  name="name{{ $info['id'] }}[]" value="{{ $info['id'] }}">
                                <input type="text" name="name{{ $info['id'] }}[]"  value="{{ $info['site_val'] }}" placeholder="{{ $info['site_name'] }}">
                            </div>
                        </div>
                        @endforeach
                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-2">
                                <button  type="button" id="submitBtn" class="am-btn am-btn-primary">提交</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <div class="tpl-alert"></div>
@endsection

@push('footscripts')

@endpush
@push('footlast')

<script>
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

    });
    //ajax提交表单
    function ajax_form(){
        if (!SUBMIT_FORM) return false;//false，则返回

        ajax_save();
    }
    function ajax_save(){
        // 验证通过
        SUBMIT_FORM = false;//标记为已经提交过
        var data = $("#addForm").serialize();
        console.log("{{ url('api/sys/ajax_save') }}");
        console.log(data);
        var layer_index = layer.load();
        $.ajax({
            'type' : 'POST',
            'url' : '{{ url('api/sys/ajax_save') }}',
            'data' : data,
            'dataType' : 'json',
            'success' : function(ret){
                console.log(ret);
                if(!ret.apistatus){//失败
                    SUBMIT_FORM = true;//标记为未提交过
                    //alert('失败');
                    err_alert(ret.errorMsg);
                }else{//成功
                    go("{{url('sys')}}");
                    // var supplier_id = ret.result['supplier_id'];
                    //if(SUPPLIER_ID_VAL <= 0 && judge_integerpositive(supplier_id)){
                    //    SUPPLIER_ID_VAL = supplier_id;
                    //    $('input[name="supplier_id"]').val(supplier_id);
                    //}
                    // save_success();
                }
                layer.close(layer_index);//手动关闭
            }
        });
        return false;
    }
</script>
@endpush
