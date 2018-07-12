@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="tpl-content-page-title">
        管理员
    </div>

    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 管理员列表
            </div>
        </div>
        <!-- PAGE CONTENT BEGINS -->
        <input type="hidden" value="1" id="page"/><!--当前页号-->
        <input type="hidden" value="20" id="pagesize"/><!--每页显示数量-->
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

        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-6">
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group am-btn-group-xs">
                            <a  href="{{ url('admin/edit/0') }}" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 新增</a>
                        </div>
                    </div>
                </div>
            </div>
                <table id="dynamic-table"  class="am-table am-table-striped am-table-hover table-main">
                    <thead>
                    <tr>
                        <th class="table-id">ID</th>
                        <th class="table-title">用户名</th>
                        <th class="table-type">类别</th>
                        <th class="table-author am-hide-sm-only">真实姓名</th>
                        <th class="table-date am-hide-sm-only">修改日期</th>
                        <th class="table-set" width="160">操作</th>
                    </tr>
                    </thead>
                    <tbody  id="data_list">
                    {{--
                    <tr>
                        <td>2</td>
                        <td><a href="#">Business</a></td>
                        <td>超级管理员</td>
                        <td class="am-hide-sm-only">钟斌</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 编辑</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="#">Business</a></td>
                        <td>超级管理员</td>
                        <td class="am-hide-sm-only">钟斌</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 编辑</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    --}}
                    </tbody>
                </table>
        </div>
    </div>


    <div class="tpl-alert"></div>
@endsection

@push('footscripts')
@endpush
@push('footlast')

<!-- 前端模板结束 -->
<script type="text/javascript">
const DYNAMIC_PAGE_BAIDU_TEMPLATE= "baidu_template_data_page";//分页百度模板id
const DYNAMIC_TABLE = 'dynamic-table';//动态表格id
const AJAX_URL = "{{ url('api/admin/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist
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
        go("{{url('admin/edit')}}/" + id);
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
        {{--
       var sure_cancel_data = {
           'content':'确定删除当前记录？删除后不可恢复! ',//提示文字
           'sure_event':'del_sure('+id+');',//确定
        };
       sure_cancel_alert(sure_cancel_data);
       return false;--}}
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
            ajax_url = "{{ url('api/admin/ajax_del') }}";// /pms/Supplier/ajax_del?operate_type=1
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

</script>

<!-- 前端模板部分 -->
<!-- 列表模板部分 开始-->
<script type="text/template"  id="baidu_template_data_list">
<%for(var i = 0; i<data_list.length;i++){
	var item = data_list[i];
    var admin_type = item.admin_type;
    var can_modify = true;
    if( item.admin_type == 2 ){ //&& (item.supplier_status & (1+8))>0
        can_modify = false;
    }
	%>
    <tr>
        <td><%=item.id%></td>
        <td><a href="#"><%=item.admin_username%></a></td>
        <td><%=item.type_text%></td>
        <td class="am-hide-sm-only"><%=item.real_name%></td>
        <td class="am-hide-sm-only"><%=item.updated_at%></td>
        <td>
            <div class="am-btn-toolbar">
                <div class="am-btn-group am-btn-group-xs">
                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"  onclick="action.edit(<%=item.id%>)"><span class="am-icon-pencil-square-o"></span> 编辑</button>

                    <%if( can_modify){%>
                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"  onclick="action.del(<%=item.id%>)"><span class="am-icon-trash-o"></span> 删除</button>
                    <%}%>

                </div>
            </div>
        </td>
    </tr>
<%}%>
</script>
<!-- 列表模板部分 结束-->
@endpush