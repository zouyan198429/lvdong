@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')

	@include('menu')


	<div class="box cls">
		<div class="hd"><h3>企业信息</h3></div>
		<div class="bd">
			<dl class="cominfo">
				<dt>企业名称</dt><dd>{{ $company['company_name'] }}</dd>
			</dl>
			<dl class="cominfo">
				<dt>所在地址</dt><dd>{{ $company['company_addr'] }}</dd>
			</dl>
			<!-- <dl class="cominfo">
				<dt>生产地址</dt><dd>{{ $company['product_addr'] }}</dd>
			</dl> -->

			<!-- 
			<dl class="cominfo">
				<dt>主营产品</dt><dd>{!! $company['company_mainproduct'] !!}</dd>
			</dl> --><!-- 
			<dl class="cominfo">
				<dt>成立时间</dt><dd>{{ date('Y-m-d',strtotime($company['company_createtime'])) }}</dd>
			</dl>
		</div> -->
	</div>

	<div class="box cls">
		<div class="hd"><h3>资质证书</h3></div>
		<div class="bd">
			<div class="renzhenglist">
				@foreach ($company['honors'] as $honor)
				<a href="{{ isset($honor['site_resources'][0]['resource_url']) ? url($honor['site_resources'][0]['resource_url']) : '' }}" ><img src="{{ isset($honor['site_resources'][0]['resource_url']) ? url($honor['site_resources'][0]['resource_url']) : '' }}" /></a>
				@endforeach
			</div>
		</div>
	</div>

	<div class="box cls">
		<div class="hd"><h3>企业简介</h3></div>
		<div class="bd">
			<div class="contact">
				{!! $company_info['company_extend']['company_intro'] or '' !!}
			</div>
		</div>
		{{--
		<div class="hd"><a href="{{ url('company/intro/' . $pro_unit_id) }}" ><h3>企业简介</h3><i class="fa fa-angle-right fr"></i></a></div>
	    --}}
	</div>

	<div class="box cls">
		<div class="hd"><h3>联系方式</h3></div>
		<div class="bd">
			<div class="contact">
				<a href="tel:{!! $company['contact_way'] !!}" >{!! $company['contact_way'] !!} </a>
			</div>
		</div>
	</div>

	<div class="box cls">
		<div class="hd"><h3>企业相册</h3></div>
		<div class="bd">
			<ul class="albumlist">
				@foreach ($company['photos'] as $photo)
				<li>
					<a href="{{ isset($photo['site_resources'][0]['resource_url']) ? url($photo['site_resources'][0]['resource_url']) : '' }}">
					<div class="pic"> <img src="{{ isset($photo['site_resources'][0]['resource_url']) ? url($photo['site_resources'][0]['resource_url']) : '' }}" > </div> 
                    <p class="text-ellipsis">{{ $photo['phonto_name'] }}</p>
					</a>
				</li>
				@endforeach
			</ul>
		</div>
	</div>

@endsection

@push('footscripts')
@endpush