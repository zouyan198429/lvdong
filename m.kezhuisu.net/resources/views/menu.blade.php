
<div class="header cls">
	<div class="logo"><img src="{{ isset($company_pro_config['site_resources'][0]['resource_url']) ? url($company_pro_config['site_resources'][0]['resource_url']) : '' }}" ></div>
	<h1>{{ $pro_input_name }}</h1>
	<p>{{ $company_info['company_name'] or '' }}</p>
</div>
<div class="nav cls">

	<ul>
		<li><a href="{{ url('/' . $pro_unit_id) }}" class="ui-btn ui-btn-inline"><i class="fa fa-home"></i>首页</a></li>
		<li><a href="{{ url('handles/' . $pro_unit_id) }}" class="ui-btn ui-btn-inline"><i class="fa fa-calendar-check-o "></i>生产记录</a></li>
		<li><a href="{{ url('inputs/' . $pro_unit_id) }}" class="ui-btn ui-btn-inline"><i class="fa fa-magic"></i>投入品</a></li>
		<li><a href="{{ url('company/' . $pro_unit_id) }}" class="ui-btn ui-btn-inline"><i class="fa fa-bank"></i>企业信息</a></li>
		<li><a href="{{ url('comment/' . $pro_unit_id) }}" class="ui-btn ui-btn-inline"><i class="fa fa-pencil-square-o"></i>反馈</a></li>
	</ul>

</div>