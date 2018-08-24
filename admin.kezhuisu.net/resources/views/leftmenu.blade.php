
<div class="tpl-left-nav-title">
    + 管理菜单
</div>
<div class="tpl-left-nav-list">
    <ul class="tpl-left-nav-menu">
        <li class="tpl-left-nav-item">
            <a href="{{ url('/') }}" class="nav-link active">
                <i class="am-icon-home"></i>
                <span>首页</span>
            </a>
        </li>
        <li class="tpl-left-nav-item">
            <a href="{{ url('member/') }}" class="nav-link tpl-left-nav-link-list">
                <i class="am-icon-user"></i>
                <span>会员管理</span>
            </a>
        </li>
        <li class="tpl-left-nav-item">
            <a href="{{ url('honor/') }}" class="nav-link tpl-left-nav-link-list">
                <i class="am-icon-university"></i>
                <span>资质审核</span>
            </a>
        </li>
        <li class="tpl-left-nav-item">
            <a href="{{ url('productunit/') }}" class="nav-link tpl-left-nav-link-list">
                <i class="am-icon-flag"></i>
                <span>生产单元审核</span>
            </a>
        </li>
        <li class="tpl-left-nav-item">
            <a href="{{ url('photo/') }}" class="nav-link tpl-left-nav-link-list">
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
                    <a href="{{ url('handles/') }}">
                        <i class="am-icon-angle-right"></i>
                        <span>日志</span>
                        <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                    </a>
                    <a href="{{ url('inputs/') }}">
                        <i class="am-icon-angle-right"></i>
                        <span>投入品</span>
                    </a>
                    <a href="{{ url('report/') }}">
                        <i class="am-icon-angle-right"></i>
                        <span>检测报告</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="tpl-left-nav-item">
            <a href="{{ url('news/') }}" class="nav-link tpl-left-nav-link-list">
                <i class="am-icon-newspaper-o"></i>
                <span>新闻公告</span>
            </a>
        </li>
        <li class="tpl-left-nav-item">
            <a href="{{ url('pages/') }}" class="nav-link tpl-left-nav-link-list">
                <i class="am-icon-file-text-o"></i>
                <span>单页管理</span>
            </a>
        </li>
        {{--
        <li class="tpl-left-nav-item">
            <a href="{{ url('order/') }}" class="nav-link tpl-left-nav-link-list">
                <i class="am-icon-file-text-o"></i>
                <span>订单中心</span>
            </a>
        </li>
        --}}
        {{--
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
        --}}
        <li class="tpl-left-nav-item">
            <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                <i class="am-icon-cog"></i>
                <span>系统设置</span>
                <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right tpl-left-nav-more-ico-rotate"></i>
            </a>
            <ul class="tpl-left-nav-sub-menu" >
                <li>
                    <a href="{{ url('sitetags/') }}">
                        <i class="am-icon-angle-right"></i>
                        <span>生产记录标签</span>
                        <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                    </a>
                    <a href="{{ url('inputcls/') }}">
                        <i class="am-icon-angle-right"></i>
                        <span>投入品分类</span>
                        <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                    </a>
                    <a href="{{ url('unitcls/') }}">
                        <i class="am-icon-angle-right"></i>
                        <span>生产单元分类</span>
                        <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                    </a>
                    <a href="{{ url('admin/') }}">
                        <i class="am-icon-angle-right"></i>
                        <span>管理员管理</span>
                    </a>
                    <a href="{{ url('sys/') }}">
                        <i class="am-icon-angle-right"></i>
                        <span>系统基本信息</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>