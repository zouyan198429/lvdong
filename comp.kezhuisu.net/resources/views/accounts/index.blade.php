@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
<div class="content-header">
    <ul class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="icon icon-home"></i></a></li>
        <li class="active">帐号管理</li>
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
                <div class="panel-title">帐号管理</div>
            </div>
            <div class="panel-body">

                <!-- PAGE CONTENT BEGINS -->
                <input type="hidden" value="1" id="page"/><!--当前页号-->
                <input type="hidden" value="10" id="pagesize"/><!--每页显示数量-->
                <input type="hidden" value="-1" id="total"/><!--总记录数量,小于0重新获取-->


                <div class="hr hr-18 dotted hr-double"></div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="table-header">
                            <div class="table-tools" style="margin-bottom: 15px;">
                                <div class="tools-group">
                                    <a href="{{ url('accounts/add/0') }}" class="btn btn-primary"><i class="icon icon-plus-sign"></i> 增加新帐号</a>
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
                                        <th>用户ID</th>
                                        <th>用户名</th>
                                        <th>微信号</th>
                                        <th>真实姓名</th>
                                        <th>手机号</th>
                                        <th>创建时间</th>
                                        <th>状态</th>
                                        <th>记录审核权限</th>
                                        <th style="width:130px;">操作</th>
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
                                <th width="120">用户名</th>
                                <th>微信号</th>
                                <th>真实姓名</th>
                                <th width="120">手机号</th>
                                <th width="180">创建时间</th>
                                <th width="120">状态</th>
                                <th width="120">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>buyilang77</td>
                                <td>18992800832</td>
                                <td>吕东兴</td>
                                <td>18992800832</td>
                                <td>2018-05-10 10:20</td>
                                <td><span class="text-green">正常</span></td>
                                <td>
                                    <a href="#" class="btn btn-xs btn-primary">编辑</a>
                                    <a href="#" class="btn btn-xs btn-danger">删除</a>
                                </td>
                            </tr>
                            <tr>
                                <td>buyilang77</td>
                                <td>18992800832</td>
                                <td>吕东兴</td>
                                <td>18992800832</td>
                                <td>2018-05-10 10:20</td>
                                <td><span class="text-green">正常</span></td>
                                <td>
                                    <a href="#" class="btn btn-xs btn-primary">编辑</a>
                                    <a href="#" class="btn btn-xs btn-danger">删除</a>
                                </td>
                            </tr>
                            <tr>
                                <td>buyilang77</td>
                                <td>18992800832</td>
                                <td>吕东兴</td>
                                <td>18992800832</td>
                                <td>2018-05-10 10:20</td>
                                <td><span class="text-gray">冻结</span></td>
                                <td>
                                    <a href="#" class="btn btn-xs btn-primary">编辑</a>
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
<script type="text/javascript">
var OPERATE_TYPE = <?php echo isset($operate_type)?$operate_type:0; ?>;
const AJAX_URL = "{{ url('api/accounts/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist
const EDIT_URL = "{{url('accounts/add')}}/";//修改页面地址前缀
const DEL_URL = "{{ url('api/accounts/ajax_del') }}";//删除页面地址

</script>
<script src="{{ asset('/js/lanmu/account.js') }}"  type="text/javascript"></script>
@endpush