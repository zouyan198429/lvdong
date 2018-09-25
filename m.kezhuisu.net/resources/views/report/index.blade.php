@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
	@include('menu')
	<div class="box cls  baguetteBoxOne gallery">
		<div class="hd"><h3>检测报名</h3></div>
		<div class="bd">

			<ul class="trplist">
				@foreach ($pro_reports as $pro_report)
				<li>
					<a href="javascript:void(0);">
						<div class="pic">
							<a href="{{  isset($pro_report['site_resources'][0]['resource_url']) ? url($pro_report['site_resources'][0]['resource_url']) : '' }}" data-caption="{{ $pro_report['report_name'] or '' }}{{  isset($pro_report['site_resources'][0]['resource_name']) ? $pro_report['site_resources'][0]['resource_name'] : '' }}">
								<img src="{{  isset($pro_report['site_resources'][0]['resource_url']) ? url($pro_report['site_resources'][0]['resource_url']) : '' }}" alt="Skaret View" style="width:200px;"  >
							</a>

						</div>
						<p>
							{{ $pro_report['report_name'] or '' }}
							{{  isset($pro_report['site_resources'][0]['resource_name']) ? $pro_report['site_resources'][0]['resource_name'] : '' }}
						</p>
					</a>
				</li>
				@endforeach

			</ul>

		</div>
	</div>

@endsection

@push('footscripts')
	<link rel="stylesheet" href="{{asset('js/baguetteBox.js/baguetteBox.min.css')}}">
	<script src="{{asset('js/baguetteBox.js/baguetteBox.min.js')}}" async></script>
	{{--<script src="{{asset('js/baguetteBox.js/highlight.min.js')}}" async></script>--}}

	<script>
        window.onload = function() {
            baguetteBox.run('.baguetteBoxOne');
        };
	</script>
@endpush