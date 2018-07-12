@extends('layouts.app')

@push('headscripts')
    {{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="content-header">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="icon icon-home"></i></a></li>
            <li class="active">数据统计</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p>新用户至少需要申请一个生产单元！</p>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">数据统计</div>
                </div>
                <div class="panel-body">


                </div>
            </div>
        </div>
    </div>
@endsection


@push('footscripts')
@endpush