
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

});

//重载列表
function reset_list(){
    //重新读取数据
    ajaxPageList(DYNAMIC_TABLE,DYNAMIC_PAGE_BAIDU_TEMPLATE,AJAX_URL,true,SURE_FRM_IDS,true,DYNAMIC_BAIDU_TEMPLATE,DYNAMIC_TABLE_BODY,DYNAMIC_LODING_BAIDU_TEMPLATE,DYNAMIC_BAIDU_EMPTY_TEMPLATE,PAGE_ID,PAGE_SIZE,TOTAL_ID);
}

//业务逻辑部分
var action = {
    show : function(id){
//        //location.href='/pms/Supplier/show?supplier_id='+id;
//        var weburl = '/pms/Supplier/show?supplier_id='+id+"&operate_type=1";
//        var tishi = "查看供应商";
//        layeriframe(weburl,tishi,950,600,0);
        return false;
    },
    edit : function(id){
        go(EDIT_URL + id);
        return false;
        //location.href='/pms/Supplier/modify?supplier_id='+id;
//        var weburl = '/pms/Supplier/modify?supplier_id='+id+"&operate_type=1";
//        var tishi = "修改供应商";
//        layeriframe(weburl,tishi,950,600,0);
        return false;
    },
    del : function(id){
        var index_query = layer.confirm('确定删除当前及子记录？删除后不可恢复!', {
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
    }
};

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
            ajax_url = DEL_URL;// /pms/Supplier/ajax_del?operate_type=1
            break;
//        case 'batch_del'://批量删除
//            operate_txt = "批量删除";
//            data = {'supplier_id':id}
//            ajax_url = "/pms/Supplier/ajax_del?operate_type=2";
//            break;
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
    document.write("");
    document.write("<!-- 前端模板部分 -->");
    document.write("<!-- 列表模板部分 开始-->");
    document.write("<script type=\"text\/template\"  id=\"baidu_template_data_list\">");
    document.write("<%for(var i = 0; i<data_list.length;i++){");
    document.write("    var item = data_list[i];");
    document.write("    %>");
    document.write("    <tr>");
    document.write("        <td><%=item.id%><\/td>");
    document.write("        <td><%=item.pro_unit_name%><\/td>");
    document.write("        <td><%=item.pro_unit_order%><\/td>");
    document.write("        <td>");
    document.write("            <div class=\"am-btn-toolbar\">");
    document.write("                <div class=\"am-btn-group am-btn-group-xs\">");
    document.write("                    <button class=\"am-btn am-btn-default am-btn-xs am-text-secondary\" onclick=\"action.edit(<%=item.id%>)\"><span class=\"am-icon-pencil-square-o\"><\/span> 编辑<\/button>");
    document.write("                    <button class=\"am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only\"  onclick=\"action.del(<%=item.id%>)\"><span class=\"am-icon-trash-o\"><\/span> 删除<\/button>");
    document.write("                <\/div>");
    document.write("            <\/div>");
    document.write("        <\/td>");
    document.write("    <\/tr>");
    document.write("<%}%>");
    document.write("<\/script>");
    document.write("<!-- 列表模板部分 结束-->");
}).call();