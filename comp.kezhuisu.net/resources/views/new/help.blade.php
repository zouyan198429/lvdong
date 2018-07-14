@extends('layouts.app')

@push('headscripts')
    {{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="content-header">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="icon icon-home"></i></a></li>
            <li class="active"><a href="{{ url('new/') }}">平台公告</a> </li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">{{ $new_title }}</div>
                </div>
                <div class="panel-body">
                    {!! $new_content or '' !!}
                </div>
            </div>
        </div>
    </div>
@endsection


@push('footscripts')
@endpush