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
                <div class="row" style="display: none;">
                <div class="col-xs-12">
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label for="supplier_name" class="col-sm-3 control-label no-padding-right" >供应商名称:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="供应商名称" value="">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <label for="supplier_province_id" class="col-sm-3 control-label no-padding-right" >所在地:</label>
                                <div class="col-sm-9">
                                    {{--

                                        $area_params =array(
                                                'province_id'=>'supplier_province_id',
                                                'city_id'=>'supplier_city_id',
                                                'area_id'=>'supplier_area_id'
                                        );
                                        sfdgthis-> lfdgoad ->viegdsfg w('pudfgdgblic/area_select/area_select',$area_params);
                                         --}}
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label for="supplier_status" class="col-sm-3 control-label no-padding-right" >供应商状态:</label>
                                <div class="col-sm-9">
                                    <select class="chosen-select form-control" id="supplier_status" name="supplier_status" data-placeholder="请选择状态">
                                        <option value="" selected="selected">全部</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="supplier_is_open" class="col-sm-3 control-label no-padding-right" >启用状态:</label>
                                <div class="col-sm-9">

                                    <select class="chosen-select form-control" id="supplier_is_open" name="supplier_is_open" data-placeholder="请选择状态">
                                        <option value="" selected="selected">全部</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="supplier_person" class="col-sm-3 control-label no-padding-right" >供应商联系人:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="supplier_person" name="supplier_person" placeholder="供应商联系人" value="">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-4">
                                <label for="supplier_sale_name" class="col-sm-3 control-label no-padding-right" >业务员:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="supplier_sale_name" name="supplier_sale_name" placeholder="业务员" value="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="supplier_create_name" class="col-sm-3 control-label no-padding-right" >创建人:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="supplier_create_name" name="supplier_create_name" placeholder="创建人" value="">
                                </div>
                            </div>

                            <div class=" col-sm-4">
                                <button class="btn btn-info search_frm" type="button">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    查询
                                </button>

                                &nbsp; &nbsp; &nbsp;
                                <button class="btn" type="reset">
                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                    重置
                                </button>
                            </div>
                        </div>
                </div>
            </div>
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
        const DYNAMIC_PAGE_BAIDU_TEMPLATE= "baidu_template_data_page";//分页百度模板id
        const DYNAMIC_TABLE = 'dynamic-table';//动态表格id
        const AJAX_URL = "{{ url('api/productunit/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist
        const DYNAMIC_BAIDU_TEMPLATE = "baidu_template_data_list";//百度模板id
        const DYNAMIC_TABLE_BODY = "data_list";//数据列表id
        const DYNAMIC_LODING_BAIDU_TEMPLATE = "baidu_template_data_loding";//加载中百度模板id
        const DYNAMIC_BAIDU_EMPTY_TEMPLATE = "baidu_template_data_empty";//没有数据记录百度模板id
        const FRM_IDS = "search_frm";//需要读取的表单的id，多个用,号分隔
        const SURE_FRM_IDS = "search_sure_form";//确认搜索条件需要读取的表单的id，多个用,号分隔
        const PAGE_ID = "page";//当前页id
        const PAGE_SIZE = Math.ceil(parseInt($('#pagesize').val()));;//每页显示数量
        const TOTAL_ID = "total";//总记录数量[特别说明:小于0,需要从数据库重新获取]

        $(function(){
            //读取第一页数据
            ajaxPageList(DYNAMIC_TABLE,DYNAMIC_PAGE_BAIDU_TEMPLATE,AJAX_URL,false,SURE_FRM_IDS,true,DYNAMIC_BAIDU_TEMPLATE,DYNAMIC_TABLE_BODY,DYNAMIC_LODING_BAIDU_TEMPLATE,DYNAMIC_BAIDU_EMPTY_TEMPLATE,PAGE_ID,PAGE_SIZE,TOTAL_ID);
            //查询
            $('.search_frm').click(function(){
                $("#"+PAGE_ID).val(1);//重归第一页
                //获得搜索表单的值
                append_sure_form(SURE_FRM_IDS,FRM_IDS);//把搜索表单值转换到可以查询用的表单中
                reset_list(false);
            });
            $(document).on("click",".qrcode",function(){
                var url = $(this).data('url');
                qrcode(url);
                return false;
            });
            $(document).on("click",".change-status",function(){
                var status = $(this).data('status');
                $('input[name=status]').val(status);
                $('.search_frm').click();
                return false;
            });
        });

        //重载列表
        //is_read_page 是否读取当前页,否则为第一页 true:读取,false默认第一页
        function reset_list(is_read_page){
            //重新读取数据
            ajaxPageList(DYNAMIC_TABLE,DYNAMIC_PAGE_BAIDU_TEMPLATE,AJAX_URL,is_read_page,SURE_FRM_IDS,true,DYNAMIC_BAIDU_TEMPLATE,DYNAMIC_TABLE_BODY,DYNAMIC_LODING_BAIDU_TEMPLATE,DYNAMIC_BAIDU_EMPTY_TEMPLATE,PAGE_ID,PAGE_SIZE,TOTAL_ID);
        }
        //业务逻辑部分
        var action = {
            show : function(id){
//        //location.href='/pms/Supplier/show?supplier_id='+id;
//        var weburl = '/pms/Supplier/show?supplier_id='+id+"&operate_type=1";
//        var tishi = "查看供应商";
//        layeriframe(weburl,tishi,950,600,0);
                return false;
            },
            edit : function(id){
                go("{{url('productunit/edit')}}/" + id);
                return false;
                //location.href='/pms/Supplier/modify?supplier_id='+id;
//        var weburl = '/pms/Supplier/modify?supplier_id='+id+"&operate_type=1";
//        var tishi = "修改供应商";
//        layeriframe(weburl,tishi,950,600,0);
                return false;
            },
            del : function(id){
                var index_query = layer.confirm('确定删除当前记录？删除后不可恢复!', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    operate_ajax('del',id);
                    layer.close(index_query);
                }, function(){
                });
                return false;
                {{--
               var sure_cancel_data = {
                   'content':'确定删除当前记录？删除后不可恢复! ',//提示文字
                   'sure_event':'del_sure('+id+');',//确定
                };
               sure_cancel_alert(sure_cancel_data);
               return false;--}}
            },
            pass : function(id){
                var index_query = layer.confirm('确定审核通过当前记录？', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    operate_ajax('pass',id);
                    layer.close(index_query);
                }, function(){
                });
                return false;
            },
            notpass : function(id){
                var index_query = layer.confirm('确定审核不通过当前记录？', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    operate_ajax('notpass',id);
                    layer.close(index_query);
                }, function(){
                });
                return false;
            }
        };

        //操作
        function operate_ajax(operate_type,id){
            if(operate_type=='' || id==''){
                err_alert('请选择需要操作的数据');
                return false;
            }
            var operate_txt = "";
            var data ={};
            var ajax_url = "";
            switch(operate_type)
            {
                case 'del'://删除
                    operate_txt = "删除";
                    data = {'id':id}
                    ajax_url = "{{ url('api/productunit/ajax_del') }}";// /pms/Supplier/ajax_del?operate_type=1
                    break;
                case 'pass'://审核通过
                    operate_txt = "审核通过";
                    data = {'id':id,'status':1}
                    ajax_url = "{{ url('api/productunit/ajax_status') }}";// /pms/Supplier/ajax_del?operate_type=1
                    break;
                case 'notpass'://审核不通过
                    operate_txt = "审核不通过";
                    data = {'id':id,'status':2}
                    ajax_url = "{{ url('api/productunit/ajax_status') }}";// /pms/Supplier/ajax_del?operate_type=1
                    break;
//        case 'batch_del'://批量删除
//            operate_txt = "批量删除";
//            data = {'supplier_id':id}
//            ajax_url = "/pms/Supplier/ajax_del?operate_type=2";
//            break;
                default:
                    break;
            }
            var layer_index = layer.load();//layer.msg('加载中', {icon: 16});
            $.ajax({
                'type' : 'POST',
                'url' : ajax_url,//'/pms/Supplier/ajax_del',
                'data' : data,
                'dataType' : 'json',
                'success' : function(ret){
                    if(!ret.apistatus){//失败
                        //alert('失败');
                        // countdown_alert(ret.errorMsg,0,5);
                        layer_alert(ret.errorMsg,0,0);
                    }else{//成功
                        var msg = ret.errorMsg;
                        if(msg === ""){
                            msg = operate_txt+"成功";
                        }
                        // countdown_alert(msg,1,5);
                        layer_alert(msg,1,0);
                        reset_list(true);
                    }
                    layer.close(layer_index)//手动关闭
                }
            });
        }
        function qrcode(url){
            window.open("{{ url('qrcode') }}?url=" + encodeURIComponent(url));
        }
    </script>

    <!-- 前端模板部分 -->
    <!-- 列表模板部分 开始-->
    <script type="text/template"  id="baidu_template_data_list">
        <%for(var i = 0; i<data_list.length;i++){
        var item = data_list[i];
        var status = item.status;
        %>
        <tr>
            <td><%=item.id%></td>
            <td><a href="{{url('member/edit/')}}/<%=item.company_id%>"><%=item.company_name%>(ID：<%=item.company_id%>)</a></td>
            <td><%=item.pro_input_name%></td>
            <td><%=item.site_unit_name%></td>
            <td><a href="#"><img src="<%=item.pic_url%>" width="50" /></a></td>
            <td><a href="javascript:void(0);" class="qrcode" data-url="<%=item.weburl%>" ><img src="{{ asset('assets/img/ewm.gif') }}" width="40px" /></a></td>
            <td><a href="<%=item.weburl%>" target="_blank" ><span class="am-btn am-btn-xl am-icon-mobile" ></span></a></td>
            <td><%=item.begin_time%>--<%=item.end_time%>  </td>
            <td class="am-hide-sm-only"><%=item.created_at%></td>
            <td><span class="am-text-danger" ><%=item.status_text%></span></td>
            <td>
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                    <%if(status == 0){%>
                        <button class="am-btn am-btn-default am-btn-xs am-text-secondary"  onclick="action.pass(<%=item.id%>)">通过</button>
                        <button class="am-btn am-btn-default am-btn-xs am-text-secondary"  onclick="action.notpass(<%=item.id%>)">不通过</button>
                        <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" onclick="action.del(<%=item.id%>)"><span class="am-icon-trash-o"></span> 删除</button>
                    <%}%>
                        <%if(false){%>
                        <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（1）</button>
                        <%}%>
                    </div>
                </div>
            </td>
        </tr>
<%}%>
</script>
<!-- 列表模板部分 结束-->
@endpush