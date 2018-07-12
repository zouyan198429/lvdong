@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="tpl-content-page-title">
        管理员
    </div>

    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 管理员列表
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-9">
                    <form class="am-form am-form-horizontal" method="post"  id="addForm">
                        <input type="hidden" name="id" value="{{ $id or 0 }}"/>
                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">类别</label>
                            <div class="am-u-sm-9">
                                <select name="admin_type">
                                    @foreach ($admin_types as $k=>$type)
                                    <option value="{{ $k }}"  @if(isset($admin_type) && $admin_type == $k) selected @endif >{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">用户名</label>
                            <div class="am-u-sm-9">
                                <input type="text"  name="admin_username" value="{{ $admin_username or '' }}" placeholder="帐户名">
                                <small>主要用于登录</small>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">登录密码</label>
                            <div class="am-u-sm-9">
                                <input type="password"   name="admin_password" placeholder="登录密码">
                                <small>6-12位，</small>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">确认密码</label>
                            <div class="am-u-sm-9">
                                <input type="password"  name="sure_password"  placeholder="登录密码">
                                <small>再输入一次</small>
                            </div>
                        </div>



                        <div class="am-form-group">
                            <label for="user-QQ" class="am-u-sm-3 am-form-label">真实姓名</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-QQ" name="real_name" value="{{ $real_name or '' }}" placeholder="输入真实姓名">
                            </div>
                        </div>


                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
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

        var admin_type = $('select[name=admin_type]').val();
        if(!judge_validate(4,'类别',admin_type,true,'digit','','')){
            return false;
        }

        var admin_username = $('input[name=admin_username]').val();
        if(!judge_validate(4,'用户名',admin_username,true,'length',6,20)){
            return false;
        }

        var admin_password = $('input[name=admin_password]').val();
        var sure_password = $('input[name=sure_password]').val();
        if(admin_password != '' || sure_password != ''){
            if(!judge_validate(4,'密码',admin_password,true,'length',6,20)){
                return false;
            }
            // if(!judge_validate(4,'确认密码',sure_password,true,'length',6,20)){
            //    return false;
            // }

            if(admin_password !== sure_password){
                layer_alert('确认密码和密码不一致！',5,0);
                return false;
            }
        }

        var real_name = $('input[name=real_name]').val();
        if(!judge_validate(4,'真实姓名',real_name,false,'length',1,20)){
            return false;
        }

        // 验证通过
        SUBMIT_FORM = false;//标记为已经提交过
        var data = $("#addForm").serialize();
        console.log("{{ url('api/admin/ajax_save') }}");
        console.log(data);
        var layer_index = layer.load();
        $.ajax({
            'type' : 'POST',
            'url' : '{{ url('api/admin/ajax_save') }}',
            'data' : data,
            'dataType' : 'json',
            'success' : function(ret){
                console.log(ret);
                if(!ret.apistatus){//失败
                    SUBMIT_FORM = true;//标记为未提交过
                    //alert('失败');
                    err_alert(ret.errorMsg);
                }else{//成功
                    go("{{url('admin/')}}");
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