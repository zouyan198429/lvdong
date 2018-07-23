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
const DYNAMIC_PAGE_BAIDU_TEMPLATE= "baidu_template_data_page";//分页百度模板id
const DYNAMIC_TABLE = 'dynamic-table';//动态表格id
const AJAX_URL = "{{ url('api/handles/' . $pro_unit_id. '/ajax_alist') }}";//ajax请求的url/pms/Supplier/ajax_alist
const DYNAMIC_BAIDU_TEMPLATE = "baidu_template_data_list";//百度模板id
const DYNAMIC_TABLE_BODY = "data_list";//数据列表id
const DYNAMIC_LODING_BAIDU_TEMPLATE = "baidu_template_data_loding";//加载中百度模板id
const DYNAMIC_BAIDU_EMPTY_TEMPLATE = "baidu_template_data_empty";//没有数据记录百度模板id
// const FRM_IDS = "search_frm";//需要读取的表单的id，多个用,号分隔
const SURE_FRM_IDS = "search_sure_form";//确认搜索条件需要读取的表单的id，多个用,号分隔
const PAGE_ID = "page";//当前页id
const PAGE_SIZE = Math.ceil(parseInt($('#pagesize').val()));;//每页显示数量
const TOTAL_ID = "total";//总记录数量[特别说明:小于0,需要从数据库重新获取]

$(function(){
    //读取第一页数据
    ajaxPageList(DYNAMIC_TABLE,DYNAMIC_PAGE_BAIDU_TEMPLATE,AJAX_URL,false,SURE_FRM_IDS,true,DYNAMIC_BAIDU_TEMPLATE,DYNAMIC_TABLE_BODY,DYNAMIC_LODING_BAIDU_TEMPLATE,DYNAMIC_BAIDU_EMPTY_TEMPLATE,PAGE_ID,PAGE_SIZE,TOTAL_ID);

    //修改按钮
    $(document).on("click",".edit_record",function(){
        var id = $(this).data('id');
        go("{{url('handles/add/' . $pro_unit_id. '')}}/" + id);
    });

    //删除按钮
    $(document).on("click",".del_record",function(){
        var id = $(this).data('id');
        var index_query = layer.confirm('您确定删除吗？不可恢复!', {
            btn: ['确定','取消'] //按钮
        }, function(){
            layer.close(index_query);
            ajax_form(id);
        }, function(){
        });
        return false;
    });
});

//重载列表
function reset_list(){
    //重新读取数据
    ajaxPageList(DYNAMIC_TABLE,DYNAMIC_PAGE_BAIDU_TEMPLATE,AJAX_URL,true,SURE_FRM_IDS,true,DYNAMIC_BAIDU_TEMPLATE,DYNAMIC_TABLE_BODY,DYNAMIC_LODING_BAIDU_TEMPLATE,DYNAMIC_BAIDU_EMPTY_TEMPLATE,PAGE_ID,PAGE_SIZE,TOTAL_ID);
}

//ajax提交表单
function ajax_form(id){
    var data = {'id':id};
    console.log("{{ url('api/handles/' . $pro_unit_id. '/ajax_del') }}");
    console.log(data);
    var layer_index = layer.load();
    $.ajax({
        'type' : 'POST',
        'url' : '{{ url('api/handles/' . $pro_unit_id. '/ajax_del') }}',
        'data' : data,
        'dataType' : 'json',
        'success' : function(ret){
            console.log(ret);
            if(!ret.apistatus){//失败
                //alert('失败');
                err_alert(ret.errorMsg);
            }else{//成功
                go("{{url('handles/' . $pro_unit_id)}}");
                // var supplier_id = ret.result['supplier_id'];
                //if(SUPPLIER_ID_VAL <= 0 && judge_integerpositive(supplier_id)){
                //    SUPPLIER_ID_VAL = supplier_id;
                //    $('input[name="supplier_id"]').val(supplier_id);
                //}
                // save_success();
            }
            layer.close(layer_index)//手动关闭
        }
    })
    return false;
}

//业务逻辑部分
var action = {
show : function(id){
    //location.href='/pms/Supplier/show?supplier_id='+id;
    var weburl = '/pms/Supplier/show?supplier_id='+id+"&operate_type=1";
    var tishi = "查看供应商";
    layeriframe(weburl,tishi,950,600,0);
    return false;
},
edit : function(id){
    go("{{url('comment/' . $pro_unit_id. '/add')}}/" + id);
    return false;
    //location.href='/pms/Supplier/modify?supplier_id='+id;
    var weburl = '/pms/Supplier/modify?supplier_id='+id+"&operate_type=1";
    var tishi = "修改供应商";
    layeriframe(weburl,tishi,950,600,0);
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

//导出excel -> 确定按钮
function excel_sure(){
    sure_cancel_cancel();//隐藏弹出层显示对象
    append_sure_form(SURE_FRM_IDS,FRM_IDS);//把搜索表单值转换到可以查询用的表单中
    var parames = get_frm_param(SURE_FRM_IDS);
    var url = '/pms/Supplier/export';
    if(parames.length>0){
        url += "?"+parames;
    }
    window.open(url);
    /*
    if($("#"+SURE_FRM_IDS).length>0){
        $("#"+SURE_FRM_IDS).attr("action","/pms/Supplier/export");
        $("#"+SURE_FRM_IDS).attr("target","_blank");
        $("#"+SURE_FRM_IDS).submit();
    }else{
        window.open ('/pms/Supplier/export');
    }
    **/
}

//删除 -> 确定按钮
function del_sure(id){
    sure_cancel_cancel();//隐藏弹出层显示对象
    //ajax删除数据
    operate_ajax('del',id);
}
//批量删除
function batch_del(){
    sure_cancel_cancel();//隐藏弹出层显示对象
    var ids = get_list_checked(DYNAMIC_TABLE_BODY,1,1);
    //ajax删除数据
    operate_ajax('batch_del',ids);
}

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
            ajax_url = "{{ url('api/comment/' . $pro_unit_id. '/ajax_del') }}";// /pms/Supplier/ajax_del?operate_type=1
            break;
       case 'pass'://审核通过
            operate_txt = "审核通过";
            data = {'id':id,'status':1}
            ajax_url = "{{ url('api/comment/' . $pro_unit_id. '/ajax_status') }}";// /pms/Supplier/ajax_del?operate_type=1
            break;
       case 'notpass'://审核不通过
            operate_txt = "审核不通过";
            data = {'id':id,'status':2}
            ajax_url = "{{ url('api/comment/' . $pro_unit_id. '/ajax_status') }}";// /pms/Supplier/ajax_del?operate_type=1
            break;
        case 'batch_del'://批量删除
            operate_txt = "批量删除";
            data = {'supplier_id':id}
            ajax_url = "/pms/Supplier/ajax_del?operate_type=2";
            break;
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
                reset_list();
            }
            layer.close(layer_index)//手动关闭
        }
    });
}


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
            ajax_url = "{{ url('api/inputs/' . $pro_unit_id. '/ajax_del') }}";// /pms/Supplier/ajax_del?operate_type=1
            break;
        case 'batch_del'://批量删除
            operate_txt = "批量删除";
            data = {'supplier_id':id}
            ajax_url = "/pms/Supplier/ajax_del?operate_type=2";
            break;
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
                reset_list();
            }
            layer.close(layer_index)//手动关闭
        }
    });
}

</script>

    <!-- 前端模板部分 -->
    <!-- 列表模板部分 开始-->
    <script type="text/template"  id="baidu_template_data_list">
        <%for(var i = 0; i<data_list.length;i++){
        var item = data_list[i];
        var imgArr = item.pic_urls;
        %>
        <div class="item">
            <div class="item-heading">
                <div class="pull-right"><span class="text-muted"><%=item.created_at%></span>  </div>
        <h4><a href="###">发布人：<%=item.real_name%></a></h4>
    </div>
    <div class="item-content">
        <div class="text">
        <%=item.record_intro%>
        </div>
    </div>
    <%for(var j = 0; j<imgArr.length;j++){
        var picItem = imgArr[j];
        %>
        <img data-toggle="lightbox"  src="<%=picItem%>" alt="" width=180 />

    <%}%>
    <p class="text-right"><i class="icon icon-times del_record" data-id="<%=item.id%>"> 删除</i> | <i class="icon icon-edit edit_record"  data-id="<%=item.id%>"> 编辑</i>  </p>
</div>
<%}%>
</script>
<!-- 列表模板部分 结束-->
@endpush