<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>农产品质量安全追溯系统</title>
	<meta name="description" content="农产品质量安全追溯系统">
	<meta name="keywords" content="index">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="renderer" content="webkit">
	<meta http-equiv="Cache-Control" content="no-siteapp" />
	<meta name="apple-mobile-web-app-title" content="Amaze UI" />
	{{--@include('public.dynamic_list_head')--}}
	<link rel="stylesheet" href="{{asset('assets/css/amazeui.min.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/css/app.css')}}">
	@include('piwik')
</head>

<body data-type="login">

<div class="am-g myapp-login">
	<div class="myapp-login-logo-block  tpl-login-max">
		<div class="myapp-login-logo-text">
			<div class="myapp-login-logo-text">
				农产品质量安全追溯系统 <i class="am-icon-skyatlas"></i>
			</div>
		</div>
		<div class="am-u-sm-10 login-am-center">
			<form class="am-form" action="#"  method="post"  id="addForm">
				<fieldset>
					<div class="am-form-group">
						<input type="text" class=""  name="admin_username"  id="doc-ipt-email-1" placeholder="输入用户名">
					</div>
					<div class="am-form-group">
						<input type="password"   name="admin_password"  class="" id="doc-ipt-pwd-1" placeholder="输入密码">
					</div>
					<p><button  type="button"  id="submitBtn" {{-- onclick="window.open('{{ url('/') }}')" --}} class="am-btn am-btn-default">登录</button></p>
				</fieldset>
			</form>
		</div>
	</div>
</div>

</body>
</html>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<!-- 弹出层-->
<script src="{{ asset('/static/js/custom/layer/layer.js') }}"></script>
<!-- 公共方法-->
<script src="{{ asset('/static/js/custom/common.js') }}"></script>
<!-- ajax翻页方法-->
<script src="{{ asset('/static/js/custom/ajaxpage.js') }}"></script>
<!-- 新加入 end-->
<script>
    const LOGIN_URL = "{{ url('api/ajax_login') }}";
    const INDEX_URL = "{{url('/')}}";

</script>
<script src="{{ asset('/js/lanmu/login.js') }}"  type="text/javascript"></script>