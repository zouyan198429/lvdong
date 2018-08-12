
function judgeModifMenu(){
    var addObj = $('.menu_add');
    // 是否显示
    var menu_is_show = 0;
    if(addObj.find('input[name=menu_is_show]').is(':checked')) {
        menu_is_show = 1;
    }

    var id = addObj.find('input[name=menu_id]').val();
    var menu_name = addObj.find('input[name=menu_name]').val();
    var menu_url = addObj.find('input[name=menu_url]').val();
    // var resource_id = addObj.find('input[name=resource_id]').val();

    // 验证数据
    if(!judge_validate(4,'ID',id,true,'digit','','')){
        return false;
    }

    if(!judge_validate(4,'导航名称',menu_name,true,'length',2,20)){
        return false;
    }

    // 判断是否上传图片
    var uploader = $('#menuUploader').data('zui.uploader');
    var files = uploader.getFiles();
    var filesCount = files.length;

    var imgObj = $('#menuUploader').closest('.resourceBlock').find(".upload_img")

    // if( (!judge_list_checked(imgObj,3)) && filesCount <=0 ) {//没有选中的
    //    layer_alert('请选择要上传的图片！',3,0);
    //   return false;
    //}

    if(!judge_validate(4,'链接地址',menu_url,true,'length',2,100)){
        return false;
    }

    if(!judge_validate(4,'是否显示',menu_is_show,true,'custom',/^[01]$/,'')){
        return false;
    }

    //保存
    var data = {
        'id':id,
        'menu_name':menu_name,
        'menu_url':menu_url,
        'menu_is_show':menu_is_show,
        'resource_id':0
    };

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
                menu_ajax_save(data);
            }
        },1000);
    }else{
        menu_ajax_save(data);
    }
    return false;
}
// 保存/修改菜单
function menu_ajax_save(data){
    var layer_index = layer.load();
    // 获得图片资源id
    var selImgObj = $('#menuUploader').closest('.resourceBlock').find(".upload_img");
    console.log('开始判断数量',selImgObj);
    console.log('selImgObj.length',selImgObj.length);
    var checkvalues = get_list_checked(selImgObj,3,1);
    console.log('已经上传的值ids值', checkvalues);
    var checkedCount = 0;
    if(checkvalues == '') {
        //layer_alert('请选择要上传的图片！',0,0);
        //return false
    }else{
        data.resource_id = checkvalues;
        //var checked_ids_arr = checkvalues.split(',');
        //console.log('已经上传的记录', checked_ids_arr);
        //var checkedCount = checked_ids_arr.length;
    }
    console.log(MENU_SAVE_URL);
    console.log(data);
    $.ajax({
        'type' : 'POST',
        'url' : MENU_SAVE_URL,
        'data' : data,
        'dataType' : 'json',
        'success' : function(ret){
            console.log(ret);
            if(!ret.apistatus){//失败
                //alert('失败');
                err_alert(ret.errorMsg);
            }else{//成功
                // layer_alert('操作成功！',1,0);
                go(LIST_URL);
                // var supplier_id = ret.result['supplier_id'];
                //if(SUPPLIER_ID_VAL <= 0 && judge_integerpositive(supplier_id)){
                //    SUPPLIER_ID_VAL = supplier_id;
                //    $('input[name="supplier_id"]').val(supplier_id);
                //}
                // save_success();
            }
            layer.close(layer_index);//手动关闭
        }
    });
}
// 打开web菜单是否显示
function ajax_open_menu(id,menu_is_show){
    var data = {'id':id,'menu_is_show':menu_is_show};
    console.log(IS_SHOW_SAVE_URL);
    console.log(data);
    var layer_index = layer.load();
    $.ajax({
        'type' : 'POST',
        'url' : IS_SHOW_SAVE_URL,
        'data' : data,
        'dataType' : 'json',
        'success' : function(ret){
            console.log(ret);
            if(!ret.apistatus){//失败
                //alert('失败');
                err_alert(ret.errorMsg);
            }else{//成功
                layer_alert('更新成功！',1,0);
                // go(LIST_URL);
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
function open_url(id){
    var openUrl = SHOW_URL + '?temid=' + id;
    window.open(openUrl);
    return false;
}


//ajax提交表单-应用
function ajax_apply(temp_id){
    var data = {'id':RECORD_ID,'temp_id':temp_id};
    console.log(APPLY_SAVE_URL);
    console.log(data);
    var layer_index = layer.load();
    $.ajax({
        'type' : 'POST',
        'url' : APPLY_SAVE_URL,
        'data' : data,
        'dataType' : 'json',
        'success' : function(ret){
            console.log(ret);
            if(!ret.apistatus){//失败
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

    var third_code = $('textarea[name=third_code]').val();
    if(!judge_validate(4,'第三方代码',third_code,false,'length',3,250)){
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

    return false;
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
}