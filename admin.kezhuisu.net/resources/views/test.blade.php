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
    <link rel="icon" type="{{asset('image/png" href="assets/i/favicon.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('assets/i/app-icon72x72@2x.png')}}">
    <meta name="apple-mobile-web-app-title" content="Amaze UI" />
    <link rel="stylesheet" href="{{asset('assets/css/amazeui.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/admin.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/app.css')}}">
    {{--<script src="{{asset('assets/js/echarts.min.js')}}"></script>--}}
</head>

<body data-type="index">

    <header class="am-topbar am-topbar-inverse admin-header">
        <div class="am-topbar-brand">
            <a href="javascript:;" class="tpl-logo">
                  <img src="assets/img/logo.png" alt="">
            </a>
        </div>
        <div class="am-icon-list tpl-header-nav-hover-ico am-fl am-margin-right"></div>

        <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

        <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

            <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list tpl-header-list">
                <li class="am-dropdown" data-am-dropdown data-am-dropdown-toggle>
                    <a class="am-dropdown-toggle tpl-header-list-link" href="javascript:;">
                        <span class="tpl-header-list-user-nick">管理小张</span><span class="tpl-header-list-user-ico"> <img src="assets/img/user01.png"></span>
                    </a>
                    <ul class="am-dropdown-content">
                        <li><a href="#"><span class="am-icon-bell-o"></span> 资料</a></li>
                        <li><a href="#"><span class="am-icon-cog"></span> 设置</a></li>
                        <li><a href="#"><span class="am-icon-power-off"></span> 退出</a></li>
                    </ul>
                </li>
                <li><a href="###" class="tpl-header-list-link"><span class="am-icon-power-off tpl-header-list-ico-out-size"></span></a></li>
            </ul>
        </div>
    </header>

    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-left-nav tpl-left-nav-hover">
            <div class="tpl-left-nav-title">
                + 管理菜单
            </div>
            <div class="tpl-left-nav-list">
                <ul class="tpl-left-nav-menu">
                    <li class="tpl-left-nav-item">
                        <a href="index.html" class="nav-link active">
                            <i class="am-icon-home"></i>
                            <span>首页</span>
                        </a>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="member.html" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-user"></i>
                            <span>会员管理</span>
                        </a>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="Authen.html" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-university"></i>
                            <span>资质审核</span>
                        </a>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="product.html" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-flag"></i>
                            <span>生产单元审核</span>
                        </a>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="album.html" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-picture-o"></i>
                            <span>企业相册</span>
                        </a>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-table"></i>
                            <span>信息管理</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu" style="display: block;">
                            <li>
                                <a href="ins-log.html">
                                    <i class="am-icon-angle-right"></i>
                                    <span>日志</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="itrp-list.html">
                                    <i class="am-icon-angle-right"></i>
                                    <span>投入品</span>
                                 </a>
                                <a href="ijcbg-list.html">
                                    <i class="am-icon-angle-right"></i>
                                    <span>检测报告</span>
                                 </a>
                            </li>
                        </ul>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="newslist.html" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-picture-o"></i>
                            <span>新闻公告</span>
                        </a>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="page.html" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-picture-o"></i>
                            <span>单页管理</span>
                         </a>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="order.html" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-file-text-o"></i>
                            <span>订单中心</span>
                         </a>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-wpforms"></i>
                            <span>数据统计</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right tpl-left-nav-more-ico-rotate"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu" >
                            <li>
                                <a href="data-member.html">
                                    <i class="am-icon-angle-right"></i>
                                    <span>会员统计</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="data-info.html">
                                    <i class="am-icon-angle-right"></i>
                                    <span>信息统计</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="data-site.html">
                                    <i class="am-icon-angle-right"></i>
                                    <span>微店统计</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                     <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-cog"></i>
                            <span>系统设置</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right tpl-left-nav-more-ico-rotate"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu" >
                            <li>
                                <a href="class-trp.html">
                                    <i class="am-icon-angle-right"></i>
                                    <span>投入品分类</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="class-pro.html">
                                    <i class="am-icon-angle-right"></i>
                                    <span>生产单元分类</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="admin-list.html">
                                    <i class="am-icon-angle-right"></i>
                                    <span>管理员管理</span>
                                </a>
                                <a href="system-base.html">
                                    <i class="am-icon-angle-right"></i>
                                    <span>系统基本信息</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>


        <div class="tpl-content-wrapper">
            <div class="tpl-content-page-title">
               首页
            </div>



        </div>

    </div>


    <script src="{{asset('assets1/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/amazeui.min.js')}}"></script>
    <script src="{{asset('assets/js/iscroll.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>
</body>

</html>