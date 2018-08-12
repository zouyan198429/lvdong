<!DOCTYPE html>
<html>
<head>
    @include('head')
    {{-- 本页单独head使用 --}}
    @stack('headscripts')

</head>

<body data-type="index">
@include('topbar')
<div class="tpl-page-container tpl-page-header-fixed">
    <div class="tpl-left-nav tpl-left-nav-hover">
        @include('leftmenu')
    </div>


    <div class="tpl-content-wrapper">
        {{-- 主区域内容 --}}
        @yield('content')
    </div>

</div>
</body>

</html>
@stack('footscripts')
@include('pagefoot')
{{-- 本页单独foot使用,可以</html>结尾后可以写的内容，如js引入或操作 --}}
@stack('footlast')