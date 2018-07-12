@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="tpl-content-page-title">
        订单中心
    </div>


    <div class="tpl-content-scope">
        <div class="note note-info">
            <p><span class="label label-danger">提示:</span> 备注按钮 主要帮助管理人员，记录该客户购买标签情况等。便于做进一步销售跟踪。</p>
        </div>
    </div>


    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 付款记录
            </div>
        </div>
        <div class="tpl-block">

            <form class="am-form">
                <table class="am-table am-table-striped am-table-hover table-main">
                    <thead>
                    <tr>
                        <th class="table-id">ID</th>
                        <th class="table-title">用户</th>
                        <th class="table-title">订单产品</th>
                        <th class="table-title">下单时间</th>
                        <th class="table-title">订单单号</th>
                        <th class="table-title">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>2</td>
                        <td><a href="">周至忠杨农场(ID：8928)</a></td>
                        <td>首年会员（2400元）</td>
                        <td>2018-06-04 16:17:49 </td>
                        <td>WMB_1528100253</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary">查看</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="">周至忠杨农场(ID：8928)</a></td>
                        <td>首年会员（2400元）</td>
                        <td>2018-06-04 16:17:49 </td>
                        <td>WMB_1528100253</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary">查看</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="">周至忠杨农场(ID：8928)</a></td>
                        <td>首年会员（2400元）</td>
                        <td>2018-06-04 16:17:49 </td>
                        <td>WMB_1528100253</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary">查看</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="">周至忠杨农场(ID：8928)</a></td>
                        <td>首年会员（2400元）</td>
                        <td>2018-06-04 16:17:49 </td>
                        <td>WMB_1528100253</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary">查看</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="">周至忠杨农场(ID：8928)</a></td>
                        <td>首年会员（2400元）</td>
                        <td>2018-06-04 16:17:49 </td>
                        <td>WMB_1528100253</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary">查看</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="">周至忠杨农场(ID：8928)</a></td>
                        <td>首年会员（2400元）</td>
                        <td>2018-06-04 16:17:49 </td>
                        <td>WMB_1528100253</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary">查看</button>
                                </div>
                            </div>
                        </td>
                    </tr>









                    </tbody>
                </table>
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


            </form>
        </div>
    </div>


    <div class="tpl-alert"></div>
@endsection

@push('footscripts')
@endpush