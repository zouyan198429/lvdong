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
    const AJAX_URL = "{{ url('api/new/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist

</script>
<script src="{{ asset('/js/lanmu/new.js') }}"  type="text/javascript"></script>
@endpush