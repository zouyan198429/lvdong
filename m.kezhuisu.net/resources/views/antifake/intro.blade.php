<!-- @extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush 

@section('content')-->
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
				<h4>5551 5513 5518 4366</h4>
			</div>
			<div class="jgbox jga" >
				<p>您查询的产品是正品，感谢您的选择！请放心使用！</p>
				<div class="line"></div>
				<div class="jgpro">
					产品名称：苹果 <br />
					品种/品牌：蜗牛<br />
					生产批次：2018-50-55<br />
					生产单位：西安蜗牛网络科技有限公司
				</div>
			</div>
			<div class="jgbox jgb" >
				<p>此防伪码不存在，请核对数字后再次验证，谨防假冒!</p>
			</div> 
			<div class="jgbox jgb" >
				<p>该防伪码已于 2018-05-22  12:23:21 第一次 被查询，谨防假冒！</p>
			</div>

		</div>
		<div class="fd">
			客服电话：029-58988888
		</div>
	</div>
<!-- @endsection

@push('footscripts')
@endpush -->