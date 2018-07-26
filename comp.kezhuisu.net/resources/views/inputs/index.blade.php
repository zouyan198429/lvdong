@extends('layouts.app')

@push('headscripts')
    {{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="content-header">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="icon icon-home"></i></a></li>
            <li class="active">生产投入品</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p>新用户至少需要申请一个生产单元！</p>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">生产投入品</div>
                </div>
                <div class="panel-body">

                    <!-- PAGE CONTENT BEGINS -->
                    <input type="hidden" value="1" id="page"/><!--当前页号-->
                    <input type="hidden" value="10" id="pagesize"/><!--每页显示数量-->
                    <input type="hidden" value="-1" id="total"/><!--总记录数量,小于0重新获取-->
                   

                    <div class="hr hr-18 dotted hr-double"></div>
                    <div class="row">
                        <div class="col-xs-12">
                            <?php if(false){ ?>
                                    <!--<h3 class="header smaller lighter blue">jQuery dataTables</h3>-->
                            <div class="clearfix">
                                <div class="pull-right tableTools-container">
                                    <div class="dt-buttons btn-overlap btn-group">
                                        <a class="dt-button buttons-collection buttons-colvis btn btn-white btn-primary btn-bold" tabindex="0" aria-controls="dynamic-table">
                                        <span>
                                            <i class="fa fa-search bigger-110 blue"></i>
                                            <span class="hidden">Show/hide columns</span>
                                        </span>
                                        </a>
                                        <a class="dt-button buttons-copy buttons-html5 btn btn-white btn-primary btn-bold" tabindex="0" aria-controls="dynamic-table">
                                        <span>
                                            <i class="fa fa-copy bigger-110 pink"></i>
                                            <span class="hidden">Copy to clipboard</span>
                                        </span>
                                        </a>
                                        <a class="dt-button buttons-csv buttons-html5 btn btn-white btn-primary btn-bold" tabindex="0" aria-controls="dynamic-table">
                                        <span>
                                            <i class="fa fa-database bigger-110 orange"></i>
                                            <span class="hidden">Export to CSV</span>
                                        </span>
                                        </a>
                                        <a class="dt-button buttons-excel buttons-flash btn btn-white btn-primary btn-bold" tabindex="0" aria-controls="dynamic-table">
                                        <span>
                                            <i class="fa fa-file-excel-o bigger-110 green"></i>
                                            <span class="hidden">Export to Excel</span>
                                        </span>
                                        </a>
                                        <a class="dt-button buttons-pdf buttons-flash btn btn-white btn-primary btn-bold" tabindex="0" aria-controls="dynamic-table">
                                        <span>
                                            <i class="fa fa-file-pdf-o bigger-110 red"></i>
                                            <span class="hidden">Export to PDF</span>
                                        </span>
                                        </a>
                                        <a class="dt-button buttons-print btn btn-white btn-primary btn-bold" tabindex="0" aria-controls="dynamic-table">
                                        <span>
                                            <i class="fa fa-print bigger-110 grey"></i>
                                            <span class="hidden">Print</span>
                                        </span>
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <?php } ?>
                            <div class="table-header">
                                <div class="table-tools" style="margin-bottom: 15px;">
                                    <div class="tools-group">
                                        <a href="{{ url('inputs/' . $pro_unit_id. '/add/0') }}" class="btn btn-primary"><i class="icon icon-plus-sign"></i> 添加生产投入品</a>
                                    </div>
                                </div>
                                {{--
                                <button class="btn btn-danger  btn-xs batch_del">批量删除</button>
                                <button class="btn btn-success  btn-xs export_excel">导出EXCEL</button>
                                <button class="btn btn-success  btn-xs add_suppiler">新建供应商</button>
                                <br/><br/>
                                --}}
                            </div>
                            <!-- div.table-responsive -->
                            <!-- div.dataTables_borderWrap -->
                            <div>
                                <!--动态表-->
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th class="center"  style="display:none;">
                                            <label class="pos-rel">
                                                <input type="checkbox" class="ace" />
                                                <span class="lbl"></span>
                                            </label>
                                        </th>
                                        <th>ID</th>
                                        <th>类别</th>
                                        <th>图片</th>
                                        <th>名称</th>
                                        <th>品牌</th>
                                        <th>厂家</th>
                                        <th>创建时间</th>
                                        <th style="width:140px;">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="data_list">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
 
                </div>
            </div>
        </div>
    </div>
@endsection


@push('footscripts')

<script type="text/javascript">
var OPERATE_TYPE = <?php echo isset($operate_type)?$operate_type:0; ?>;
var myTable = null;
const AO_COLUMNS= [
{ "bSortable": false },
null,
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
const AJAX_URL = "{{ url('api/inputs/' . $pro_unit_id. '/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist
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
   go("{{url('inputs/' . $pro_unit_id. '/add')}}/" + id)
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
    {{--
   var sure_cancel_data = {
       'content':'确定删除当前记录？删除后不可恢复! ',//提示文字
       'sure_event':'del_sure('+id+');',//确定
    };
   sure_cancel_alert(sure_cancel_data);
   return false;--}}
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
            ajax_url = "{{ url('api/inputs/' . $pro_unit_id. '/ajax_del') }}";// /pms/Supplier/ajax_del?operate_type=1
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
</script>

<!-- 前端模板部分 -->
<!-- 列表模板部分 开始-->
<script type="text/template"  id="baidu_template_data_list">
<%for(var i = 0; i<data_list.length;i++){
    var item = data_list[i];
    var can_modify = false;
    {{-- if( item.account_issuper==0 ){ //&& (item.supplier_status & (1+8))>0--}}
        can_modify = true;
{{--// }--}}
%>
<tr>
   <td class="center" style="display:none;">
       <label class="pos-rel">
           <input type="checkbox" class="ace" <%if( !can_modify){%> disabled <%}%>  value="<%=item.id%>"/>
           <span class="lbl"></span>
       </label>
   </td>
   <td><%=item.id%></td>
   <td><%=item.site_input_name%></td>
   <td><img  data-toggle="lightbox"  src="<%=item.pic_url%>" width="50px"></td>
   <td><%=item.pro_input_name%></td>
   <td><%=item.pro_input_brand%></td>
   <td><%=item.pro_input_factory%></td>
   <td><%=item.created_at%></td>
   <td>
     <div class="action-buttons">
       <%if( false){%>
       <a href="javascript:void(0);" class="btn btn-xs btn-success"  onclick="action.show(<%=item.id%>)">
           <i class="ace-icon fa fa-check bigger-60"> 查看</i>
       </a>
       <%}%>
       <a href="javascript:void(0);" class="btn btn-xs btn-info" onclick="action.edit(<%=item.id%>)">
           <i class="ace-icon fa fa-pencil bigger-60"> 编辑</i>
       </a>
       <%if( can_modify){%>
           <button class="btn btn-xs btn-danger J-btn-tableDel" onclick="action.del(<%=item.id%>)">
               <i class="ace-icon fa fa-trash-o bigger-60"> 删除</i>
           </button>
       <%}%>
       <%if( false){%>
           <a class="blue" href="javascript:void(0);" onclick="action.show(<%=item.id%>)">
               <i class="ace-icon fa fa-search-plus bigger-130"></i>
           </a>
           <%if( can_modify){%>
               <a class="green" href="javascript:void(0);" onclick="action.edit(<%=item.id%>)">
                   <i class="ace-icon fa fa-pencil bigger-130"></i>
               </a>
               <a class="red" href="javascript:void(0);" onclick="action.del(<%=item.id%>)">
                   <i class="ace-icon fa fa-trash-o bigger-130"></i>
               </a>
           <%}%>
       <%}%>
     </div>
   </td>
</tr>
<%}%>
</script>
<!-- 列表模板部分 结束-->
<!-- 前端模板结束 -->
@endpush