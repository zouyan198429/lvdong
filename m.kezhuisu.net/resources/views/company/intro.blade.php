@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
	<div class="sub-header cls">
		<div class="btn-back"><a href="javascript:history.back(-1)" ><i class="fa fa-angle-left"></i></a></div>
		<h1>公司简介</h1>
	</div>
	<div class="content cls">

		<div class="bd">
			{!! $company_info['company_extend']['company_intro'] or '' !!}

		</div>
	</div>
@endsection

@push('footscripts')
@endpush