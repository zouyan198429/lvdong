<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>农产品质量安全追溯系统</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="renderer" content="webkit">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- 本页单独head使用 --}}
    @stack('headpre')
    <link rel="stylesheet" href="{{asset('js/jiaoben4423/amazeui2.5.0css/amazeui.min.css')}}" />
    <link rel="stylesheet" href="https://cdn.bootcss.com/mui/3.7.1/css/mui.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="{{asset('css/mystyle.css')}}">

    @include('piwik')
    {{-- 本页单独head使用 --}}
    @stack('headscripts')

</head>
<body>

<div class="page cls">

    {{-- 主区域内容 --}}
    @yield('content')

    <div class="copyright"><p>技术支持：中国农产品质量可追溯中心.com<br /> <a href="tel:029-84181027" >029-84181027</a></p></div>

    <div class="footer">
        <div class="navbar">
            <ul>
                <li><a href="{{ url('/' . $pro_unit_id) }}"  class="ui-btn-active"  data-icon="home">首页</a></li>

                @foreach ($pro_menus as $menu)
                <li><a target="_blank" href="{{ $menu['menu_url'] }}" data-icon="home">{{ $menu['menu_name'] }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>


</div>



</body>
</html>
{!! $company_pro_config['third_code'] !!}
{{-- 本页单独foot使用,可以</html>结尾后可以写的内容，如js引入或操作 --}}
@stack('footscripts')