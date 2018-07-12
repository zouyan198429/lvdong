@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
<div class="content-header">
    <ul class="breadcrumb">
        <li><a href="#"><i class="icon icon-home"></i></a></li>
        <li class="active">仪表盘</li>
    </ul>
</div>
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-primary">
                    <div class="info-box-icon">
                        <i class="icon icon-user"></i>
                    </div>
                    <div class="info-box-content">
                        <span class="info-box-text">用户总量</span>
                                <span class="info-box-number">90
                                    <small>个</small>
                                </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-info">
                    <div class="info-box-icon">
                        <i class="icon icon-file-text"></i>
                    </div>
                    <div class="info-box-content">
                        <span class="info-box-text">日志总量</span>
                                <span class="info-box-number">320
                                    <small>篇</small>
                                </span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-warning">
                    <div class="info-box-icon">
                        <i class="icon icon-bars"></i>
                    </div>
                    <div class="info-box-content">
                        <span class="info-box-text">生产单元</span>
                                <span class="info-box-number">1
                                    <small>个</small>
                                </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-danger">
                    <div class="info-box-icon">
                        <i class="icon icon-eye-open"></i>
                    </div>
                    <div class="info-box-content">
                        <span class="info-box-text">微站访问</span>
                                <span class="info-box-number">18953
                                    <small>次</small>
                                </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-title">帐户信息</div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-info">
                            <tr>
                                <td>用户名</td>
                                <td>asdfasd</td>
                            </tr>
                            <tr>
                                <td>帐户等级</td>
                                <td><span class="am-text-success" >试用期</span>[2018-07-04 到期]</td>
                            </tr>
                            <tr>
                                <td>资质认证</td>
                                <td>未认证 <a href="{{ url('company/') }}">【现在认证】</a> / 完成 </td>
                            </tr>
                            <tr>
                                <td>注册日期</td>
                                <td>2018-05-02</td>
                            </tr>
                            <tr>
                                <td>上次登录 </td>
                                <td>2018-05-26</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>




            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-title">平台公告</div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-info">
                            <tr>
                                <td>河北冬小麦进入收获期 百万农机齐上阵</td>
                                <td>2018-05-22</td>
                            </tr>
                            <tr>
                                <td>河北冬小麦进入收获期 百万农机齐上阵</td>
                                <td>2018-05-22</td>
                            </tr>
                            <tr>
                                <td>河北冬小麦进入收获期 百万农机齐上阵</td>
                                <td>2018-05-22</td>
                            </tr>
                            <tr>
                                <td>河北冬小麦进入收获期 百万农机齐上阵</td>
                                <td>2018-05-22</td>
                            </tr>
                            <tr>
                                <td>河北冬小麦进入收获期 百万农机齐上阵</td>
                                <td>2018-05-22</td>
                            </tr>


                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-title">平台信息</div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-info">
                            <tr>
                                <td>系统名称</td>
                                <td>农产品质量安全追溯系统</td>
                            </tr>
                            <tr>
                                <td>开发运营</td>
                                <td>上海某某农业科技有限公司</td>
                            </tr>
                            <tr>
                                <td>电子邮箱</td>
                                <td>9918673@qq.com</td>
                            </tr>
                            <tr>
                                <td>在线客服</td>
                                <td>QQ：9918673 电话：029-54568466</td>
                            </tr>
                            <tr>
                                <td>公司地址</td>
                                <td>上海市某某路88号</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        @foreach ($dataList as $info)
                        <a href="{{ url('sys/help/' . $info['id']) }}"> <i class="icon icon-caret-right"></i> {{ $info['intro_title'] }}</a>
                        @endforeach
                        <span class="pull-right text-gray">版权所有：上海某某农业科技有限公司</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('footscripts')
@endpush