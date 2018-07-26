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
@endpush

@section('content')
	@include('menu')


	<div class="box cls">
		<div class="hd"><h3>生产记录</h3></div>
		<div class="bd">

			<ul class="loglist">
				@foreach ($pro_records as $pro_record)
				<li>
					<div class="date">{{ date('m-d H:i',strtotime($pro_record['created_at'])) }} @if ($pro_record['is_node'])<span class="tagp">节点</span> @endif </div>
					@foreach ($pro_record['site_resources'] as $site_resource)
					<span class="pic" >
						<img src="{{ isset($site_resource['resource_url']) ? url($site_resource['resource_url']) : '' }}" data-preview-src="" data-preview-group="3" >
					</span>
					@endforeach
					<div class="c"></div>
					<p class="lcon">{!!  $pro_record['record_intro']  !!}</p>
				</li>
				@endforeach
			</ul>
		</div>
	</div>

@endsection

@push('footscripts')

<script type="text/javascript">

</script>
@endpush