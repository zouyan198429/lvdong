@extends('layouts.app')

@push('headscripts')
    {{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="content-header">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="icon icon-home"></i></a></li>
            <li class="active">用户反馈</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">用户反馈</div>
                </div>
                <div class="panel-body">
                    <!-- PAGE CONTENT BEGINS -->
                    <input type="hidden" value="1" id="page"/><!--当前页号-->
                    <input type="hidden" value="10" id="pagesize"/><!--每页显示数量-->
                    <input type="hidden" value="-1" id="total"/><!--总记录数量,小于0重新获取-->

                    <div class="row" style="display: none;">
                        <div class="col-xs-12">
                            <form class="form-horizontal" role="form" method="post" id="search_frm">
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label for="supplier_name" class="col-sm-3 control-label no-padding-right" >供应商名称:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="供应商名称" value="">
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <label for="supplier_province_id" class="col-sm-3 control-label no-padding-right" >所在地:</label>
                                        <div class="col-sm-9">
                                            {{--

                                                $area_params =array(
                                                        'province_id'=>'supplier_province_id',
                                                        'city_id'=>'supplier_city_id',
                                                        'area_id'=>'supplier_area_id'
                                                );
                                                sfdgthis-> lfdgoad ->viegdsfg w('pudfgdgblic/area_select/area_select',$area_params);
                                                 --}}
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label for="supplier_status" class="col-sm-3 control-label no-padding-right" >供应商状态:</label>
                                        <div class="col-sm-9">
                                            <select class="chosen-select form-control" id="supplier_status" name="supplier_status" data-placeholder="请选择状态">
                                                <option value="" selected="selected">全部</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="supplier_is_open" class="col-sm-3 control-label no-padding-right" >启用状态:</label>
                                        <div class="col-sm-9">

                                            <select class="chosen-select form-control" id="supplier_is_open" name="supplier_is_open" data-placeholder="请选择状态">
                                                <option value="" selected="selected">全部</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="supplier_person" class="col-sm-3 control-label no-padding-right" >供应商联系人:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="supplier_person" name="supplier_person" placeholder="供应商联系人" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label for="supplier_sale_name" class="col-sm-3 control-label no-padding-right" >业务员:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="supplier_sale_name" name="supplier_sale_name" placeholder="业务员" value="">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="supplier_create_name" class="col-sm-3 control-label no-padding-right" >创建人:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="supplier_create_name" name="supplier_create_name" placeholder="创建人" value="">
                                        </div>
                                    </div>

                                    <div class=" col-sm-4">
                                        <button class="btn btn-info search_frm" type="button">
                                            <i class="ace-icon fa fa-check bigger-110"></i>
                                            查询
                                        </button>

                                        &nbsp; &nbsp; &nbsp;
                                        <button class="btn" type="reset">
                                            <i class="ace-icon fa fa-undo bigger-110"></i>
                                            重置
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

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
                                {{--
                                <div class="table-tools" style="margin-bottom: 15px;">
                                    <div class="tools-group">
                                        <a href="{{ url('comment/' . $pro_unit_id. '/add/0') }}" class="btn btn-primary"><i class="icon icon-plus-sign"></i> 增加新帐号</a>
                                    </div>
                                </div>
                                --}}
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
                                        <th  width="80">用户ID</th>
                                        <th  width="100">用户</th>
                                        <th>内容</th>
                                        <th width="180">创建时间</th>
                                        <th width="100" >状态</th>
                                        <th style="width:140px;">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="data_list">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{--

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="80">ID</th>
                            <th>用户</th>
                            <th>内容</th>
                            <th width="180">创建时间</th>
                            <th width="120">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>125</td>
                            <td>13335234523</td>
                            <td>己经是第二次购买了，他家苹果是我想要的，因为好新鲜又清甜，给孩子打汁喝，好甜！孩子好喜欢吃！有烂果卖家又马上给赔偿，令我觉得好诚信！我会一直吃完买，一直吃完买的……</td>
                            <td>2018-05-22</td>
                            <td>
                                <a href="#" class="btn btn-xs btn-primary">审核</a>
                                <a href="#" class="btn btn-xs btn-danger">删除</a>
                            </td>
                        </tr>
                        <tr>
                            <td>125</td>
                            <td>13335234523</td>
                            <td>这个包装我真的还是非常感动，泡沫盒子，两个冰袋，几乎没有碰伤，苹果也很新鲜，比起在外面买真的划算多了啊，泡沫袋子也很多，我觉得很满意啊</td>
                            <td>2018-05-22</td>
                            <td>
                                <a href="#" class="btn btn-xs btn-primary">审核</a>
                                <a href="#" class="btn btn-xs btn-danger">删除</a>
                            </td>
                        </tr>
                        <tr>
                            <td>125</td>
                            <td>13335234523</td>
                            <td>这是第二次购买，物流的话也算快，然后包装有一点破损，但是没有太大的影响，以后有需要的话还会过来购买。</td>
                            <td>2018-05-22</td>
                            <td>
                                <a href="#" class="btn btn-xs btn-primary">审核</a>
                                <a href="#" class="btn btn-xs btn-danger">删除</a>
                            </td>
                        </tr>
                        <tr>
                            <td>125</td>
                            <td>13335234523</td>
                            <td>己经是第二次购买了，他家苹果是我想要的，因为好新鲜又清甜，给孩子打汁喝，好甜！孩子好喜欢吃！有烂果卖家又马上给赔偿，令我觉得好诚信！我会一直吃完买，一直吃完买的……</td>
                            <td>2018-05-22</td>
                            <td>
                                <a href="#" class="btn btn-xs btn-primary">审核</a>
                                <a href="#" class="btn btn-xs btn-danger">删除</a>
                            </td>
                        </tr>
                        <tr>
                            <td>125</td>
                            <td>13335234523</td>
                            <td>这个包装我真的还是非常感动，泡沫盒子，两个冰袋，几乎没有碰伤，苹果也很新鲜，比起在外面买真的划算多了啊，泡沫袋子也很多，我觉得很满意啊</td>
                            <td>2018-05-22</td>
                            <td>
                                <a href="#" class="btn btn-xs btn-warning">不通过</a>
                                <a href="#" class="btn btn-xs btn-danger">删除</a>
                            </td>
                        </tr>
                        <tr>
                            <td>125</td>
                            <td>13335234523</td>
                            <td>这是第二次购买，物流的话也算快，然后包装有一点破损，但是没有太大的影响，以后有需要的话还会过来购买。</td>
                            <td>2018-05-22</td>
                            <td>
                                <a href="#" class="btn btn-xs ">已经审核</a>
                                <a href="#" class="btn btn-xs btn-danger">删除</a>
                            </td>
                        </tr>



                        </tbody>
                    </table>
                    --}}
                </div>
            </div>
        </div>
    </div>
@endsection


@push('footscripts')

<!-- 前端模板结束 -->
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
{ "bSortable": false }
];
const DYNAMIC_PAGE_BAIDU_TEMPLATE= "baidu_template_data_page";//分页百度模板id
const DYNAMIC_TABLE = 'dynamic-table';//动态表格id
const AJAX_URL = "{{ url('api/comment/' . $pro_unit_id. '/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist
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
    go("{{url('comment/' . $pro_unit_id. '/add')}}/" + id)
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
            ajax_url = "{{ url('api/comment/' . $pro_unit_id. '/ajax_del') }}";// /pms/Supplier/ajax_del?operate_type=1
            break;
       case 'pass'://审核通过
            operate_txt = "审核通过";
            data = {'id':id,'status':1}
            ajax_url = "{{ url('api/comment/' . $pro_unit_id. '/ajax_status') }}";// /pms/Supplier/ajax_del?operate_type=1
            break;
       case 'notpass'://审核不通过
            operate_txt = "审核不通过";
            data = {'id':id,'status':2}
            ajax_url = "{{ url('api/comment/' . $pro_unit_id. '/ajax_status') }}";// /pms/Supplier/ajax_del?operate_type=1
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
    var status = item.status;
    var can_modify = false;
    {{--// if( item.account_issuper==0 ){ //&& (item.supplier_status & (1+8))>0--}}
        can_modify = true;
{{--//}--}}
%>
<tr>
    <td class="center" style="display:none;">
        <label class="pos-rel">
            <input type="checkbox" class="ace" <%if( !can_modify){%> disabled <%}%>  value="<%=item.id%>"/>
            <span class="lbl"></span>
        </label>
    </td>
    <td><%=item.id%></td>
    <td><%=item.comment_mobile%></td>
    <td><%=item.comment_content%></td>
    <td><%=item.created_at%></td>
    <td><%=item.status_text%></td>
    <td>
      <div class="action-buttons">
        <%if( false){%>
        <a href="javascript:void(0);" class="btn btn-xs btn-success"  onclick="action.show(<%=item.id%>)">
            <i class="ace-icon fa fa-check bigger-60"> 查看</i>
        </a>
        <%}%>
        <%if(status == 0){%>
            <a href="#" class="btn btn-xs btn-primary" onclick="action.pass(<%=item.id%>)">通过</a>
            <a href="#" class="btn btn-xs btn-primary"  onclick="action.notpass(<%=item.id%>)">不通过</a> 
        <%}%>
        <%if( false){%>
        <a href="javascript:void(0);" class="btn btn-xs btn-info" onclick="action.edit(<%=item.id%>)">
            <i class="ace-icon fa fa-pencil bigger-60"> 编辑</i>
        </a>
        <%}%>
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
@endpush