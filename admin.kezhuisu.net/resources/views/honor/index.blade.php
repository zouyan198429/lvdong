@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="tpl-content-page-title">
        企业资质审核
    </div>

    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 企业资质列表
            </div>
        </div>
        <!-- PAGE CONTENT BEGINS -->
        <input type="hidden" value="1" id="page"/><!--当前页号-->
        <input type="hidden" value="20" id="pagesize"/><!--每页显示数量-->
        <input type="hidden" value="-1" id="total"/><!--总记录数量,小于0重新获取-->

        <div class="tpl-block">
            <table  id="dynamic-table"   class="am-table am-table-striped am-table-hover table-main">
                    <thead>
                    <tr>
                        <th class="table-id">ID</th>
                        <th class="table-title">企业名称</th>
                        <th class="table-title">联系人</th>
                        <th class="table-title">联系电话</th>
                        <th class="table-title">城市</th>
                        <th class="table-title">图片</th>
                        <th class="table-date am-hide-sm-only">日期</th>
                        <th class="table-title">状态</th>
                        <th class="table-title" width="150">操作</th>
                    </tr>
                    </thead>
                    <tbody  id="data_list">
                    {{--
                    <tr>
                        <td>2</td>
                        <td><a href="">周至忠杨农场</a></td>
                        <td>张富贵</td>
                        <td>15855445282</td>
                        <td>陕西/周至</td>
                        <td><a href="#"><img src="{{ asset('assets/img/zizhi.jpg') }}" width="50" /></a></td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span>通过</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="">周至忠杨农场</a></td>
                        <td>张富贵</td>
                        <td>15855445282</td>
                        <td>陕西/周至</td>
                        <td><a href="#"><img src="{{ asset('assets/img/zizhi.jpg') }}" width="50" /></a></td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span>通过</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="">周至忠杨农场</a></td>
                        <td>张富贵</td>
                        <td>15855445282</td>
                        <td>陕西/周至</td>
                        <td><a href="#"><img src="{{ asset('assets/img/zizhi.jpg') }}" width="50" /></a></td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span>通过</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="">周至忠杨农场</a></td>
                        <td>张富贵</td>
                        <td>15855445282</td>
                        <td>陕西/周至</td>
                        <td><a href="#"><img src="{{ asset('assets/img/zizhi.jpg') }}" width="50" /></a></td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span>通过</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="">周至忠杨农场</a></td>
                        <td>张富贵</td>
                        <td>15855445282</td>
                        <td>陕西/周至</td>
                        <td><a href="#"><img src="{{ asset('assets/img/zizhi.jpg') }}" width="50" /></a></td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span>通过</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="">周至忠杨农场</a></td>
                        <td>张富贵</td>
                        <td>15855445282</td>
                        <td>陕西/周至</td>
                        <td><a href="#"><img src="{{ asset('assets/img/zizhi.jpg') }}" width="50" /></a></td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span>通过</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
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
@push('footlast')

<!-- 前端模板结束 -->
<script type="text/javascript">
    const AJAX_URL = "{{ url('api/honor/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist
    const EDIT_URL = "{{url('honor/edit')}}/";//修改页面地址前缀
    const DEL_URL = "{{ url('api/honor/ajax_del') }}";//删除页面地址
    const NOTPASS_URL = "{{ url('api/honor/ajax_status') }}";//审核不通过页面地址
    const PASS_URL = "{{ url('api/honor/ajax_status') }}";//审核通过页面地址

</script>
<script src="{{ asset('/js/lanmu/honor.js') }}"  type="text/javascript"></script>
@endpush