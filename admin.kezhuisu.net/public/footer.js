(function() {
	document.write("");
	document.write("<!-- 前端模板部分 -->");
	document.write("<!-- 列表模板部分 开始-->");
	document.write("<script type=\"text\/template\"  id=\"baidu_template_data_list\">");
	document.write("<%for(var i = 0; i<data_list.length;i++){");
	document.write("    var item = data_list[i];");
	document.write("    %>");
	document.write("    <tr>");
	document.write("        <td><%=item.id%><\/td>");
	document.write("        <td><a href=\"#\"><%=item.type_name%><\/a><\/td>");
	document.write("        <td>");
	document.write("            <div class=\"am-btn-toolbar\">");
	document.write("                <div class=\"am-btn-group am-btn-group-xs\">");
	document.write("                    <button class=\"am-btn am-btn-default am-btn-xs am-text-secondary\"  onclick=\"action.edit(<%=item.id%>)\"><span class=\"am-icon-pencil-square-o\"><\/span> 编辑<\/button>");
	document.write("                    <button class=\"am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only\" onclick=\"action.del(<%=item.id%>)\"><span class=\"am-icon-trash-o\"><\/span> 删除<\/button>");
	document.write("                <\/div>");
	document.write("            <\/div>");
	document.write("        <\/td>");
	document.write("    <\/tr>");
	document.write("<%}%>");
	document.write("<\/script>");
	document.write("<!-- 列表模板部分 结束-->");
}).call();