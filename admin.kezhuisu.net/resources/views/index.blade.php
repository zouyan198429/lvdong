@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
<link rel="icon" type="image/png" href="{{asset('assets/i/favicon.png')}}">
<link rel="apple-touch-icon-precomposed" href="{{asset('assets/i/app-icon72x72@2x.png')}}">
<script src="{{asset('assets/js/echarts.min.js')}}"></script>
@endpush

@section('content')
	<div class="tpl-content-page-title">
		首页
	</div>

	<div class="tpl-content-scope">
		<div class="note note-info">
			<h3>为科技农业而生</h3>
			<p> Amaze UI 含近 20 个 CSS 组件、20 余 JS 组件，更有多个包含不同主题的 Web 组件，可快速构建界面出色、体验优秀的跨屏页面，大幅提升开发效率。</p>
			<p><span class="label label-danger">提示:</span> Amaze UI 关注中文排版，根据用户代理调整字体，实现更好的中文排版效果。
			</p>
		</div>
	</div>

	<div class="row">
		<div class="am-u-lg-3 am-u-md-6 am-u-sm-12">
			<div class="dashboard-stat blue">
				<div class="visual">
					<i class="am-icon-comments-o"></i>
				</div>
				<div class="details">
					<div class="number"> {{ $companyCount or 0 }} </div>
					<div class="desc"> 会员总数 </div>
				</div>
				<a class="more" href="{{ url('member/') }}"> 查看更多
					<i class="m-icon-swapright m-icon-white"></i>
				</a>
			</div>
		</div>
		<div class="am-u-lg-3 am-u-md-6 am-u-sm-12">
			<div class="dashboard-stat red">
				<div class="visual">
					<i class="am-icon-bar-chart-o"></i>
				</div>
				<div class="details">
					<div class="number"> {{ $todayRegCount or 0 }}</div>
					<div class="desc"> 今日注册 </div>
				</div>
				<a class="more" href="{{ url('member/') }}"> 查看更多
					<i class="m-icon-swapright m-icon-white"></i>
				</a>
			</div>
		</div>
		<div class="am-u-lg-3 am-u-md-6 am-u-sm-12">
			<div class="dashboard-stat green">
				<div class="visual">
					<i class="am-icon-apple"></i>
				</div>
				<div class="details">
					<div class="number"> {{ $todayRecordCount or 0 }} </div>
					<div class="desc"> 今日日志 </div>
				</div>
				<a class="more" href="{{ url('handles/') }}"> 查看更多
					<i class="m-icon-swapright m-icon-white"></i>
				</a>
			</div>
		</div>
		<div class="am-u-lg-3 am-u-md-6 am-u-sm-12">
			<div class="dashboard-stat purple">
				<div class="visual">
					<i class="am-icon-android"></i>
				</div>
				<div class="details">
					<div class="number"> {{ $unitWaitCount or 0 }} </div>
					<div class="desc"> 等待审核 </div>
				</div>
				<a class="more" href="{{ url('productunit/') }}"> 查看更多
					<i class="m-icon-swapright m-icon-white"></i>
				</a>
			</div>
		</div>



	</div>

	<div class="row">
		<div class="am-u-md-6 am-u-sm-12 row-mb">
			<div class="tpl-portlet">
				<div class="tpl-portlet-title">
					<div class="tpl-caption font-green ">
						<i class="am-icon-cloud-download"></i>
						<span> Cloud 数据统计</span>
					</div>
				</div>

				<!--此部分数据请在 js文件夹下中的 app.js 中的 “百度图表A” 处修改数据 插件使用的是 百度echarts-->
				<div class="tpl-echarts" id="tpl-echarts-A">

				</div>
			</div>
		</div>
		<div class="am-u-md-6 am-u-sm-12 row-mb">
			<div class="tpl-portlet">
				<div class="tpl-portlet-title">
					<div class="tpl-caption font-red ">
						<i class="am-icon-bar-chart"></i>
						<span>最新注册会员</span>
					</div>
				</div>
				<div class="tpl-scrollable">

					<table class="am-table tpl-table">
						<thead>
						<tr class="tpl-table-uppercase">
							{{--<th>用户名</th>--}}
							<th>真实姓名</th>
							<th>企业</th>
							<th>手机</th>
							{{--<th>省/市真实姓名</th>--}}
							<th>注册时间</th>
						</tr>
						</thead>
						<tbody>
						@foreach ($newRegList as $info)
						<tr>
							{{--
							<td>
								<a class="user-name" href="###">mszyhx</a>
							</td>
							--}}
							<td>{{ $info['company_linkman'] }}</td>
							<td>{{ $info['company_name'] }}</td>
							<td class="font-green bold">{{ $info['company_mobile'] }}</td>
							{{--<td>陕西/咸阳</td>--}}
							<td>{{ $info['created_at'] }}</td>
						</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('footscripts')
@endpush