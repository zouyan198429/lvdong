@extends('layouts.app')

@push('headscripts')
    {{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="content-header">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="icon icon-home"></i></a></li>
            <li class="active">生产单元</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" >×</button>
                <p>图片用于在微店首页顶部显示。</p>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">生产单元列表</div>
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
                                        @if ($has_add == 1)
                                            <a href="{{ url('productunit/add' . '/0') }}" class="btn btn-primary"><i class="icon icon-plus-sign"></i> 新建生产单元</a>
                                        @else
                                            <a href="javascript:void(0);" class="btn btn-primary"><i class="icon icon-plus-sign"></i> 新建生产单元</a>
                                            {{ $tishi }}
                                        @endif
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
                                        <th>批次</th>
                                        <th>产品</th>
                                        <th>图片</th>
                                        <th>生产周期</th>
                                        {{--<th>负责人</th>--}}
                                        <th>创建时间</th>
                                        <th>状态</th>
                                        <th style="width:130px;">操作</th>
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

<!-- 前端模板结束 -->
<script type="text/javascript">
    const AJAX_URL = "{{ url('api/productunit/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist
    const EDIT_URL = "{{url('productunit/add')}}/";
    const DEL_URL = "{{ url('api/productunit/ajax_del') }}";
    var OPERATE_TYPE = <?php echo isset($operate_type)?$operate_type:0; ?>;
</script>
<script src="{{ asset('/js/lanmu/productunit.js') }}"  type="text/javascript"></script>
@endpush