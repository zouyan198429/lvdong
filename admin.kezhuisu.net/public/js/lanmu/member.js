
const DYNAMIC_PAGE_BAIDU_TEMPLATE= "baidu_template_data_page";//分页百度模板id
const DYNAMIC_TABLE = 'dynamic-table';//动态表格id
const DYNAMIC_BAIDU_TEMPLATE = "baidu_template_data_list";//百度模板id
const DYNAMIC_TABLE_BODY = "data_list";//数据列表id
const DYNAMIC_LODING_BAIDU_TEMPLATE = "baidu_template_data_loding";//加载中百度模板id
const DYNAMIC_BAIDU_EMPTY_TEMPLATE = "baidu_template_data_empty";//没有数据记录百度模板id
const FRM_IDS = "search_frm";//需要读取的表单的id，多个用,号分隔
const SURE_FRM_IDS = "search_sure_form";//确认搜索条件需要读取的表单的id，多个用,号分隔
const PAGE_ID = "page";//当前页id
const PAGE_SIZE = Math.ceil(parseInt($('#pagesize').val()));;//每页显示数量
const TOTAL_ID = "total";//总记录数量[特别说明:小于0,需要从数据库重新获取]

$(function(){

    //读取第一页数据
    ajaxPageList(DYNAMIC_TABLE,DYNAMIC_PAGE_BAIDU_TEMPLATE,AJAX_URL,false,SURE_FRM_IDS,true,DYNAMIC_BAIDU_TEMPLATE,DYNAMIC_TABLE_BODY,DYNAMIC_LODING_BAIDU_TEMPLATE,DYNAMIC_BAIDU_EMPTY_TEMPLATE,PAGE_ID,PAGE_SIZE,TOTAL_ID);
    //查询
    $('.search_frm').click(function(){
        $("#"+PAGE_ID).val(1);//重归第一页
        //获得搜索表单的值
        append_sure_form(SURE_FRM_IDS,FRM_IDS);//把搜索表单值转换到可以查询用的表单中
        reset_list(false);
    });
    // 新加
    $('.addNew').click(function(){

        //countdown_alert('请选择需要操作的记录!',3,5);//return false;
        //layer_alert('商品ID盘点数不允许为空！',5,1);
        // go(ADDNEW_URL);
    });
});

//重载列表
//is_read_page 是否读取当前页,否则为第一页 true:读取,false默认第一页
function reset_list(is_read_page){
    //重新读取数据
    ajaxPageList(DYNAMIC_TABLE,DYNAMIC_PAGE_BAIDU_TEMPLATE,AJAX_URL,is_read_page,SURE_FRM_IDS,true,DYNAMIC_BAIDU_TEMPLATE,DYNAMIC_TABLE_BODY,DYNAMIC_LODING_BAIDU_TEMPLATE,DYNAMIC_BAIDU_EMPTY_TEMPLATE,PAGE_ID,PAGE_SIZE,TOTAL_ID);
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
        var index_query = layer.confirm('确定删除当前记录？删除后不可恢复!', {
            btn: ['确定','取消'] //按钮
        }, function(){
            operate_ajax('del',id);
            layer.close(index_query);
        }, function(){
        });
        return false;
            //
            // var sure_cancel_data = {
            //     'content':'确定删除当前记录？删除后不可恢复! ',//提示文字
            //     'sure_event':'del_sure('+id+');',//确定
            // };
            // sure_cancel_alert(sure_cancel_data);
            // return false;
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
                reset_list(true);
            }
            layer.close(layer_index)//手动关闭
        }
    });
}

(function() {
    document.write("");
    document.write("    <!-- 前端模板部分 -->");
    document.write("    <!-- 列表模板部分 开始-->");
    document.write("    <script type=\"text\/template\"  id=\"baidu_template_data_list\">");
    document.write("        <%for(var i = 0; i<data_list.length;i++){");
    document.write("        var item = data_list[i];");
    document.write("        %>");
    document.write("");
    document.write("        <tr>");
    document.write("            <td><%=item.id%><\/td>");
    document.write("            <td><%=item.company_name%><\/td>");
    document.write("            <td><%=item.company_linkman%><\/td>");
    document.write("            <td><%=item.company_mobile%><br\/><%=item.company_tel%><\/td>");
    document.write("            <td><%=item.area%><\/td>");
    document.write("            <%if(false){%>");
    document.write("            <td>新注册<\/td>");
    document.write("            <%}%>");
    document.write("            <td class=\"am-hide-sm-only\">");
    document.write("            <%=item.company_vipbegin%>");
    document.write("            --");
    document.write("            <%=item.company_vipend%>");
    document.write("            <\/td>");
    document.write("            <td class=\"am-hide-sm-only\"><%=item.created_at%><\/td>");
    document.write("            <td class=\"am-hide-sm-only\"><%=item.company_lastlogintime%><\/td>");
    document.write("            <td>");
    document.write("                <div class=\"am-btn-toolbar\">");
    document.write("                    <div class=\"am-btn-group am-btn-group-xs\">");
    document.write("                        <button class=\"am-btn am-btn-default am-btn-xs am-text-secondary\"  onclick=\"action.edit(<%=item.id%>)\"> 修改 <\/button>");
    document.write("                        <button class=\"am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only\" onclick=\"action.del(<%=item.id%>)\"><span class=\"am-icon-trash-o\"><\/span> 删除<\/button>");
    document.write("                       <% if(false){%>");
    document.write("                        <button class=\"am-btn am-btn-default am-btn-xs am-text-secondary \"><span class=\"am-icon-pencil-square-o\"><\/span> 备注（1）<\/button>");
    document.write("                       <%  }%>");
    document.write("                    <\/div>");
    document.write("                <\/div>");
    document.write("            <\/td>");
    document.write("        <\/tr>");
    document.write("<%}%>");
    document.write("<\/script>");
    document.write("<!-- 列表模板部分 结束-->");
}).call();