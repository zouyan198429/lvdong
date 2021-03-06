
const DYNAMIC_PAGE_BAIDU_TEMPLATE= "baidu_template_data_page";//分页百度模板id
const DYNAMIC_TABLE = 'dynamic-table';//动态表格id
const DYNAMIC_BAIDU_TEMPLATE = "baidu_template_data_list";//百度模板id
const DYNAMIC_TABLE_BODY = "data_list";//数据列表id
const DYNAMIC_LODING_BAIDU_TEMPLATE = "baidu_template_data_loding";//加载中百度模板id
const DYNAMIC_BAIDU_EMPTY_TEMPLATE = "baidu_template_data_empty";//没有数据记录百度模板id
// const FRM_IDS = "search_frm";//需要读取的表单的id，多个用,号分隔
const SURE_FRM_IDS = "search_sure_form";//确认搜索条件需要读取的表单的id，多个用,号分隔
const PAGE_ID = "page";//当前页id
const PAGE_SIZE = Math.ceil(parseInt($('#pagesize').val()));;//每页显示数量
const TOTAL_ID = "total";//总记录数量[特别说明:小于0,需要从数据库重新获取]

$(function(){
    //读取第一页数据
    ajaxPageList(DYNAMIC_TABLE,DYNAMIC_PAGE_BAIDU_TEMPLATE,AJAX_URL,false,SURE_FRM_IDS,true,DYNAMIC_BAIDU_TEMPLATE,DYNAMIC_TABLE_BODY,DYNAMIC_LODING_BAIDU_TEMPLATE,DYNAMIC_BAIDU_EMPTY_TEMPLATE,PAGE_ID,PAGE_SIZE,TOTAL_ID);

    //修改按钮
    $(document).on("click",".edit_record",function(){
        var id = $(this).data('id');
        go(EDIT_URL + id);
    });

    //删除按钮
    $(document).on("click",".del_record",function(){
        var id = $(this).data('id');
        var index_query = layer.confirm('您确定删除吗？不可恢复!', {
            btn: ['确定','取消'] //按钮
        }, function(){
            layer.close(index_query);
            ajax_form(id);
        }, function(){
        });
        return false;
    });
});

//重载列表
function reset_list(){
    //重新读取数据
    ajaxPageList(DYNAMIC_TABLE,DYNAMIC_PAGE_BAIDU_TEMPLATE,AJAX_URL,true,SURE_FRM_IDS,true,DYNAMIC_BAIDU_TEMPLATE,DYNAMIC_TABLE_BODY,DYNAMIC_LODING_BAIDU_TEMPLATE,DYNAMIC_BAIDU_EMPTY_TEMPLATE,PAGE_ID,PAGE_SIZE,TOTAL_ID);
}

//ajax提交表单
function ajax_form(id){
    var data = {'id':id};
    console.log(DEL_URL);
    console.log(data);
    var layer_index = layer.load();
    $.ajax({
        'type' : 'POST',
        'url' : DEL_URL,
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

//业务逻辑部分
var action = {
    show : function(id){
        //location.href='/pms/Supplier/show?supplier_id='+id;
        var weburl = '/pms/Supplier/show?supplier_id='+id+"&operate_type=1";
        var tishi = "查看供应商";
        layeriframe(weburl,tishi,950,600,0);
        return false;
    },
    edit : function(id){
        go(ADDNEW_URL + id);
        return false;
        //location.href='/pms/Supplier/modify?supplier_id='+id;
        var weburl = '/pms/Supplier/modify?supplier_id='+id+"&operate_type=1";
        var tishi = "修改供应商";
        layeriframe(weburl,tishi,950,600,0);
        return false;
    },
    del : function(id){
        var index_query = layer.confirm('确定删除当前记录？删除后不可恢复!', {
            btn: ['确定','取消'] //按钮
        }, function(){
            operate_ajax('del',id);
            layer.close(index_query);
        }, function(){
        });
        return false;
        if(false) {
            var sure_cancel_data = {
                'content':'确定删除当前记录？删除后不可恢复! ',//提示文字
                'sure_event':'del_sure('+id+');',//确定
            };
            sure_cancel_alert(sure_cancel_data);
            return false;
        }
    },
    pass : function(id){
        var index_query = layer.confirm('确定审核通过当前记录？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            operate_ajax('pass',id);
            layer.close(index_query);
        }, function(){
        });
        return false;
    },
    notpass : function(id){
        var index_query = layer.confirm('确定审核不通过当前记录？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            operate_ajax('notpass',id);
            layer.close(index_query);
        }, function(){
        });
        return false;
    }
};

//导出excel -> 确定按钮
function excel_sure(){
    sure_cancel_cancel();//隐藏弹出层显示对象
    append_sure_form(SURE_FRM_IDS,FRM_IDS);//把搜索表单值转换到可以查询用的表单中
    var parames = get_frm_param(SURE_FRM_IDS);
    var url = '/pms/Supplier/export';
    if(parames.length>0){
        url += "?"+parames;
    }
    window.open(url);
    /*
    if($("#"+SURE_FRM_IDS).length>0){
        $("#"+SURE_FRM_IDS).attr("action","/pms/Supplier/export");
        $("#"+SURE_FRM_IDS).attr("target","_blank");
        $("#"+SURE_FRM_IDS).submit();
    }else{
        window.open ('/pms/Supplier/export');
    }
    **/
}

//删除 -> 确定按钮
function del_sure(id){
    sure_cancel_cancel();//隐藏弹出层显示对象
    //ajax删除数据
    operate_ajax('del',id);
}
//批量删除
function batch_del(){
    sure_cancel_cancel();//隐藏弹出层显示对象
    var ids = get_list_checked(DYNAMIC_TABLE_BODY,1,1);
    //ajax删除数据
    operate_ajax('batch_del',ids);
}

//操作
function operate_ajax(operate_type,id){
    if(operate_type=='' || id==''){
        err_alert('请选择需要操作的数据');
        return false;
    }
    var operate_txt = "";
    var data ={};
    var ajax_url = "";
    switch(operate_type)
    {
        case 'del'://删除
            operate_txt = "删除";
            data = {'id':id}
            ajax_url = COMMON_DEL_URL;// /pms/Supplier/ajax_del?operate_type=1
            break;
        case 'pass'://审核通过
            operate_txt = "审核通过";
            data = {'id':id,'status':1}
            ajax_url = PASS_URL;// /pms/Supplier/ajax_del?operate_type=1
            break;
        case 'notpass'://审核不通过
            operate_txt = "审核不通过";
            data = {'id':id,'status':2}
            ajax_url = NOT_PASS_URL;// /pms/Supplier/ajax_del?operate_type=1
            break;
        case 'batch_del'://批量删除
            operate_txt = "批量删除";
            data = {'supplier_id':id}
            ajax_url = "/pms/Supplier/ajax_del?operate_type=2";
            break;
        default:
            break;
    }
    var layer_index = layer.load();//layer.msg('加载中', {icon: 16});
    $.ajax({
        'type' : 'POST',
        'url' : ajax_url,//'/pms/Supplier/ajax_del',
        'data' : data,
        'dataType' : 'json',
        'success' : function(ret){
            if(!ret.apistatus){//失败
                //alert('失败');
                // countdown_alert(ret.errorMsg,0,5);
                layer_alert(ret.errorMsg,0,0);
            }else{//成功
                var msg = ret.errorMsg;
                if(msg === ""){
                    msg = operate_txt+"成功";
                }
                // countdown_alert(msg,1,5);
                layer_alert(msg,1,0);
                reset_list();
            }
            layer.close(layer_index)//手动关闭
        }
    });
}


//操作
function operate_ajax(operate_type,id){
    if(operate_type=='' || id==''){
        err_alert('请选择需要操作的数据');
        return false;
    }
    var operate_txt = "";
    var data ={};
    var ajax_url = "";
    switch(operate_type)
    {
        case 'del'://删除
            operate_txt = "删除";
            data = {'id':id}
            ajax_url = INPUTS_DEL_URL;// /pms/Supplier/ajax_del?operate_type=1
            break;
        case 'batch_del'://批量删除
            operate_txt = "批量删除";
            data = {'supplier_id':id}
            ajax_url = "/pms/Supplier/ajax_del?operate_type=2";
            break;
        default:
            break;
    }
    var layer_index = layer.load();//layer.msg('加载中', {icon: 16});
    $.ajax({
        'type' : 'POST',
        'url' : ajax_url,//'/pms/Supplier/ajax_del',
        'data' : data,
        'dataType' : 'json',
        'success' : function(ret){
            if(!ret.apistatus){//失败
                //alert('失败');
                // countdown_alert(ret.errorMsg,0,5);
                layer_alert(ret.errorMsg,0,0);
            }else{//成功
                var msg = ret.errorMsg;
                if(msg === ""){
                    msg = operate_txt+"成功";
                }
                // countdown_alert(msg,1,5);
                layer_alert(msg,1,0);
                reset_list();
            }
            layer.close(layer_index)//手动关闭
        }
    });
}

(function() {
    document.write("   <!-- 前端模板部分 -->");
    document.write("    <!-- 列表模板部分 开始-->");
    document.write("    <script type=\"text\/template\"  id=\"baidu_template_data_list\">");
    document.write("        <%for(var i = 0; i<data_list.length;i++){");
    document.write("        var item = data_list[i];");
    document.write("        var imgArr = item.pic_urls;");
    document.write("        %>");
    document.write("        <div class=\"item\">");
    document.write("            <div class=\"item-heading\">");
    document.write("                <div class=\"pull-right\"><span class=\"text-muted\"><%=item.created_at%><\/span>  <\/div>");
    document.write("        <h4><a href=\"###\">发布人：<%=item.real_name%><\/a><%=item.node_txt%><\/h4>");
    document.write("    <\/div>");
    document.write("    <div class=\"item-content\">");
    document.write("        <div class=\"text\">");
    document.write("        <%=item.record_intro%>");
    document.write("        <\/div>");
    document.write("    <\/div>");
    document.write("    <%for(var j = 0; j<imgArr.length;j++){");
    document.write("        var picItem = imgArr[j];");
    document.write("        %>");
    document.write("        <img data-toggle=\"lightbox\"  src=\"<%=picItem%>\" alt=\"\" width=180 \/>");
    document.write("");
    document.write("    <%}%>");
    document.write("    <p class=\"text-right\"><i class=\"icon icon-times del_record\" data-id=\"<%=item.id%>\"> 删除<\/i> | <i class=\"icon icon-edit edit_record\"  data-id=\"<%=item.id%>\"> 编辑<\/i>  <\/p>");
    document.write("<\/div>");
    document.write("<%}%>");
    document.write("<\/script>");
    document.write("<!-- 列表模板部分 结束-->");
}).call();