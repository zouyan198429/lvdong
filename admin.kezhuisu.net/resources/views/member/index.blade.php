@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="tpl-content-page-title">
        会员管理
    </div>
    {{--
    <div class="tpl-content-scope">
        <div class="note note-info">
            <p><span class="label label-danger">提示:</span><br />新注册用户指未进行认证用户，认证通过后升级为免费VIP，即为试用期用户。<br />
                试用期为2个月。即将过期为30天内过期会员。<br />
                过期会员---为试用后未成为VIP的会员和VIP已经到期的会员。<br />
                备注--管理员对客户情况进行记录。便于下次联系前查看。点击备注可以看历史记录。
            </p>
        </div>
    </div>
    --}}
    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 会员列表
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <button type="button" class="am-btn am-btn-default am-btn-success addNew">新注册</button>

                        {{--
                                    <button type="button" class="am-btn am-btn-default am-btn-warning"><span class="am-icon-save"></span> 试用客户</button>
                                    <button type="button" class="am-btn am-btn-default am-btn-secondary"><span class="am-icon-archive"></span> VIP</button>
                                    <button type="button" class="am-btn am-btn-default am-btn-secondary"><span class="am-icon-archive"></span> 即将过期</button>
                                    <button type="button" class="am-btn am-btn-default am-btn-danger"><span class="am-icon-trash-o"></span> 过期客户 </button>

                        --}}
                                </div>
                            </div>
                        </div>
            <!-- PAGE CONTENT BEGINS -->
            <input type="hidden" value="1" id="page"/><!--当前页号-->
            <input type="hidden" value="20" id="pagesize"/><!--每页显示数量-->
            <input type="hidden" value="-1" id="total"/><!--总记录数量,小于0重新获取-->

            <form class="form-horizontal" role="form" method="post" id="search_frm">
                {{--
            <div class="row" style="display: none;">
                <div class="col-xs-12">
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
                                         - - }}
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
                </div>
            </div>
            --}}
            <div class="am-u-sm-12 am-u-md-3 am-fr">
                <div class="am-input-group am-input-group-sm">
                    <input type="text" class="am-form-field" name="company_name">
                    <span class="am-input-group-btn">
                        <button class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search search_frm" type="button"></button>
                    </span>
                </div>
            </div>
            </form>
                <table  id="dynamic-table" class="am-table am-table-striped am-table-hover table-main">
                    <thead>
                    <tr>
                        <th class="table-id">ID</th>
                        <th class="table-title">企业名称</th>
                        <th class="table-title">联系人</th>
                        <th class="table-title">联系电话</th>
                        <th class="table-title">城市</th>
                        {{--<th class="table-title">状态</th>--}}
                        <th class="table-title">vip起止</th>
                        <th class="table-date am-hide-sm-only">注册日期</th>
                        <th class="table-date am-hide-sm-only">上次登录</th>
                        <th class="table-title">操作</th>
                    </tr>
                    </thead>
                    <tbody  id="data_list">
                    {{--
                    <tr>
                        <td>2</td>
                        <td>blaijd898</td>
                        <td>周至忠杨农场</td>
                        <td>张富贵</td>
                        <td>15855445282</td>
                        <td>陕西/周至</td>
                        <td>新注册</td>
                        <td class="am-hide-sm-only">2018-5-4--2018-07-04</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"> 修改 </button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（1）</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>blaijd898</td>
                        <td>周至忠杨农场</td>
                        <td>张富贵</td>
                        <td>15855445282</td>
                        <td>陕西/周至</td>
                        <td>新注册</td>
                        <td class="am-hide-sm-only">2018-5-4--2018-07-04</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"> 修改 </button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（1）</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>blaijd898</td>
                        <td>周至忠杨农场</td>
                        <td>张富贵</td>
                        <td>15855445282</td>
                        <td>陕西/周至</td>
                        <td>新注册</td>
                        <td class="am-hide-sm-only">2018-5-4--2018-07-04</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"> 修改 </button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（1）</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>blaijd898</td>
                        <td>周至忠杨农场</td>
                        <td>张富贵</td>
                        <td>15855445282</td>
                        <td>陕西/周至</td>
                        <td>新注册</td>
                        <td class="am-hide-sm-only">2018-5-4--2018-07-04</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"> 修改 </button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（1）</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>blaijd898</td>
                        <td>周至忠杨农场</td>
                        <td>张富贵</td>
                        <td>15855445282</td>
                        <td>陕西/周至</td>
                        <td>新注册</td>
                        <td class="am-hide-sm-only">2018-5-4--2018-07-04</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"> 修改 </button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（1）</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>blaijd898</td>
                        <td>周至忠杨农场</td>
                        <td>张富贵</td>
                        <td>15855445282</td>
                        <td>陕西/周至</td>
                        <td>新注册</td>
                        <td class="am-hide-sm-only">2018-5-4--2018-07-04</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"> 修改 </button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（1）</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>blaijd898</td>
                        <td>周至忠杨农场</td>
                        <td>张富贵</td>
                        <td>15855445282</td>
                        <td>陕西/周至</td>
                        <td>新注册</td>
                        <td class="am-hide-sm-only">2018-5-4--2018-07-04</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"> 修改 </button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（1）</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>blaijd898</td>
                        <td>周至忠杨农场</td>
                        <td>张富贵</td>
                        <td>15855445282</td>
                        <td>陕西/周至</td>
                        <td>新注册</td>
                        <td class="am-hide-sm-only">2018-5-4--2018-07-04</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"> 修改 </button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（1）</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>blaijd898</td>
                        <td>周至忠杨农场</td>
                        <td>张富贵</td>
                        <td>15855445282</td>
                        <td>陕西/周至</td>
                        <td>新注册</td>
                        <td class="am-hide-sm-only">2018-5-4--2018-07-04</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"> 修改 </button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（1）</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>blaijd898</td>
                        <td>周至忠杨农场</td>
                        <td>张富贵</td>
                        <td>15855445282</td>
                        <td>陕西/周至</td>
                        <td>新注册</td>
                        <td class="am-hide-sm-only">2018-5-4--2018-07-04</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"> 修改 </button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（1）</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>blaijd898</td>
                        <td>周至忠杨农场</td>
                        <td>张富贵</td>
                        <td>15855445282</td>
                        <td>陕西/周至</td>
                        <td>新注册</td>
                        <td class="am-hide-sm-only">2018-5-4--2018-07-04</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"> 修改 </button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（1）</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>blaijd898</td>
                        <td>周至忠杨农场</td>
                        <td>张富贵</td>
                        <td>15855445282</td>
                        <td>陕西/周至</td>
                        <td>新注册</td>
                        <td class="am-hide-sm-only">2018-5-4--2018-07-04</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"> 修改 </button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（1）</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    --}}
                    </tbody>
                </table>
                {{--
                <hr>

                <div class="am-cf">

                    <div class="am-fr">
                        <ul class="am-pagination tpl-pagination">
                            <li class="am-disabled"><a href="#">«</a></li>
                            <li class="am-active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">»</a></li>
                        </ul>
                    </div>
                </div>
                --}}
        </div>
    </div>

    <div class="tpl-alert"></div>
@endsection

@push('footscripts')
@endpush

@push('footscripts')
        <!-- 前端模板结束 -->
    <script type="text/javascript">
        const AJAX_URL = "{{ url('api/member/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist
        const ADDNEW_URL = "{{url('member/edit')}}/0";//新加页面地址
        const EDIT_URL = "{{url('member/edit')}}/";//修改页面地址前缀
        const DEL_URL = "{{ url('api/member/ajax_del') }}";//删除页面地址
    </script>
     <script src="{{ asset('/js/lanmu/member.js') }}"  type="text/javascript"></script>
@endpush