
var myTable = null;
const AO_COLUMNS= [
    { "bSortable": false },
  //  null,
    null,
    null,
    null,
    null,
    null,
    null,
    { "bSortable": false }
];
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

//输入页码跳转 
//        function btn_go(){
//            var page = parseInt($("#page_num").val());
//            var totalpage = parseInt($("#totalpage").attr("totalpage"));
//            if (!page || isNaN(page) || page<=0) { page = 1; }
//            if(page > totalpage) { page = totalpage; }
//            //ajaxGoodsList(page);
//            $('#page').val(page);
//            myTable = ajaxList(myTable,AO_COLUMNS,DYNAMIC_TABLE,DYNAMIC_PAGE_BAIDU_TEMPLATE,AJAX_URL,true,SURE_FRM_IDS,false,DYNAMIC_BAIDU_TEMPLATE,DYNAMIC_TABLE_BODY,DYNAMIC_LODING_BAIDU_TEMPLATE,DYNAMIC_BAIDU_EMPTY_TEMPLATE,PAGE_ID,PAGE_SIZE,TOTAL_ID);
//        }
$(function(){
// reset_area_sel(0,1,'');//初始化省
//1、初始化动态表格
//myTable = reset_dabatables(myTable,AO_COLUMNS,DYNAMIC_TABLE,DYNAMIC_PAGE_BAIDU_TEMPLATE);
    myTable = $('#'+DYNAMIC_TABLE).DataTable();

//2、读取第一页数据
    myTable = ajaxList(myTable,AO_COLUMNS,DYNAMIC_TABLE,DYNAMIC_PAGE_BAIDU_TEMPLATE,AJAX_URL,false,SURE_FRM_IDS,true,DYNAMIC_BAIDU_TEMPLATE,DYNAMIC_TABLE_BODY,DYNAMIC_LODING_BAIDU_TEMPLATE,DYNAMIC_BAIDU_EMPTY_TEMPLATE,PAGE_ID,PAGE_SIZE,TOTAL_ID);

//弹出新加页面
    if( (OPERATE_TYPE & 1) == 1){
        popus_add(2);
    }

//新建按钮
    $(document).on("click",".add_suppiler",function(){
        popus_add(1);
    });

//导出excel
    $(document).on("click",".export_excel",function(){
        var sure_cancel_data = {
            'content':'确定导出Excel？ ',//提示文字
            'sure_event':'excel_sure();',//确定
        };
        sure_cancel_alert(sure_cancel_data);
    });

//批量删除
    $(document).on("click",".batch_del",function(){
        if(!judge_list_checked(DYNAMIC_TABLE_BODY,1)){//没有选中的
            countdown_alert('请选择需要操作的记录!',3,5);
            return false;
        }

        var sure_cancel_data = {
            'content':'确定删除所选择的记录吗？ ',//提示文字
            'sure_event':'batch_del();',//确定
        };
        sure_cancel_alert(sure_cancel_data);

    });

//查询
    $(document).on("click",".search_frm",function(){
        $("#"+PAGE_ID).val(1);//重归第一页
        //获得搜索表单的值
        append_sure_form(SURE_FRM_IDS,FRM_IDS);//把搜索表单值转换到可以查询用的表单中
        reset_list();

    });
})

//弹窗-新加页面
//operate_type 1列表页点击过来的2 左边菜单点击过来的
function popus_add(operate_type){
    var weburl = '/pms/Supplier/add?supplier_id=0&operate_type='+operate_type;
    var tishi = "新建供应商";
    layeriframe(weburl,tishi,950,600,0);
    return false;
}

//重载列表
function reset_list(){
//1、每次使用前重新初始化[不然后面会出错]
    myTable = $('#'+DYNAMIC_TABLE).DataTable();
//2、读取第一页数据
    myTable = ajaxList(myTable,AO_COLUMNS,DYNAMIC_TABLE,DYNAMIC_PAGE_BAIDU_TEMPLATE,AJAX_URL,true,SURE_FRM_IDS,true,DYNAMIC_BAIDU_TEMPLATE,DYNAMIC_TABLE_BODY,DYNAMIC_LODING_BAIDU_TEMPLATE,DYNAMIC_BAIDU_EMPTY_TEMPLATE,PAGE_ID,PAGE_SIZE,TOTAL_ID);
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
        go(INPUTS_EDIT_URL + id)
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
    document.write("");
    document.write("<!-- 前端模板部分 -->");
    document.write("<!-- 列表模板部分 开始-->");
    document.write("<script type=\"text\/template\"  id=\"baidu_template_data_list\">");
    document.write("<%for(var i = 0; i<data_list.length;i++){");
    document.write("    var item = data_list[i];");
    document.write("    var can_modify = false;");
    document.write("    ");
    document.write("        can_modify = true;");
    document.write("%>");
    document.write("<tr>");
    document.write("   <td class=\"center\" style=\"display:none;\">");
    document.write("       <label class=\"pos-rel\">");
    document.write("           <input type=\"checkbox\" class=\"ace\" <%if( !can_modify){%> disabled <%}%>  value=\"<%=item.id%>\"\/>");
    document.write("           <span class=\"lbl\"><\/span>");
    document.write("       <\/label>");
    document.write("   <\/td>");
    document.write("   <td><%=item.id%><\/td>");
    // document.write("   <td><%=item.site_input_name%><\/td>");
    document.write("   <td><img  data-toggle=\"lightbox\"  src=\"<%=item.pic_url%>\" width=\"50px\"><\/td>");
    document.write("   <td><%=item.pro_input_name%><\/td>");
    document.write("   <td><%=item.pro_input_brand%><\/td>");
    document.write("   <td><%=item.pro_input_factory%><\/td>");
    document.write("   <td><%=item.created_at%><\/td>");
    document.write("   <td>");
    document.write("     <div class=\"action-buttons\">");
    document.write("       <%if( false){%>");
    document.write("       <a href=\"javascript:void(0);\" class=\"btn btn-xs btn-success\"  onclick=\"action.show(<%=item.id%>)\">");
    document.write("           <i class=\"ace-icon fa fa-check bigger-60\"> 查看<\/i>");
    document.write("       <\/a>");
    document.write("       <%}%>");
    document.write("       <a href=\"javascript:void(0);\" class=\"btn btn-xs btn-info\" onclick=\"action.edit(<%=item.id%>)\">");
    document.write("           <i class=\"ace-icon fa fa-pencil bigger-60\"> 编辑<\/i>");
    document.write("       <\/a>");
    document.write("       <%if( can_modify){%>");
    document.write("           <button class=\"btn btn-xs btn-danger J-btn-tableDel\" onclick=\"action.del(<%=item.id%>)\">");
    document.write("               <i class=\"ace-icon fa fa-trash-o bigger-60\"> 删除<\/i>");
    document.write("           <\/button>");
    document.write("       <%}%>");
    document.write("       <%if( false){%>");
    document.write("           <a class=\"blue\" href=\"javascript:void(0);\" onclick=\"action.show(<%=item.id%>)\">");
    document.write("               <i class=\"ace-icon fa fa-search-plus bigger-130\"><\/i>");
    document.write("           <\/a>");
    document.write("           <%if( can_modify){%>");
    document.write("               <a class=\"green\" href=\"javascript:void(0);\" onclick=\"action.edit(<%=item.id%>)\">");
    document.write("                   <i class=\"ace-icon fa fa-pencil bigger-130\"><\/i>");
    document.write("               <\/a>");
    document.write("               <a class=\"red\" href=\"javascript:void(0);\" onclick=\"action.del(<%=item.id%>)\">");
    document.write("                   <i class=\"ace-icon fa fa-trash-o bigger-130\"><\/i>");
    document.write("               <\/a>");
    document.write("           <%}%>");
    document.write("       <%}%>");
    document.write("     <\/div>");
    document.write("   <\/td>");
    document.write("<\/tr>");
    document.write("<%}%>");
    document.write("<\/script>");
    document.write("<!-- 列表模板部分 结束-->");
    document.write("<!-- 前端模板结束 -->");
}).call();