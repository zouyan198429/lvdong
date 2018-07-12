@extends('layouts.app')

@push('headscripts')
    {{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="content-header">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="icon icon-home"></i></a></li>
            <li class="active">帮助中心</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">帮助中心</div>
                </div>
                 <div class="panel-body">
                     <ul>
                         @foreach ($dataList as $info)
                         <li><a href="{{ url('sys/help/' . $info['id']) }}" >{{ $info['intro_title'] }}</a> </li>
                         @endforeach
                     </ul>
                    {{ $intro_content or '' }}
                </div>
            </div>
        </div>
    </div>
@endsection


@push('footscripts')
@endpush