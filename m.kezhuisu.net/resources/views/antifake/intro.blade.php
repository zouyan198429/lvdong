@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
<script src="{{asset('js/jquery.js')}}"></script>
@endpush 

@section('content')
	@include('menu')
	<div class="sub-header cls">
		<div class="btn-back"><a href="javascript:history.back(-1)" ><i class="fa fa-angle-left"></i></a></div>
		<h1>查询结果</h1>
	</div>
	<div class="content cls" id="fwwrap">
		<div class="hd">
			产品防伪查询结果
		</div>
		<div class="bd" id="fwcon">
			<div class="bdhead">
				<p>您输入的防伪码：</p>
				<h4 id="label_num"></h4>
			</div>
			@if ($hasLabel)
			<div class="jgbox jga" >
				<p>您查询的产品是正品，感谢您的选择！请放心使用！</p>
				<div class="line"></div>
				<div class="jgpro">
					产品名称：{{$pro_input_name or ''}} <br />
					品种/品牌：{{$pro_input_brand or ''}}<br />
					生产批次：{{$pro_input_batch or ''}}<br />
					生产单位：{{$company_info['company_name'] or ''}}
				</div>
			</div>
			@else
			<div class="jgbox jgb" >
				<p>此防伪码不存在，请核对数字后再次验证，谨防假冒!</p>
			</div>
			@endif
			@if (isset($first_time) && !empty($first_time))
			<div class="jgbox jgb" >
				<p>该防伪码已于 {{ $first_time or '' }} 第一次 被查询，谨防假冒！</p>
			</div>
			@endif

		</div>
		<div class="fd">
			<a href="tel:{{ $company_info['contact_way'] or '' }}" >客服电话：{{ $company_info['contact_way'] or '' }} </a>
		</div>
	</div>
@endsection

@push('footscripts')
	<script type="text/javascript">
        // 每隔4个字符加空格间隔
        function replaceStr(str) {
            return str.replace(/(.{4})/g,'$1 ');
        }
        $(function(){
            var label_num = "{{$label_num or ''}}";
            $("#label_num").html(replaceStr(label_num));
        });
	</script>
@endpush