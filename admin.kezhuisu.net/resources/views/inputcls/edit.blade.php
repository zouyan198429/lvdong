@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="tpl-content-page-title">
        编辑生产投入品分类
    </div>

    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 编辑生产投入品分类
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-8">
                    <form class="am-form am-form-horizontal" method="post"  id="addForm">
                        <input type="hidden" name="id" value="{{ $id or 0 }}"/>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">名称</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-name" name="pro_input_name" value="{{ $pro_input_name or '' }}" placeholder="标题">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">排序[降序]</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="pro_input_sort" onkeyup="isnum(this) " onafterpaste="isnum(this)"  value="{{ $pro_input_sort or '' }}" id="user-name" placeholder="可自行设定">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <button  type="button" id="submitBtn"  class="am-btn am-btn-primary">提交</button>
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
<script type="text/javascript">
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

        // 验证信息
        var id = $('input[name=id]').val();
        if(!judge_validate(4,'记录id',id,true,'digit','','')){
            return false;
        }

        var pro_input_name = $('input[name=pro_input_name]').val();
        if(!judge_validate(4,'名称',pro_input_name,true,'length',2,40)){
            return false;
        }

        var pro_input_sort = $('input[name=pro_input_sort]').val();
        if(!judge_validate(4,'排序',pro_input_sort,false,'digit','','')){
            return false;
        }

        // 验证通过
        SUBMIT_FORM = false;//标记为已经提交过
        var data = $("#addForm").serialize();
        console.log("{{ url('api/inputcls/ajax_save') }}");
        console.log(data);
        var layer_index = layer.load();
        $.ajax({
            'type' : 'POST',
            'url' : '{{ url('api/inputcls/ajax_save') }}',
            'data' : data,
            'dataType' : 'json',
            'success' : function(ret){
                console.log(ret);
                if(!ret.apistatus){//失败
                    SUBMIT_FORM = true;//标记为未提交过
                    //alert('失败');
                    err_alert(ret.errorMsg);
                }else{//成功
                    go("{{url('inputcls/')}}");
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