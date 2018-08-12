
// 上传完后回调
function uploadComplete(){
    // 判断是否上传图片
    var uploader = $('#myUploader').data('zui.uploader');
    var files = uploader.getFiles();
    var filesCount = files.length;

    var imgObj = $('#myUploader').closest('.resourceBlock').find(".upload_img")

    if( (!judge_list_checked(imgObj,3)) && filesCount <=0 ) {//没有选中的
        layer_alert('请选择要上传的图片！',3,0);
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
                ajax_img_save();
            }
        },1000);
    }else{
        ajax_img_save();
    }
}

// 验证通过后，ajax保存
function ajax_img_save(){
    // 验证通过
    SUBMIT_FORM = false;//标记为已经提交过
    var data = $("#addFormfile").serialize();

    console.log(PIC_SAVE_URL);
    console.log(data);
    var layer_index = layer.load();
    $.ajax({
        'type' : 'POST',
        'url' : PIC_SAVE_URL,
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
    });
    return false;
}

//ajax提交表单
function ajax_form1(){
    if (!SUBMIT_FORM) return false;//false，则返回

    var company_name = $('input[name=company_name]').val();
    if(!judge_validate(4,'企业全称',company_name,true,'length',2,40)){
        return false;
    }

    var company_simple_name = $('input[name=company_simple_name]').val();
    if(!judge_validate(4,'企业简称',company_simple_name,false,'length',2,30)){
        return false;
    }

    var company_addr = $('input[name=company_addr]').val();
    if(!judge_validate(4,'公司地址',company_addr,false,'length',2,60)){
        return false;
    }

    var product_addr = $('input[name=product_addr]').val();
    if(!judge_validate(4,'生产地址',product_addr,false,'length',2,60)){
        return false;
    }

    var company_mainproduct = $('textarea[name=company_mainproduct]').val();
    if(!judge_validate(4,'主营项目',company_mainproduct,false,'length',2,1000)){
        return false;
    }

    var ccredit_code = $('input[name=ccredit_code]').val();
    if(!judge_validate(4,'统一社会信用代码',ccredit_code,false,'length',2,50)){
        return false;
    }


    var company_createtime = $('input[name=company_createtime]').val();
    if(!judge_validate(4,'成立时间',company_createtime,true,'date','','')){
        return false;
    }

    var reg_capital = $('input[name=reg_capital]').val();
    if(!judge_validate(4,'注册资金',reg_capital,false,'length',3,50)){
        return false;
    }

    var legal_name = $('input[name=legal_name]').val();
    if(!judge_validate(4,'法定代表人',legal_name,false,'length',3,50)){
        return false;
    }

    var contact_way = $('textarea[name=contact_way]').val();
    if(!judge_validate(4,'联系方式',contact_way,false,'length',3,250)){
        return false;
    }

    // 验证通过
    SUBMIT_FORM = false;//标记为已经提交过
    var data = $("#addForm1").serialize();
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
//ajax提交表单
function ajax_form2(){
    if (!SUBMIT_FORM) return false;//false，则返回

    var company_intro = $('textarea[name=company_intro]').val();
    if(!judge_validate(4,'公司简介',company_intro,false,'length',2,500)){
        return false;
    }

    // 验证通过
    SUBMIT_FORM = false;//标记为已经提交过
    var data = $("#addForm2").serialize();
    console.log(INTRO_SAVE_URL);
    console.log(data);
    var layer_index = layer.load();
    $.ajax({
        'type' : 'POST',
        'url' : INTRO_SAVE_URL,
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