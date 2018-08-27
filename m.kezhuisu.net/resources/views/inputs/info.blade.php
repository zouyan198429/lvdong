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
	<div class="sub-header cls">
		<div class="btn-back"><a href="javascript:history.back(-1)" ><i class="fa fa-angle-left"></i></a></div>
		<h1>生产投入品</h1>
	</div>
	<div class="content cls">
		<div class="bd">

			<div class="mui-content-padded content-trp">

				<h1>{{ $companyProInput['pro_input_name'] }}</h1>

				<div class="conpic">
					<img src="{{ isset($companyProInput['site_resources'][0]['resource_url']) ? url($companyProInput['site_resources'][0]['resource_url']) : '' }}" alt="Skaret View"  data-preview-src="" data-preview-group="1"  >
				</div>
				<div class="trpinfo">
					<ul>
						{{--<li>类别: {{ $companyProInput['site_pro_input']['pro_input_name'] or '' }}</li>--}}
						<li>品牌：{{ $companyProInput['pro_input_brand'] }}</li>
						<li>生产厂家：{{ $companyProInput['pro_input_factory'] }}</li>
					</ul>
				</div>
				<h3>简介：</h3>
				<div >
					{!! $companyProInput['pro_input_intro'] !!}
				</div>

			</div>


		</div>
	</div>
@endsection

@push('footscripts')
<script type="text/javascript">
	mui.plusReady(function() {
		// 获取图片地址列表
		var images = document.querySelectorAll('.mui-content-padded img');
		var urls = [];
		for(var i = 0; i < images.length; i++) {
			urls.push(images[i].src);
		}
		// 监听图片的点击
		mui('body').on('tap', 'img', function() {
			// 查询图片在列表中的位置
			// 由于dom节点列表是伪数组，需要处理一下
			var index = [].slice.call(images).indexOf(this);
			plus.nativeUI.previewImage(urls, {
				current: index,
				loop: true,
				indicator: 'number'
			});
		});
	});
</script>
@endpush