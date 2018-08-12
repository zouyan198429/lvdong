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
        {{--
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
                                {{  --

                                    $area_params =array(
                                            'province_id'=>'supplier_province_id',
                                            'city_id'=>'supplier_city_id',
                                            'area_id'=>'supplier_area_id'
                                    );
                                    sfdgthis-> lfdgoad ->viegdsfg w('pudfgdgblic/area_select/area_select',$area_params);
                                     -- }}
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
        --}}
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
    const AJAX_URL = "{{ url('api/admin/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist
    const EDIT_URL = "{{url('admin/edit')}}/";//修改页面地址前缀
    const DEL_URL = "{{ url('api/admin/ajax_del') }}";//删除页面地址

</script>
<script src="{{ asset('/js/lanmu/admin.js') }}"  type="text/javascript"></script>
@endpush