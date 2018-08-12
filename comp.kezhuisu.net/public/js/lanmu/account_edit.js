
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
        if (RECORD_ID <= 0 ){
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
        }
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
    console.log(SAVE_URL);
    console.log(data);
    var layer_index = layer.load();
    $.ajax({
        'type' : 'POST',
        'url' : SAVE_URL,
        'data' : data,
        'dataType' : 'json',
        'success' : function(ret){
            console.log(ret);
            if(!ret.apistatus){//失败
                SUBMIT_FORM = true;//标记为未提交过
                //alert('失败');
                err_alert(ret.errorMsg);
            }else{//成功
                go(LIST_URL);
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