
//ajax提交表单
function ajax_form(){
    if (!SUBMIT_FORM) return false;//false，则返回
    // 判断是否上传图片
    var uploader = $('#myUploader').data('zui.uploader');
    var files = uploader.getFiles();
    var filesCount = files.length;

    var imgObj = $('#myUploader').closest('.resourceBlock').find(".upload_img")

    if( (!judge_list_checked(imgObj,3)) && filesCount <=0 ) {//没有选中的
        layer_alert('请选择要上传的图片！',3,0);
        return false;
    }

    var audit_status = $('select[name=audit_status]').val();
    if(!judge_validate(4,'审核状态',audit_status,true,'custom',/^[012]$/,'')){
        return false;
    }

    var record_intro = $('textarea[name=record_intro]').val();
    if(!judge_validate(4,'内容',record_intro,true,'length',3,250)){
        return false;
    }

    var created_at = $('input[name=created_at]').val();
    if(!judge_validate(4,'添加日期',created_at,true,'date','','')){
        return false;
    }

    // 上传图片
    if(filesCount > 0){
        var layer_index = layer.load();
        uploader.start();
        var intervalId = setInterval(function(){
            var status = uploader.getState();
            console.log('获取上传队列状态代码',uploader.getState());
            if(status == 1){
                layer.close(layer_index)//手动关闭
                clearInterval(intervalId);
                ajax_save();
            }
        },1000);
    }else{
        ajax_save();
    }
}

// 验证通过后，ajax保存
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