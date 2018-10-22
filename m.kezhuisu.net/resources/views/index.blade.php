@extends('layouts.app')

@push('headscripts')

	{{--  本页单独使用 --}}
	<script src="{{asset('js/mui.min.js')}}"></script>
	<script src="{{asset('js/mui.zoom.js')}}"></script>
	<script src="{{asset('js/mui.previewimage.js')}}"></script>
	<script type="text/javascript">
        // 初始化previewImage
        mui.previewImage();
	</script>
<script src="{{asset('js/jquery.js')}}"></script>
<!-- 弹出层-->
<script src="{{ asset('js/layer/layer.js') }}"></script>
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
				<p>{!! $pro_input_intro or '' !!} </p>
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
						<td>{{ date('Y-m-d',strtotime($begin_time)) }}-- @if(!is_null($end_time) && !empty($end_time)){{  date('Y-m-d',strtotime($end_time)) }} @endif</td>
					</tr>
					<tr>
						<th><div class="datit">生产基地</div></th>
						<td>{{ $pro_input_addr or '' }}</td>
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
					</tbody>
				</table>
			</div>
		</div>
		<div class="iconbox">
			<a href="javascript:void(0);" data-pro_unit_id="{{ $pro_unit_id }}" data-red_heart="{{ $red_heart or 0 }}" class="red_heart"><i><img src="http://ofn8u9rp0.bkt.clouddn.com/icon-kzs-xin.svg"></i><span class="red_heart_num">{{ $red_heart or 0 }}</span></a>
 			<a href="{{ url('comment/' . $pro_unit_id) }}"><i><img src="http://ofn8u9rp0.bkt.clouddn.com/icon-kzs-mess.svg"></i><span>{{$commentCount or 0 }}</span></a>
 			{{--<a href="#"><i><img src="http://ofn8u9rp0.bkt.clouddn.com/icon-kzs-share.svg"></i><span>26</span></a>--}}
  		</div>
 		<div class="fwbox">
			<input type="text" name="label_num"  placeholder="刮开涂层，在此输入防伪码" value=""><button id="submitBtn">防伪查询</button>
		</div>
 

 		<div class="btnbox2">
 			<a href="{{ url('inputs/' . $pro_unit_id) }}"><i><img src="http://ofn8u9rp0.bkt.clouddn.com/icon-home-d1.svg"></i><p>生产投入品</p></a>
 			<a href="{{ url('report/' . $pro_unit_id) }}"><i><img src="http://ofn8u9rp0.bkt.clouddn.com/icon-home-d2.svg"></i><p>检测报告</p></a>
 		</div>


		@if (count($pro_reports) >= 1)
		<div class="line10"></div>
		<div class="box cls  baguetteBoxTwo gallery " >
			<div class="hd"><h3>检测报告</h3></div>
			<div class="bd">
				<ul class="itrp cls">
					@foreach ($pro_reports as $pro_report)
					<li>
						<div class="pic">
							<a href="{{ isset($pro_report['site_resources'][0]['resource_url']) ? url($pro_report['site_resources'][0]['resource_url']) : '' }}">
								<img src="{{ isset($pro_report['site_resources'][0]['resource_url']) ? url($pro_report['site_resources'][0]['resource_url']) : '' }}">
							</a>
						</div>
						<p>{{ $pro_report['site_resources'][0]['resource_name'] or '' }}</p>
					</li>
					@endforeach

				</ul>
			</div>
		</div>
		@endif

	



		<div class="line10"></div>
		<div class="box cls baguetteBoxOne gallery">
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
							<div class="jdpic">
								@foreach ($pro_record['site_resources'] as $site_resource)
									<a href="{{ isset($site_resource['resource_url']) ? url($site_resource['resource_url']) : '' }}">
										<img src="{{ isset($site_resource['resource_url']) ? url($site_resource['resource_url']) : '' }}" alt="">
									</a>
								@endforeach
							</div>
						</div>
						<div class="jdtxt">
							<p>{!! $pro_record['record_intro'] !!}</p>
							<p style="text-align: right;">
								<a href="javascript:void(0);" data-pro_unit_id="{{ $pro_unit_id }}" data-record_id="{{ $pro_record['id'] or 0 }}"  data-red_heart="{{ $pro_record['red_heart'] or 0 }}" class="record_red_heart">
									<i><img src="http://ofn8u9rp0.bkt.clouddn.com/icon-kzs-xin.svg" style="width: 1rem"></i>
									<span class="red_heart_num">{{ $pro_record['red_heart'] or 0 }}</span>
								</a>
							</p>
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

	<link rel="stylesheet" href="{{asset('js/baguetteBox.js/baguetteBox.min.css')}}">
	<script src="{{asset('js/baguetteBox.js/baguetteBox.min.js')}}" async></script>
	{{--<script src="{{asset('js/baguetteBox.js/highlight.min.js')}}" async></script>--}}

	<script type="text/javascript">
		const ANTIFAKE_URL = "{{ url('/antifake/' . $pro_unit_id) }}/";// 防伪码查询url
		const UNIT_HEART_URL =  "{{url('api/red_heart/' . $pro_unit_id . '/ajax_red_heart')}}";// 生产单元点赞url
		const RECORD_HEART_URL = "{{url('api/red_heart/' . $pro_unit_id . '/ajax_red_heart_record')}}";// 记录点赞url
    </script>
    <script src="{{asset('js/lanmu/index.js')}}"></script>
@endpush