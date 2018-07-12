@extends('layouts.app')

@push('headscripts')
    {{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="content-header">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="icon icon-home"></i></a></li>
            <li class="active">在线支付</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">收费标准</div>
                </div>
                <div class="panel-body">

                    <table class="table">
                        <tr>
                            <td width="120px">用户名</td>
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


                    <table class="table">
                        <thead>
                        <tr>
                            <th width="180px">收费项目</th>
                            <th>说明</th>
                            <th>价格</th>
                            <th width="120px">支付</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>首年会员</td>
                            <td>新加入会员第一年费用，次年续费为1600元。含一个生产单元。</td>
                            <td>2400元</td>
                            <td><button class="btn btn-success" type="button">在线支付</button></td>
                        </tr>
                        <tr>
                            <td>终身会员</td>
                            <td>终身会员，含一个生产单元</td>
                            <td>4800元</td>
                            <td><button class="btn btn-success" type="button">在线支付</button></td>
                        </tr>
                        <tr>
                            <td>生产单元购买</td>
                            <td>增加一个生产单元的费用</td>
                            <td>600元/个</td>
                            <td><button class="btn btn-success" type="button">在线支付</button></td>
                        </tr>
                        <tr>
                            <td>会员续费</td>
                            <td>非终身VIP会员续费</td>
                            <td>1600元</td>
                            <td><button class="btn btn-success" type="button">在线支付</button></td>
                        </tr>
                        <tr>
                            <td>标签购买</td>
                            <td>2000个标签</td>
                            <td>200元</td>
                            <td><button class="btn btn-success" type="button">在线支付</button></td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection


@push('footscripts')
@endpush