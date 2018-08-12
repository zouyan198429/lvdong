@extends('layouts.app')

@push('headscripts')
    {{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="content-header">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="icon icon-home"></i></a></li>
            <li class="active">农事记录</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">农事记录</div>
                </div>
                <div class="panel-body">
                    <!-- PAGE CONTENT BEGINS -->
                    <input type="hidden" value="1" id="page"/><!--当前页号-->
                    <input type="hidden" value="15" id="pagesize"/><!--每页显示数量-->
                    <input type="hidden" value="-1" id="total"/><!--总记录数量,小于0重新获取--> 

                    <div class="table-tools" style="margin-bottom: 15px;">
                        <div class="tools-group">
                            <a href="{{ url('handles/add/' . $pro_unit_id) }}/0" class="btn btn-primary"><i class="icon icon-plus-sign"></i> 记录</a>
                        </div>
                    </div>

                    <div class="list ">
                        <header>
                            <h3>
                                <i class="icon-list-ul"></i> 最新动态
                                {{--<small> 累计 123 条</small>--}}
                            </h3>
                        </header>
                        <div>
                            <div id="dynamic-table">
                                <div id="data_list"  class="items items-hover">

                                </div>
                            </div>
                        </div>
                       
                    </div>
                    {{--
                    <footer>
                        <ul class="pager">
                            <li class="previous"><a href="#">« 上一页</a></li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">⋯</a></li>
                            <li><a href="#">6</a></li>
                            <li class="active"><a href="#">7</a></li>
                            <li><a href="#">8</a></li>
                            <li><a href="#">9</a></li>
                            <li><a href="#">⋯</a></li>
                            <li><a href="#">12</a></li>
                            <li class="next"><a href="#">下一页 »</a></li>
                        </ul>
                    </footer>
                    --}}
                </div>




            </div>
        </div>
    </div>
@endsection


@push('footscripts')

<!-- 前端模板结束 -->
<script type="text/javascript">
    const AJAX_URL = "{{ url('api/handles/' . $pro_unit_id. '/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist
    const ADDNEW_URL = "{{url('comment/' . $pro_unit_id. '/add')}}/";//新加页面地址
    const LIST_URL = "{{url('handles/' . $pro_unit_id)}}";// 列表页面
    const EDIT_URL = "{{url('handles/add/' . $pro_unit_id. '')}}/";//修改页面地址前缀
    const DEL_URL = "{{ url('api/handles/' . $pro_unit_id. '/ajax_del') }}";//删除页面地址
    const COMMON_DEL_URL = "{{ url('api/comment/' . $pro_unit_id. '/ajax_del') }}";
    const PASS_URL = "{{ url('api/comment/' . $pro_unit_id. '/ajax_status') }}";
    const NOT_PASS_URL = "{{ url('api/comment/' . $pro_unit_id. '/ajax_status') }}";
    const INPUTS_DEL_URL = "{{ url('api/inputs/' . $pro_unit_id. '/ajax_del') }}";
</script>
<script src="{{ asset('/js/lanmu/handles.js') }}"  type="text/javascript"></script>
@endpush