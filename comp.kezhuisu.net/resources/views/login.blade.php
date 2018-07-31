@extends('layouts.login')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('bodyclass') class="bg-primary" @endsection

@section('content')
    <div class="page page-login text-center">
        <div class="panel">
            <div class="panel-body">
                <div class="logo">
                    <a href="#">农产品质量可追溯营销系统</a>
                </div>
                <form action="#"  method="post"  id="addForm" >
                    <div class="form-group">
                        <input type="text" name="account_username" class="form-control" placeholder="帐号/手机号">
                    </div>
                    <div class="form-group">
                        <input type="password"  name="account_password"  class="form-control" placeholder="密码">
                    </div>
                    <div class="form-group" style="display:none;">
                        <input type="text" class="form-control" placeholder="验证码">
                    </div>
                    <button type="button"  id="submitBtn" {{--onclick="window.open('{{ url('/') }}')"--}}   class="btn btn-lg btn-primary btn-block">登录</button>
                </form>
                <div class="login-helpers text-left">
                    <br/> 没有账户？ <a href="{{ url('reg') }}" >马上注册</a>
                </div>
            </div>
        </div>
    <footer class="page-copyright page-copyright-inverse text-center">
        <p>杨凌沃太农业咨询有限公司</p>
        <p>© 2018. All RIGHT RESERVED.</p>
    </footer>
    </div>
@endsection


@push('footscripts')

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

    })

    //ajax提交表单
    function ajax_form(){
        if (!SUBMIT_FORM) return false;//false，则返回
        // 验证信息
        var account_username = $('input[name=account_username]').val();
        var judgeuser =judge_validate(1,'用户名',account_username,true,'length',6,20);
        if(judgeuser != ''){
            err_alert('<font color="#000000">' + judgeuser + '</font>');
            return false;
        }
        var account_password = $('input[name=account_password]').val();
        var judgePassword = judge_validate(1,'密码',account_password,true,'length',6,20);
        if(judgePassword != ''){
            err_alert('<font color="#000000">' + judgePassword + '</font>');
            return false;
        }
        // 验证通过
        SUBMIT_FORM = false;//标记为已经提交过
        var data = $("#addForm").serialize();
        console.log('{{ url('api/accounts/ajax_login') }}');
        console.log(data);
        var layer_index = layer.load();
        $.ajax({
            'type' : 'POST',
            'url' : '{{ url('api/accounts/ajax_login') }}',
            'data' : data,
            'dataType' : 'json',
            'success' : function(ret){
                if(!ret.apistatus){//失败
                    SUBMIT_FORM = true;//标记为未提交过
                    //alert('失败');
                    err_alert('<font color="#000000">' + ret.errorMsg + '</font>');
                }else{//成功
                    go("{{url('/')}}");
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