@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
<!-- 本页单独使用 -->
<link href="{{asset('dist/lib/datetimepicker/datetimepicker.min.css')}}" rel="stylesheet">
<script src="{{asset('dist/lib/datetimepicker/datetimepicker.min.js')}}"></script>
@endpush

@section('content')
    <div class="content-header">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="icon icon-home"></i></a></li>
            <li><a href="{{ url('accounts/') }}">帐号管理</a></li>
            <li class="active">增加新帐号</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">增加新帐号</div>
                </div>
                <div class="panel-body">
                    <form method="post"  id="addForm">
                        <input type="hidden" name="id" value="{{ $id or 0 }}"/>
                        <div class="form-group">
                            <label><span class="red">*</span> 手机号</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input name="mobile" value="{{ $mobile or '' }}" type="text" class="form-control" placeholder="请填写手机号">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><span class="red">*</span> 用户名</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input name="account_username" value="{{ $account_username or '' }}" type="text" class="form-control" placeholder="请输入用户名">
                                </div>
                            </div>
                            <div class="help-block">字母加数字，不超过20个字符。</div>
                        </div>
                        @if ($id <= 0 )
                        <div class="form-group">
                            <label><span class="red">*</span> 密码</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input name="account_password" type="password" class="form-control" placeholder="请输入密码">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><span class="red">*</span> 确认密码</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input name="sure_password" type="password" class="form-control" placeholder="现次输入密码">
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label>微信号</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input name="wx_account" value="{{ $wx_account or '' }}"  type="text" class="form-control" placeholder="请填写微信号">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>真实姓名</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input name="real_name" value="{{ $real_name or '' }}" type="text" class="form-control" placeholder="请填写真实姓名">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>状态</label>
                            <div class="row">
                                <div class="col-xs-3">
                                    <select name="account_status" class="form-control">
                                        <option value="">请选择类别</option>
                                        <option value="0" @if($account_status == 0) selected @endif>正常</option>
                                        @if($account_issuper == 0)
                                        <option value="1"  @if($account_status == 1) selected @endif>冻结</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>备注</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <textarea name="remarks" class="form-control text-con" placeholder="备注内容">{{ $remarks or '' }}</textarea>
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
        var id = $('input[name=id]').val();
        if(!judge_validate(4,'用户id',id,true,'digit','','')){
            return false;
        }
        var account_username = $('input[name=account_username]').val();
        if(!judge_validate(4,'用户名',account_username,true,'length',6,20)){
            return false;
        }
        @if ($id <= 0 )
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
        @endif
        var wx_account = $('input[name=wx_account]').val();
        if(!judge_validate(4,'微信号',wx_account,false,'length',3,30)){
            return false;
        }
        var real_name = $('input[name=real_name]').val();
        if(!judge_validate(4,'真实姓名',real_name,true,'length',1,30)){
            return false;
        }
        var mobile = $('input[name=mobile]').val();
        if(!judge_validate(4,'手机号',mobile,true,'mobile','','')){
            return false;
        }
        var account_status = $('select[name=account_status]').val();
        if(!judge_validate(4,'状态',account_status,true,'custom',/^[01]$/,'')){
            return false;
        }
        var remarks = $('textarea[name=remarks]').val();
        if(!judge_validate(4,'备注',remarks,false,'length',3,250)){
            return false;
        }
        // 验证通过
            SUBMIT_FORM = false;//标记为已经提交过
            var data = $("#addForm").serialize();
            console.log("{{ url('api/accounts/ajax_save') }}");
            console.log(data);
            var layer_index = layer.load();
            $.ajax({
                'type' : 'POST',
                'url' : '{{ url('api/accounts/ajax_save') }}',
                'data' : data,
                'dataType' : 'json',
                'success' : function(ret){
                    console.log(ret);
                    if(!ret.apistatus){//失败
                        SUBMIT_FORM = true;//标记为未提交过
                        //alert('失败');
                        err_alert(ret.errorMsg);
                    }else{//成功
                        go("{{url('accounts/')}}");
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