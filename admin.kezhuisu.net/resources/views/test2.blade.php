
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>农场管理后台</title>
    <link rel="stylesheet" href="http://comp.kezhuisu.com/static/css/bootstrap.min.css"/>

    <!-- zui css -->
    <link rel="stylesheet" href="http://comp.kezhuisu.com/dist/css/zui.min.css">
    <link rel="stylesheet" href="http://comp.kezhuisu.com/dist/theme/blue.css">
    <!-- app css -->
    <link rel="stylesheet" href="http://comp.kezhuisu.com/css/app.css">
    <!-- jquery js -->
    <script src="http://comp.kezhuisu.com/dist/lib/jquery/jquery.js"></script>


</head><body>
<div class="wrapper">
    <header class="main-header">
        <nav class="navbar navbar-fixed-top bg-primary">
            <div class="navbar-header">
                <a class="navbar-toggle" href="javascript:;" data-toggle="collapse" data-target=".navbar-collapse"><i class="icon icon-th-large"></i></a>
                <a class="sidebar-toggle" href="javascript:;" data-toggle="push-menu"><i class="icon icon-bars"></i></a>
                <a class="navbar-brand" href="#">
                    <span class="logo"> 农产品质量可追溯管理</span>
                    <span class="logo-mini">后台</span>
                </a>
            </div>
            <div class="collapse navbar-collapse">
                <div class="container-fluid">
                    <ul class="nav navbar-nav">
                        <li><a href="javascript:;" data-toggle="push-menu"><i class="icon icon-bars"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">

                        <li>
                            <a href="http://comp.kezhuisu.com/sys/help">
                                    <span>
                                        <i class="icon icon-location-arrow"></i> 帮助中心
                                    </span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;" data-toggle="dropdown"><i class="icon icon-user"></i> 管理员 <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="http://comp.kezhuisu.com/accounts/set">资料设置</a></li>
                                <li><a href="http://comp.kezhuisu.com/accounts/mypass">修改密码</a></li>
                                <li class="divider"></li>
                                <li><a href="http://comp.kezhuisu.com/logout">退出</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>    </header>
    <aside class="main-sidebar">

    </aside>
    <div class="content-wrapper">

    </div>
</div>
</body>
</html>

<script type="text/javascript">
    $(function(){
        countdown_alert('请选择需要操作的记录!',3,5);

    })
</script>

<!-- BaiduTemplate -->
<!-- 前端模板开始 -->
<!-- 加载中模板部分 开始-->
<script type="text/template"  id="baidu_template_data_loding">
    <tr><td colspan="14" align="center">信息努力加载中.......</td></tr>
</script>
<!-- 加载中模板部分 结束-->
<!-- 没有数据记录模板部分 开始-->
<script type="text/template"  id="baidu_template_data_empty">
    <tr><td colspan="14" align="center">当前没有您要查询的记录！</td></tr>
</script>
<!-- 没有数据记录模板部分 结束-->
<!-- 列表分页模板部分 开始-->
<script type="text/template"  id="baidu_template_data_page">
    <div class="row">
        <div class="col-xs-12">
            <div id="dynamic-table_paginate" class="dataTables_paginate paging_simple_numbers">
                <ul class="pagination">
                </ul>
            </div>
        </div>
    </div>
</script>
<!-- 列表分页模板部分 结束-->


<!-- 确定+取消弹窗模板部分 开始
$sure_cancel_data = {
    'content':'确定导出Excel？ ',//提示文字
    'sure_event':'excel_sure();',//确定
    'cancel_event':'excel_cancel();',//取消
};
-->
<script type="text/template"  id="baidu_template_sure_cancel">
    <table>
        <tr>
            <td style="width:5px"  rowspan="3"></td>
            <td><img src="http://admin.kezhuisu.com/static/images/question.jpg" style="height:25px;width:25px;"></td>
            <td>&nbsp;&nbsp;</td>
            <td style="text-align:left;"><%=content%></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td><br/>
              <button class="btn btn-info butdata m2 sure_submit_btn" type="button" onclick="<%=sure_event%>">确 定</button>&nbsp;&nbsp;&nbsp;&nbsp;
              <button class="btn btn-default butdata m2 sure_cancel_btn" style="margin-left:20px;"  type="button" onclick="<%=cancel_event%>" >取 消</button>
            </td>
          </tr>
        </table>
    </script>
    <!-- 确定+取消弹窗模板部分 结束-->

    <!-- error错误弹窗模板部分 开始
    $sure_cancel_data = {
        'content':'***',//提示文字
    };
    -->
    <script type="text/template"  id="baidu_template_error">
        <table>
          <tr>
            <td style="width:5px"  rowspan="3"></td>
            <td><img src="http://admin.kezhuisu.com/static/images/that.png" style="height:25px;width:25px;"></td>
            <td>&nbsp;&nbsp;</td>
            <td style="text-align:left;"><%=content%></td>
          </tr>
        </table>
    </script>
    <!-- error错误弹窗模板部分 结束-->
    <!-- 倒记时关闭弹窗模板部分 开始
    $sure_cancel_data = {
        'content':'***',//提示文字
        'sec_num':10,//默认秒数
        'icon_name',//图片名称
    };
    -->
    <script type="text/template"  id="baidu_template_countdown">
        <table>
          <tr>
            <td style="width:5px"  rowspan="3"></td>
            <td  rowspan="3"><img src="/static/images/<%=icon_name%>" style="height:25px;width:25px;"></td>
            <td>&nbsp;&nbsp;</td>
            <td style="text-align:left;"><%=content%></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;</td>
            <td style="text-align:left;">窗口将在<b><span  style="color: #F00;" class="show_second"><%=sec_num%></span></b>秒后窗口关闭</td>
          </tr>
        </table>
    </script>
    <!-- 倒记时关闭弹窗模板部分 结束-->
    <!-- 确认搜索条件值表单模板部分 开始-->
    <script type="text/template"  id="baidu_template_search_sure_form">
        <form  id="<%=search_sure_form%>" method="post" action="#">
        <%for(var i = 0; i<input_vlist.length;i++){
        var item = input_vlist[i];
        %>
        <input type="hidden" name="<%=item.name%>" value="<%=item.value%>"/>
        <%}%>
        </form>
    </script>
    <!-- 确认搜索条件值表单模板部分 结束-->

    <!-- [省市区/县]下拉框模板部分 开始-->
    <!-- //遍历json对象的每个key/value对,p为key{key:val,..}-->
    <script type="text/template"  id="baidu_template_option_list">
        <%for(var key in option_json){
			%>
			<option value="<%=key%>"><%=option_json[key]%></option>
			<%
		}%>
    </script>
    <!-- [省市区/县]下拉框模板部分 结束-->
    <!-- 前端模板结束 -->
    <!-- 模态框（Modal） -->
    <!-- 按钮触发模态框 -->
<!--
<button class="btn btn-primary btn-lg" data-toggle="modal" id="alertid">
   开始演示模态框
</button>
-->
<div id="modal_show_id_before" style="display:none;"></div>
<!-- 模态框（Modal） -->
<!-- 前端模板部分 -->
<script type="text/template"  id="baidu_template_alert_modal">
	<div class="modal fade" id="<%=alert_Modal_id%>" tabindex="-1" role="dialog"
	   aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" >
		  <div class="modal-content">
			 <div class="modal-header">
				<button type="button" class="close"
				   data-dismiss="modal" aria-hidden="true">
					  &times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
				   模态框（Modal）标题
				</h4>
			 </div>
			 <div class="modal-body">
				<!--在这里添加一些文本-->
			 </div>
			 <div class="modal-footer">
				<button type="button" class="btn btn-default btn-xs"
				   data-dismiss="modal">关闭
				</button>
				<button type="button" class="btn btn-primary btn-xs">
				   提交更改
				</button>
			 </div>
		  </div><!-- /.modal-content -->
		</div><!-- /.modal -->
	</div>

</script>
<!-- 前端模板结束 -->


<script src="http://admin.kezhuisu.com/static/js/custom/alert_modal.js"></script>    <!-- /.main-container -->

    <!-- basic scripts -->



     <script src="http://admin.kezhuisu.com/static/js/bootstrap.min.js"></script>
    <!-- page specific plugin scripts -->
    <script src="http://admin.kezhuisu.com/static/js/jquery.dataTables.min.js"></script>






    <!-- 新加入 begin-->
    <script src="http://admin.kezhuisu.com/static/js/moment.min.js"></script>
    <script src="http://admin.kezhuisu.com/static/js/bootstrap-datetimepicker.min.js"></script>
    <script src="http://admin.kezhuisu.com/static/js/jquery-ui.min.js"></script>

    <script src="http://admin.kezhuisu.com/static/js/custom/data_tables.js"></script>


      <!-- 数据验证-->

    <!-- 弹出层-->
    <!-- BaiduTemplate-->
    <script src="http://admin.kezhuisu.com/static/js/custom/baiduTemplate.js"></script>
    <!-- 弹出层-->
    <script src="http://admin.kezhuisu.com/static/js/custom/layer/layer.js"></script>
    <!-- 公共方法-->
    <script src="http://admin.kezhuisu.com/static/js/custom/common.js"></script>
    <!-- ajax翻页方法-->
    <script src="http://admin.kezhuisu.com/static/js/custom/ajaxpage.js"></script>


<script src="http://admin.kezhuisu.com/assets/js/iscroll.js"></script>
  <!-- 新加入 end--><script src="http://admin.kezhuisu.com/assets/js/amazeui.min.js"></script>
<script src="http://admin.kezhuisu.com/assets/js/app.js"></script>