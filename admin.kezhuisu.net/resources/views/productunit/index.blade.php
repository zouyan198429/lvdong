@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="tpl-content-page-title">
        生产单元审核
    </div>

    {{--
    <div class="tpl-content-scope">
        <div class="note note-info">
            <p><span class="label label-danger">提示:</span> 备注按钮 主要帮助管理人员，记录该客户购买标签情况等。便于做进一步销售跟踪。</p>
        </div>
    </div>
    --}}

    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 生产单元列表
            </div>
        </div>

        <div class="tpl-block">

            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <button type="button" class="am-btn am-btn-default  change-status" data-status="">全部</button>
                        <button type="button" class="am-btn am-btn-default am-btn-success change-status" data-status="0">待审</button>
                        <button type="button" class="am-btn am-btn-default am-btn-warning change-status" data-status="2"><span class="am-icon-save"></span> 未通过</button>
                        <button type="button" class="am-btn am-btn-default am-btn-secondary change-status" data-status="1"><span class="am-icon-archive"></span> 正常</button>
                        <button type="button" class="am-btn am-btn-default am-btn-danger change-status"  data-status="3"><span class="am-icon-trash-o"></span> 过期</button>
                    </div>
                </div>
            </div>

            <!-- PAGE CONTENT BEGINS -->
            <input type="hidden" value="1" id="page"/><!--当前页号-->
            <input type="hidden" value="20" id="pagesize"/><!--每页显示数量-->
            <input type="hidden" value="-1" id="total"/><!--总记录数量,小于0重新获取-->

            <form class="form-horizontal" role="form" method="post" id="search_frm">
                <input type="hidden" name="status" value=""/>
            <div class="am-u-sm-12 am-u-md-3 am-fr">
                <div class="am-input-group am-input-group-sm">
                    <input type="text" class="am-form-field" name="pro_input_name">
                    <span class="am-input-group-btn">
                        <button class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search  search_frm" type="button"></button>
                    </span>
                </div>
            </div>
            </form>
                <table id="dynamic-table"  class="am-table am-table-striped am-table-hover table-main">
                    <thead>
                    <tr>
                        <th class="table-id">ID</th>
                        <th class="table-title">企业名称</th>
                        <th class="table-title">产品</th>
                        <th class="table-title">类别</th>
                        <th class="table-title">图片</th>
                        <th class="table-title">二维码</th>
                        <th class="table-title">微站预览</th>
                        <th class="table-title">生产周期</th>
                        <th class="table-date am-hide-sm-only">日期</th>
                        <th class="table-title">状态</th>
                        <th class="table-title">操作</th>
                    </tr>
                    </thead>
                    <tbody  id="data_list">
                    {{--
                    <tr>
                        <td>2</td>
                        <td><a href="">周至忠杨农场(ID：8928)</a></td>
                        <td>红富士苹果二代</td>
                        <td>种植/苹果</td>
                        <td><a href=""><img src="{{ asset('assets/img/apple.png') }}" width="50" /></a></td>
                        <td><a href="" ><img src="{{ asset('assets/img/ewm.gif') }}" width="40px" /></a></td>
                        <td><a href="" target="_blank" ><span class="am-btn am-btn-xl am-icon-mobile" ></span></a></td>
                        <td>2018年2月4日--2018年10月4日  </td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td><span class="am-text-danger" >待审</span></td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary">通过</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（1）</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="">周至忠杨农场(ID：8928)</a></td>
                        <td>红富士苹果二代</td>
                        <td>种植/苹果</td>
                        <td><a href=""><img src="{{ asset('assets/img/apple.png') }}" width="50" /></a></td>
                        <td><a href="" ><img src="{{ asset('assets/img/ewm.gif') }}" width="40px" /></a></td>
                        <td><a href="" target="_blank" ><span class="am-btn am-btn-xl am-icon-mobile" ></span></a></td>
                        <td>2018年2月4日--2018年10月4日  </td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td><span class="am-text-danger" >待审</span></td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary">通过</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（3）</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="">周至忠杨农场(ID：8928)</a></td>
                        <td>红富士苹果二代</td>
                        <td>种植/苹果</td>
                        <td><a href=""><img src="{{ asset('assets/img/apple.png') }}" width="50" /></a></td>
                        <td><a href="" ><img src="{{ asset('assets/img/ewm.gif') }}" width="40px" /></a></td>
                        <td><a href="" target="_blank" ><span class="am-btn am-btn-xl am-icon-mobile" ></span></a></td>
                        <td>2018年2月4日--2018年10月4日  </td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td><span class="am-text-danger" >待审</span></td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary">通过</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（1）</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="">周至忠杨农场(ID：8928)</a></td>
                        <td>红富士苹果二代</td>
                        <td>种植/苹果</td>
                        <td><a href=""><img src="{{ asset('assets/img/apple.png') }}" width="50" /></a></td>
                        <td><a href="" ><img src="{{ asset('assets/img/ewm.gif') }}" width="40px" /></a></td>
                        <td><a href="" target="_blank" ><span class="am-btn am-btn-xl am-icon-mobile" ></span></a></td>
                        <td>2018年2月4日--2018年10月4日  </td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td><span class="am-text-danger" >待审</span></td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary">通过</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（0）</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="">周至忠杨农场(ID：8928)</a></td>
                        <td>红富士苹果二代</td>
                        <td>种植/苹果</td>
                        <td><a href=""><img src="{{ asset('assets/img/apple.png') }}" width="50" /></a></td>
                        <td><a href="" ><img src="{{ asset('assets/img/ewm.gif') }}" width="40px" /></a></td>
                        <td><a href="" target="_blank" ><span class="am-btn am-btn-xl am-icon-mobile" ></span></a></td>
                        <td>2018年2月4日--2018年10月4日  </td>
                        <td class="am-hide-sm-only">2018年5月4日 7:28:47</td>
                        <td><span class="am-text-danger" >待审</span></td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary">通过</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（1）</button>
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
    <div id="output"></div>
@endsection

@push('footscripts')
@endpush
@push('footlast')

        <!-- 前端模板结束 -->
    <script type="text/javascript">
        const AJAX_URL = "{{ url('api/productunit/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist
        const EDIT_URL = "{{url('productunit/edit')}}/";//修改页面地址前缀
        const DEL_URL = "{{ url('api/productunit/ajax_del') }}";//删除页面地址
        const CREATE_LABEL_URL = "{{ url('api/productunit/ajax_create_label') }}";//生成防伪标签页面地址
        const PASS_URL = "{{ url('api/productunit/ajax_status') }}";//通过页面地址前缀
        const NOTPASS_URL = "{{ url('api/productunit/ajax_status') }}";//不通过页面地址前缀
        const QRCODE_URL = "{{ url('qrcode') }}";//生成二维码页面地址


    </script>
     <script src="{{ asset('/js/lanmu/productunit.js') }}"  type="text/javascript"></script>
@endpush