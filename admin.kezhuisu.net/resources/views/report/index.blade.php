@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="tpl-content-page-title">
        检测报告
    </div>

    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 检测报告列表
            </div>
        </div>
        <!-- PAGE CONTENT BEGINS -->
        <input type="hidden" value="1" id="page"/><!--当前页号-->
        <input type="hidden" value="20" id="pagesize"/><!--每页显示数量-->
        <input type="hidden" value="-1" id="total"/><!--总记录数量,小于0重新获取-->

        <div class="tpl-block">
            <form class="am-form">
                <table id="dynamic-table" class="am-table am-table-striped am-table-hover table-main">
                    <thead>
                    <tr>
                        <th class="table-id">ID</th>
                        <th class="table-title">企业</th>
                        <th class="table-title">报告图片</th>
                        <th class="table-title">名称</th>
                        <th class="table-date am-hide-sm-only" width="180">上传日期</th>
                    </tr>
                    </thead>
                    <tbody  id="data_list">
                    {{--
                    <tr>
                        <td>2</td>
                        <td>咸阳三通农业合作社</td>
                        <td><a href=""><img src="{{ asset('assets/img/doc.jpg') }}" width="60" /></a></td>
                        <td>有机产品检测报告</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>咸阳三通农业合作社</td>
                        <td><a href=""><img src="{{ asset('assets/img/doc.jpg') }}" width="60" /></a></td>
                        <td>有机产品检测报告</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>咸阳三通农业合作社</td>
                        <td><a href=""><img src="{{ asset('assets/img/doc.jpg') }}" width="60" /></a></td>
                        <td>有机产品检测报告</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>咸阳三通农业合作社</td>
                        <td><a href=""><img src="{{ asset('assets/img/doc.jpg') }}" width="60" /></a></td>
                        <td>有机产品检测报告</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>咸阳三通农业合作社</td>
                        <td><a href=""><img src="{{ asset('assets/img/doc.jpg') }}" width="60" /></a></td>
                        <td>有机产品检测报告</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>咸阳三通农业合作社</td>
                        <td><a href=""><img src="{{ asset('assets/img/doc.jpg') }}" width="60" /></a></td>
                        <td>有机产品检测报告</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>咸阳三通农业合作社</td>
                        <td><a href=""><img src="{{ asset('assets/img/doc.jpg') }}" width="60" /></a></td>
                        <td>有机产品检测报告</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
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
    const AJAX_URL = "{{ url('api/report/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist

</script>
<script src="{{ asset('/js/lanmu/report.js') }}"  type="text/javascript"></script>
@endpush