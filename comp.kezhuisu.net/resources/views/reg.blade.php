@extends('layouts.login')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('bodyclass') class="bg-primary" @endsection
@section('content')
    <div class="page page-reg text-center">
        <div class="panel">
            <div class="panel-body">
                <div class="logo">
                    <a href="#">企业用户注册</a>
                </div>
                <div class="login-helpers text-left">
                    以下信息均为必填项,帐号必须是手机号
                </div>
                <form action="#" method="post"  id="addForm">
                    <div class="form-group">
                        <input type="text" name="company_mobile" class="form-control" placeholder="手机号">
                    </div>
                    <div class="form-group">
                        <input type="password" name="account_password" class="form-control" placeholder="密码">
                    </div>
                    <div class="form-group">
                        <input type="password" name="sure_password"  class="form-control" placeholder="确认密码">
                    </div>
                    <div class="form-group">
                        <input type="text" name="real_name"  class="form-control" placeholder="真实姓名">
                    </div>
                    <div class="form-group">
                        <input type="text" name="company_name" class="form-control" placeholder="企业名称">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            @include('public.area_select.area_select', ['province_id' => 'province_id','city_id' => 'city_id','area_id' => 'area_id'])

                        </div>
                    </div>
                    <div class="form-group">
                        <input name="company_addr" type="text" class="form-control" placeholder="详细地址">
                    </div>
                    <button type="button"   id="submitBtn" {{--onclick="window.open('{{ url('login') }}')" --}}   class="btn btn-lg btn-primary btn-block">注册</button>
                </form>
                <div class="login-helpers text-left">
                    <br> 已经有账户？ <a href="{{ url('login') }}" >马上登录</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footscripts')
<script>
    var SUBMIT_FORM = true;//防止多次点击提交
    $(function(){
        reset_area_sel(0,1,'');//初始化省
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
        var errStr = judgeParams();
        if( errStr != ''){
            // err_alert('<font color="#000000">' + errStr + '</font>');
            layer_alert('<font color="#000000">' + errStr + '</font>',3,0);
            return false;
        }
        // 验证通过
        SUBMIT_FORM = false;//标记为已经提交过
        var data = $("#addForm").serialize();
        var layer_index = layer.load();
        $.ajax({
            'type' : 'POST',
            'url' : '{{ url('api/accounts/ajax_reg') }}',
            'data' : data,
            'dataType' : 'json',
            'success' : function(ret){
                if(!ret.apistatus){//失败
                    SUBMIT_FORM = true;//标记为未提交过
                    //alert('失败');
                    err_alert('<font color="#000000">' + ret.errorMsg + '</font>');
                }else{//成功
                    var index_query =layer.confirm('<font color="#000000">恭喜您，注册成功!</font>', {
                        btn: ['登陆'] //按钮
                    }, function(){//返回列表
                        go("{{url('login')}}");
                        layer.close(index_query);
                    });
                    // go("{{url('login')}}");
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

    // 返回''：通过，字符串为：错误信息
    function judgeParams(){
        // 验证信息
        var company_mobile = $('input[name=company_mobile]').val();
        var judgeResult = judge_validate(1,'手机号',company_mobile,true,'mobile','','');
        if(judgeResult != ''){
            return judgeResult;
        }

        var account_password = $('input[name=account_password]').val();
        var judgeResult = judge_validate(1,'密码',account_password,true,'length',6,20);
        if(judgeResult != ''){
            return judgeResult;
        }
        var sure_password = $('input[name=sure_password]').val();
        var judgeResult = judge_validate(4,'确认密码',sure_password,true,'length',6,20);
        // if(judgeResult != ''){
        //    return judgeResult;
        // }

        if(account_password !== sure_password){
            judgeResult = '确认密码和密码不一致！';
            return judgeResult;
        }

        var real_name = $('input[name=real_name]').val();
        var judgeResult = judge_validate(1,'真实姓名',real_name,true,'length',1,30);
        if(judgeResult != ''){
            return judgeResult;
        }

        var company_name = $('input[name=company_name]').val();
        var judgeResult = judge_validate(1,'企业名称',company_name,true,'length',1,40);
        if(judgeResult != ''){
            return judgeResult;
        }

        var province_id = $('select[name=province_id]').val();
        if(province_id == ''){
            return '请选择省';
        }

        var city_id = $('select[name=city_id]').val();
        if(city_id == ''){
            return '请选择市';
        }


        var company_addr = $('input[name=company_addr]').val();
        var judgeResult = judge_validate(1,'company_addr',company_addr,true,'length',1,80);
        if(judgeResult != ''){
            return judgeResult;
        }
        return '';
    }
</script>
@endpush