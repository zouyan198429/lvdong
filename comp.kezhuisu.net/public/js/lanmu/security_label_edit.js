
//ajax提交表单
function ajax_form(){
    if (!SUBMIT_FORM) return false;//false，则返回
    // 验证信息
    var pro_unit_id = $('input[name=pro_unit_id]').val();
    if(!judge_validate(4,'生产单元id',pro_unit_id,true,'digit','','')){
        return false;
    }

    var id = $('input[name=id]').val();
    if(!judge_validate(4,'生产记录id',id,true,'digit','','')){
        return false;
    }

    var status = $('select[name=status]').val();
    var err_msg = judge_validate(1,'状态',status,true,'digit','','');
    if(!judge_empty(err_msg)){//值正确,有权限
        err_alert('请选择状态！');
        return false;
    }
    var security_label_num = '';
    var max_len = 3500 ;
    if( id <= 0 ){
        security_label_num = $('textarea[name=security_label_num]').val();
    }else{
        security_label_num = $('input[name=security_label_num]').val();
        max_len = 30 ;
    }
    if(!judge_validate(4,'防伪标签',security_label_num,true,'length',10,max_len)){
        return false;
    }

    ajax_save();
}
function ajax_save(){
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