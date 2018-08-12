
var SUBMIT_FORM = true;//防止多次点击提交
$(function(){
    reset_area_sel(0,1,'');//初始化省

    //当前省市区县
    if (has_province){
        var area_json = AREA_JSON;
        init_area_sel(area_json,1);
    }
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

    var company_type_id = $('select[name=company_type_id]').val();
    if(!judge_validate(4,'公司类型',company_type_id,true,'digit','','')){
        return false;
    }

    var company_rank_id = $('select[name=company_rank_id]').val();
    if(!judge_validate(4,'公司等级',company_rank_id,true,'digit','','')){
        return false;
    }

    var company_name = $('input[name=company_name]').val();
    if(!judge_validate(4,'公司名称',company_name,true,'length',2,40)){
        return false;
    }

    var company_simple_name = $('input[name=company_simple_name]').val();
    if(!judge_validate(4,'公司简称',company_simple_name,false,'length',2,40)){
        return false;
    }

    var ccredit_code = $('input[name=ccredit_code]').val();
    if(!judge_validate(4,'统一社会信用代码',ccredit_code,false,'length',2,40)){
        return false;
    }

    var reg_capital = $('input[name=reg_capital]').val();
    if(!judge_validate(4,'注册资金',reg_capital,false,'length',2,40)){
        return false;
    }

    var legal_name = $('input[name=legal_name]').val();
    if(!judge_validate(4,'法定代表人',legal_name,false,'length',2,40)){
        return false;
    }

    var company_linkman = $('input[name=company_linkman]').val();
    if(!judge_validate(4,'联系人',company_linkman,false,'length',2,40)){
        return false;
    }

    var company_tel = $('input[name=company_tel]').val();
    if(!judge_validate(4,'电话',company_tel,false,'length',2,40)){
        return false;
    }

    var company_mobile = $('input[name=company_mobile]').val();
    if(!judge_validate(4,'手机',company_mobile,false,'mobile','','')){
        return false;
    }

    var company_wx = $('input[name=company_wx]').val();
    if(!judge_validate(4,'微信号',company_wx,false,'length',2,40)){
        return false;
    }

    var company_fax = $('input[name=company_fax]').val();
    if(!judge_validate(4,'传真',company_fax,false,'length',2,40)){
        return false;
    }

    var company_email = $('input[name=company_email]').val();
    if(!judge_validate(4,'邮箱',company_email,false,'email','','')){
        return false;
    }

    var company_addr = $('input[name=company_addr]').val();
    if(!judge_validate(4,'所在地址',company_addr,false,'length',2,40)){
        return false;
    }

    var product_addr = $('input[name=product_addr]').val();
    if(!judge_validate(4,'生产地址',product_addr,false,'length',2,40)){
        return false;
    }

    var company_mainproduct = $('textarea[name=company_mainproduct]').val();
    if(!judge_validate(4,'主营产品',company_mainproduct,false,'length',2,40)){
        return false;
    }

    var company_createtime = $('input[name=company_createtime]').val();
    if(!judge_validate(4,'成立时间',company_createtime,false,'date','','')){
        return false;
    }

    var contact_way = $('textarea[name=contact_way]').val();
    if(!judge_validate(4,'联系方式',contact_way,false,'length',2,400)){
        return false;
    }

    var company_vipbegin = $('input[name=company_vipbegin]').val();
    if(!judge_validate(4,'vip起',company_vipbegin,false,'date','','')){
        return false;
    }

    var company_vipend = $('input[name=company_vipend]').val();
    if(!judge_validate(4,'vip止',company_vipend,false,'date','','')){
        return false;
    }

    if(company_vipbegin != '' ){
        if(!judge_validate(4,'vip止必须',company_vipend,true,'data_size',company_vipbegin,5)){
            return false;
        }
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
    });
    return false;
}
