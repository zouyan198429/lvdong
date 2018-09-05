
// 下拉框选择事件
function changeCls(area_id,second_id){
    var obj =$('select[name=site_pro_unit_id_two]');
    var empty_option_json = {"": "请选择"};
    var empty_option_html = reset_sel_option(empty_option_json);//请选择省
    obj.empty();//清空下拉
    obj.append(empty_option_html);

    var option_html = "";
    var level = 2;
    if(area_id>0 && level>0){
        var layer_index = layer.load();//layer.msg('加载中', {icon: 16});
        //ajax请求银行信息
        var data = {};
        data['area_id'] = area_id;
        data['level'] = level;
        $.ajax({
            'async': false,//同步
            'type' : 'POST',
            'url' : '/api/unitCls',
            'data' : data,
            'dataType' : 'json',
            'success' : function(ret){
                if(!ret.apistatus){//失败
                    //alert('失败');
                    err_alert(ret.errorMsg);
                }else{//成功
                    //alert('成功');
                    option_html = reset_sel_option(ret.result);
                    obj.append(option_html);
                    console.log('加载成功');
                }
                layer.close(layer_index);//手动关闭
            }
        });
    }
    if(second_id > 0){
        obj.val(second_id);
    }
}
//ajax提交表单
function ajax_form(){
    if (!SUBMIT_FORM) return false;//false，则返回

    // 验证信息
    var id = $('input[name=id]').val();
    if(!judge_validate(4,'生产单元id',id,true,'digit','','')){
        return false;
    }

    var site_pro_unit_id = $('select[name=site_pro_unit_id]').val();
    if(!judge_validate(4,'类别',site_pro_unit_id,true,'digit','','')){
        return false;
    }

    // 判断是否上传图片
    var uploader = $('#myUploader').data('zui.uploader');
    var files = uploader.getFiles();
    var filesCount = files.length;

    var imgObj = $('#myUploader').closest('.resourceBlock').find(".upload_img")

    if( (!judge_list_checked(imgObj,3)) && filesCount <=0 ) {//没有选中的
        layer_alert('请选择要上传的图片！',3,0);
        return false;
    }


    var pro_input_name = $('input[name=pro_input_name]').val();
    if(!judge_validate(4,'产品全称',pro_input_name,true,'length',2,40)){
        return false;
    }

    var pro_input_brand = $('input[name=pro_input_brand]').val();
    if(!judge_validate(4,'品种/品牌',pro_input_brand,true,'length',2,20)){
        return false;
    }

    var pro_input_batch = $('input[name=pro_input_batch]').val();
    if(!judge_validate(4,'批次',pro_input_batch,true,'length',2,30)){
        return false;
    }

    var begin_time = $('input[name=begin_time]').val();
    if(!judge_validate(4,'开始日期',begin_time,true,'date','','')){
        return false;
    }

    var end_time = $('input[name=end_time]').val();
    if(!judge_validate(4,'结束日期',end_time,false,'date','','')){
        return false;
    }

    if( end_time !== '' && !judge_validate(4,'结束日期必须',end_time,true,'data_size',begin_time,5)){
        return false;
    }

    var created_at = $('input[name=created_at]').val();
    if(!judge_validate(4,'添加日期',created_at,true,'date','','')){
        return false;
    }


    // if(!judge_list_checked('selAccounts',2)) {//没有选中的
    //     layer_alert('请选择维护负责人！',3,0);
    //     return false;
    // }

    var pro_input_intro = $('textarea[name=pro_input_intro]').val();
    if(!judge_validate(4,'备注',pro_input_intro,false,'length',3,250)){
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