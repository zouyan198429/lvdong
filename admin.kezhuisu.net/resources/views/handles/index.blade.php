@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="tpl-content-page-title">
        生产日志
    </div>

    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 生产日志
            </div>
        </div>
        <!-- PAGE CONTENT BEGINS -->
        <input type="hidden" value="1" id="page"/><!--当前页号-->
        <input type="hidden" value="20" id="pagesize"/><!--每页显示数量-->
        <input type="hidden" value="-1" id="total"/><!--总记录数量,小于0重新获取-->

        <div class="tpl-block">
            <form class="am-form">
                <table  id="dynamic-table"  class="am-table am-table-striped am-table-hover table-main">
                    <thead>
                    <tr>
                        <th class="table-id">ID</th>
                        <th class="table-title"  width="250px">企业ID</th>
                        <th class="table-title">文字</th>
                        <th class="table-title"  width="400px">图片</th>
                        <th class="table-title" width="100px">是否公开</th>
                        <th class="table-date am-hide-sm-only">日期</th>
                    </tr>
                    </thead>
                    <tbody  id="data_list"> 
                    </tbody>
                </table> 
            </form>
        </div>
    </div>


    <div class="tpl-alert"></div>
@endsection

@push('footscripts')
@endpush
@push('footlast')

<!-- 前端模板结束 -->
<script type="text/javascript">
    const AJAX_URL = "{{ url('api/handles/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist

</script>
<script src="{{ asset('/js/lanmu/handles.js') }}"  type="text/javascript"></script>
@endpush