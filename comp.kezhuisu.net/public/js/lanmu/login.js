

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
    console.log(LOGIN_URL);
    console.log(data);
    var layer_index = layer.load();
    $.ajax({
        'type' : 'POST',
        'url' : LOGIN_URL,
        'data' : data,
        'dataType' : 'json',
        'success' : function(ret){
            if(!ret.apistatus){//失败
                SUBMIT_FORM = true;//标记为未提交过
                //alert('失败');
                err_alert('<font color="#000000">' + ret.errorMsg + '</font>');
            }else{//成功
                go(INDEX_URL);
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