
<!-- 列表模板部分 开始-->
<script type="text/template"  id="baidu_template_data_list">
    <%for(var i = 0; i<data_list.length;i++){
    var item = data_list[i];
%>

<tr>
    <td><%=item.id%></td>
    <td><%=item.company_name%></td>
    <td><%=item.company_linkman%></td>
    <td><%=item.company_mobile%><br/><%=item.company_tel%></td>
    <td><%=item.area%></td>
        <%if(false){%>
    <td>新注册</td>
        <%}%>
<td class="am-hide-sm-only">
    <%=item.company_vipbegin%>
    --
    <%=item.company_vipend%>
        </td>
        <td class="am-hide-sm-only"><%=item.created_at%></td>
        <td class="am-hide-sm-only"><%=item.company_lastlogintime%></td>
        <td>
        <div class="am-btn-toolbar">
        <div class="am-btn-group am-btn-group-xs">
        <button class="am-btn am-btn-default am-btn-xs am-text-secondary"  onclick="action.edit(<%=item.id%>)"> 修改 </button>
        <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" onclick="action.del(<%=item.id%>)"><span class="am-icon-trash-o"></span> 删除</button>
    <% if(false){%>
    <button class="am-btn am-btn-default am-btn-xs am-text-secondary "><span class="am-icon-pencil-square-o"></span> 备注（1）</button>
        <%  }%>
</div>
    </div>
    </td>
    </tr>
    <%}%>
</script>
<!-- 列表模板部分 结束-->