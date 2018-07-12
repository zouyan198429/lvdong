@include('pagehead')
<body @yield('bodyclass')>

{{-- 主操作区域内容 --}}
@yield('content')
</body>
</html>
@include('pagefoot')
{{-- 本页单独foot使用,可以</html>结尾后可以写的内容，如js引入或操作 --}}
@stack('footscripts')