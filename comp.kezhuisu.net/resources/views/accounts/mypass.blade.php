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
            <li><a href="{{ url('accounts/') }}">帐号管理</a></li>
            <li class="active">修改密码</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">修改密码</div>
                </div>
                <div class="panel-body">
                    <form  method="post"  id="addForm">
                        <div class="form-group">
                            <label>密码</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input name="account_password"  type="password" class="form-control" placeholder="请输入密码">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>确认密码</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input  name="sure_password"  type="password" class="form-control" placeholder="现次输入密码">
                                </div>
                            </div>
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

        var account_password = $('input[name=account_password]').val();
        if(!judge_validate(4,'密码',account_password,true,'length',6,20)){
            return false;
        }
        var sure_password = $('input[name=sure_password]').val();
        // if(!judge_validate(4,'确认密码',sure_password,true,'length',6,20)){
        //    return false;
        // }

        if(account_password !== sure_password){
            layer_alert('确认密码和密码不一致！',5,0);
            return false;
        }

        // 验证通过
        SUBMIT_FORM = false;//标记为已经提交过
        var data = $("#addForm").serialize();
        console.log("{{ url('api/accounts/ajax_password_save') }}");
        console.log(data);
        var layer_index = layer.load();
        $.ajax({
            'type' : 'POST',
            'url' : '{{ url('api/accounts/ajax_password_save') }}',
            'data' : data,
            'dataType' : 'json',
            'success' : function(ret){
                console.log(ret);
                if(!ret.apistatus){//失败
                    SUBMIT_FORM = true;//标记为未提交过
                    //alert('失败');
                    err_alert(ret.errorMsg);
                }else{//成功
                    layer_alert('修改密码成功！',1,0);
                    // go("{{url('accounts/mypass')}}");
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