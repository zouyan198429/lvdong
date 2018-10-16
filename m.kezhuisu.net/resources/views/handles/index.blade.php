@extends('layouts.app')

@push('headpre')
@endpush
@push('headscripts')
{{--  本页单独使用 --}}
<script src="{{asset('js/mui.min.js')}}"></script>
<script src="{{asset('js/mui.zoom.js')}}"></script>
<script src="{{asset('js/mui.previewimage.js')}}"></script>
<script type="text/javascript">
	// 初始化previewImage
	mui.previewImage();
</script>

{{--<link rel="stylesheet" href="{{asset('js/jiaoben4423/amazeui2.5.0css/amazeui.min.css')}}" />--}}
<script src="{{asset('js/jquery.js')}}"></script>
<!-- 弹出层-->
<script src="{{ asset('js/layer/layer.js') }}"></script>
@endpush

@section('content')
	@include('menu')


	<div class="box cls">
		<div class="hd"><h3>生产记录</h3></div>
		<div class="bd">

			<ul class=" loglist baguetteBoxOne gallery"  data-am-widget="gallery" data-am-gallery="{ pureview: true }">
				@foreach ($pro_records as $pro_record)
				<li>
					<div class="logdate">{{ date('m-d H:i',strtotime($pro_record['created_at'])) }}
<!-- 						@if (false && $pro_record['is_node'])<span class="tagp">节点</span> @endif
 -->						
					</div>
					<div class="logbox">
						<div class="logboxtop">
							<div class="fl" >记录人：{{$pro_record['company_account']['real_name'] or ""}}  </div>
							<div class="fr">@if (!empty($pro_record['weather']))<span class="weather">{{$pro_record['weather']}}</span> @endif</div>
							<div class="c"></div>
						</div>
						<div class="logboxcon"   >

							@foreach ($pro_record['site_resources'] as $site_resource)
							<span class="pic am-gallery-item" >
								<a href="{{ isset($site_resource['resource_url']) ? url($site_resource['resource_url']) : '' }}"><img src="{{ isset($site_resource['resource_url']) ? url($site_resource['resource_url']) : '' }}"  ></a>
							</span>
							@endforeach
							<div class="c"></div>
							<p class="lcon">{!!  $pro_record['record_intro']  !!}</p>
							<p class="ficonbox">
								<a href="javascript:void(0);" data-pro_unit_id="{{ $pro_unit_id }}" data-record_id="{{ $pro_record['id'] or 0 }}"  data-red_heart="{{ $pro_record['red_heart'] or 0 }}" class="red_heart">
									<i><img src="http://ofn8u9rp0.bkt.clouddn.com/icon-kzs-xin.svg" style="width:1rem;" ></i>
									<span class="red_heart_num">{{ $pro_record['red_heart'] or 0 }}</span>
								</a>
							</p>
						</div>
						<div class="logboxfoot ">
						</div>
					</div>
					
				</li>
				@endforeach
			</ul>
		</div>
	</div>

@endsection

@push('footscripts')

	{{--<script src="{{asset('js/jiaoben4423/js/jquery.min.js')}}"></script>--}}
	{{--<script src="{{asset('js/jiaoben4423/js/amazeui.js')}}"></script>--}}
	<link rel="stylesheet" href="{{asset('js/baguetteBox.js/baguetteBox.min.css')}}">
	<script src="{{asset('js/baguetteBox.js/baguetteBox.min.js')}}" async></script>
	{{--<script src="{{asset('js/baguetteBox.js/highlight.min.js')}}" async></script>--}}

	<script>
        const RECORD_HEART_URL = "{{url('api/red_heart/' . $pro_unit_id . '/ajax_red_heart_record')}}";// 记录点赞url
	</script>
    <script src="{{asset('js/lanmu/handles.js')}}"></script>
@endpush