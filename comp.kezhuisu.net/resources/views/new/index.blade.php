@extends('layouts.app')

@push('headscripts')
    {{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="content-header">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="icon icon-home"></i></a></li>
            <li class="active"><a href="{{ url('new/') }}">平台公告</a></li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">平台公告</div>
                </div>
                <div class="panel-body">
                    <!-- PAGE CONTENT BEGINS -->
                    <input type="hidden" value="1" id="page"/><!--当前页号-->
                    <input type="hidden" value="15" id="pagesize"/><!--每页显示数量-->
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

                    <div class="list ">
                         <div>
                            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>标题</th>
                                    <th>创建时间</th>
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
@endsection


@push('footscripts')

<!-- 前端模板结束 -->
<script type="text/javascript">
const DYNAMIC_PAGE_BAIDU_TEMPLATE= "baidu_template_data_page";//分页百度模板id
const DYNAMIC_TABLE = 'dynamic-table';//动态表格id
const AJAX_URL = "{{ url('api/new/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist
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

</script>

<!-- 前端模板部分 -->
<!-- 列表模板部分 开始-->
<script type="text/template"  id="baidu_template_data_list">
    <%for(var i = 0; i<data_list.length;i++){
    var item = data_list[i];
    %>
    <tr>
        <td><%=item.id%></td>
        <td><a href="/new/<%=item.id%>" ><%=item.new_title%></a></td>
        <td><%=item.created_at%></td>
    </tr>
    <%}%>
</script>
<!-- 列表模板部分 结束-->
@endpush