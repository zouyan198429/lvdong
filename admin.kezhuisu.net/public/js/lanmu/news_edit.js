
var SUBMIT_FORM = true;//防止多次点击提交
$(function(){
    // 富文本
    KindEditor.create('textarea.kindeditor', {
        basePath: '/dist/lib/kindeditor/',
        allowFileManager : true,
        bodyClass : 'article-content',
        afterBlur : function(){
            this.sync();
        }
    });

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

    var new_title = $('input[name=new_title]').val();
    if(!judge_validate(4,'标题',new_title,true,'length',2,40)){
        return false;
    }

    var new_content = $('textarea[name=new_content]').val();
//        if(!judge_validate(4,'内容',new_content,false,'length',3,25000)){
//            return false;
//        }

    var volume = $('input[name=volume]').val();
    if(!judge_validate(4,'阅读量',volume,false,'digit','','')){
        return false;
    }


    var new_source = $('input[name=new_source]').val();
    if(!judge_validate(4,'新闻来源',new_source,false,'length',2,20)){
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