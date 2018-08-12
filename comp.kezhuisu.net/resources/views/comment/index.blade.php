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


                    <div class="hr hr-18 dotted hr-double"></div>
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="table-header">
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
                </div>
            </div>
        </div>
    </div>
@endsection


@push('footscripts')

<!-- 前端模板结束 -->
<script type="text/javascript">
    const AJAX_URL = "{{ url('api/comment/' . $pro_unit_id. '/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist
    const EDIT_URL = "{{url('comment/' . $pro_unit_id. '/add')}}/";//修改页面地址前缀
    const COMMON_DEL_URL = "{{ url('api/comment/' . $pro_unit_id. '/ajax_del') }}";
    const PASS_URL = "{{ url('api/comment/' . $pro_unit_id. '/ajax_status') }}";
    const NOT_PASS_URL = "{{ url('api/comment/' . $pro_unit_id. '/ajax_status') }}";
    var OPERATE_TYPE = <?php echo isset($operate_type)?$operate_type:0; ?>;

</script>
<script src="{{ asset('/js/lanmu/comment.js') }}"  type="text/javascript"></script>
@endpush