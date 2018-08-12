@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="tpl-content-page-title">
        新闻公告
    </div>

    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 新闻列表
            </div>
        </div>
        <!-- PAGE CONTENT BEGINS -->
        <input type="hidden" value="1" id="page"/><!--当前页号-->
        <input type="hidden" value="20" id="pagesize"/><!--每页显示数量-->
        <input type="hidden" value="-1" id="total"/><!--总记录数量,小于0重新获取-->

        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-6">
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group am-btn-group-xs">
                            <a  href="{{ url('news/edit/0') }}" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 新增</a>
                        </div>
                    </div>
                </div>
            </div>
                <table  id="dynamic-table"  class="am-table am-table-striped am-table-hover table-main">
                    <thead>
                    <tr>
                        <th class="table-id">ID</th>
                        <th class="table-title">标题</th>
                        {{--<th class="table-title">阅读权限</th>--}}
                        <th class="table-title" >浏览量</th>
                        <th class="table-date am-hide-sm-only" width="180">修改日期</th>
                        <th class="table-set" width="160">操作</th>
                    </tr>
                    </thead>
                    <tbody  id="data_list">
                    {{--
                    <tr>
                        <td>2</td>
                        <td><a href="#">河北冬小麦进入收获期 百万农机齐上阵</a></td>
                        <td>全部</td>
                        <td>234</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 编辑</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="#">河北冬小麦进入收获期 百万农机齐上阵</a><span class="am-text-danger" >【图】</span></td>
                        <td>养殖</td>
                        <td>234</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 编辑</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="#">河北冬小麦进入收获期 百万农机齐上阵</a></td>
                        <td>种植</td>
                        <td>234</td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 编辑</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    --}}

                    </tbody>
                </table>
        </div>
    </div>


    <div class="tpl-alert"></div>
@endsection

@push('footscripts')
@endpush
@push('footlast')

<!-- 前端模板结束 -->
<script type="text/javascript">
    const AJAX_URL = "{{ url('api/news/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist
    const EDIT_URL = "{{url('news/edit')}}/";//修改页面地址前缀
    const DEL_URL = "{{ url('api/news/ajax_del') }}";//删除页面地址
</script>
<script src="{{ asset('/js/lanmu/news.js') }}"  type="text/javascript"></script>
@endpush