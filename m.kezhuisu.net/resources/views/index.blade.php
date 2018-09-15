@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
	@include('menu')


<div class="header cls">
	<div class="logo"><img src="{{ isset($site_resources[0]['resource_url']) ? url($site_resources[0]['resource_url']) : '' }}" ></div>
</div>
 


	<div class="main"  >
		<div class="box cls" id="pro-info">
			<div class="hd">
				<h2>{{ $pro_input_name }}</h2>
				<p>{{ $company_info['company_name'] or '' }}</p>
				<div class="indtell"> <a href="tel:{{ $company_info['contact_way'] or '' }}" ><img src="http://ofn8u9rp0.bkt.clouddn.com/icon-tell2.svg"></a></div>
 			</div>
			<div class="line6"></div>
			<div class="bd">
				<p>{{ $pro_input_intro }}</p>
				<table class="datable" >
					<tbody> 
					<tr>
						<th><div class="datit">品种品牌</div></th>
						<td>{{ $pro_input_brand }}</td>
					</tr>
					<tr>
						<th><div class="datit">生产批次</div></th>
						<td>{{ $pro_input_batch }}</td>
					</tr>
					<tr>
						<th><div class="datit">生产周期</div></th>
						<td>{{ date('Y-m-d',strtotime($begin_time)) }}-{{ date('Y-m-d',strtotime($end_time)) }}</td>
					</tr> 

					<!-- 
					<tr>
						<th><div class="datit">农事记录人</div></th>
						<td>
							@foreach ($pro_unit_accounts as $pro_unit_account)
								{{ $pro_unit_account['real_name'] }}
							@endforeach

						</td>
					</tr>  -->
					{{--
					<tr>
						<th></th>
						<td>
							<div class="bshare-custom"><a title="分享到微信" class="bshare-weixin"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到网易微博" class="bshare-neteasemb"></a><a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到人人网" class="bshare-renren"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a><span class="BSHARE_COUNT bshare-share-count">0</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=1&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
						</td>
					</tr>--}}
					</tbody>
				</table>
			</div>
		</div>
 		<div class="fwbox">
			<input type="" name="" value="刮开涂层，在此输入16位防伪码"><button>防伪查询</button>
		</div>
 

 		<div class="btnbox2">
 			<a href="{{ url('inputs/' . $pro_unit_id) }}"><i><img src="http://ofn8u9rp0.bkt.clouddn.com/icon-home-d1.svg"></i><p>生产投入品</p></a>
 			<a href="#"><i><img src="http://ofn8u9rp0.bkt.clouddn.com/icon-home-d2.svg"></i><p>检测报告</p></a>
 		</div>


		@if (count($pro_reports) >= 1)
		<div class="line10"></div>
		<div class="box cls" >
			<div class="hd"><h3>检测报告</h3></div>
			<div class="bd">
				<ul class="itrp cls">
					@foreach ($pro_reports as $pro_report)
					<li><div class="pic"><img src="{{ isset($pro_report['site_resources'][0]['resource_url']) ? url($pro_report['site_resources'][0]['resource_url']) : '' }}"></div><p>{{ $pro_report['site_resources'][0]['resource_name'] or '' }}</p></li>
					@endforeach

				</ul>
			</div>
		</div>
		@endif

	



		<div class="line10"></div>
		<div class="box cls">
			<div class="hd"><h3>生产记录</h3></div>
			<div class="bd">
				<ul class="loglist"> 
					<tbody>
					@foreach ($pro_records as $pro_record)
					<li>
					<div class="logdate">{{ date('m-d H:i',strtotime($pro_record['created_at'])) }}
 					</div>
 					<div class="logbox">
						<div class="jdpictd">
							<div class="jdpic"><img src="{{ isset($pro_record['site_resources'][0]['resource_url']) ? url($pro_record['site_resources'][0]['resource_url']) : '' }}" alt=""></div>
						</div>
						<div class="jdtxt">
							<p>{!! $pro_record['record_intro'] !!}</p>
						</div>
 					</div>
					@endforeach

 				</div>

				<div class="more">
					<a href="{{ url('handles/' . $pro_unit_id) }}">完整农事记录</a>
				</div>

			</div>
		</div>
		

	</div>

@endsection

@push('footscripts')
@endpush