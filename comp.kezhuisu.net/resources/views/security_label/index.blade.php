@extends('layouts.app')

@push('headscripts')
    {{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="content-header">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="icon icon-home"></i></a></li>
            <li class="active">防伪标签</li>
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
                    <div class="panel-title">防伪标签</div>
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
                                        {{--
                                        <a href="{{ url('security_label/' . $pro_unit_id. '/add/0') }}" class="btn btn-primary"><i class="icon icon-plus-sign"></i> 手动添加防伪标签</a>
                                        <a href="javascript:void(0);" class="btn btn-primary auto_create"><i class="icon icon-plus-sign"></i> 自动生成1000防伪标签</a>--}}
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
                                        {{--<th>类别</th>--}}
                                        {{--<th>图片</th>--}}
                                        <th>防伪标签</th>
                                        {{--<th>状态</th>--}}
                                        {{--<th>厂家</th>--}}
                                        {{--<th>创建时间</th>--}}
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
    const AJAX_URL = "{{ url('api/security_label/' . $pro_unit_id. '/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist
    const SECURITY_LABEL_EDIT_URL = "{{url('security_label/' . $pro_unit_id. '/add')}}/";
    const SECURITY_LABEL_DEL_URL = "{{ url('api/security_label/' . $pro_unit_id. '/ajax_del') }}";
    var OPERATE_TYPE = <?php echo isset($operate_type)?$operate_type:0; ?>;
</script>
<script src="{{ asset('/js/lanmu/security_label.js') }}"  type="text/javascript"></script>
@endpush