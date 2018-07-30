@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
	@include('menu')


<div class="header cls">
	<div class="logo"><img src="{{ isset($site_resources[0]['resource_url']) ? url($site_resources[0]['resource_url']) : '' }}" ></div>
</div>
 


	<div class="main" class="ui-content">
		<div class="box cls">
			<div class="hd"><h3>产品信息</h3></div>
			<div class="bd">

				<table class="datable" >
					<tbody>
					<tr>
						<th><div class="datit">产品名称</div></th>
						<td>{{ $pro_input_name }}</td>
					</tr>
					<tr>
						<th><div class="datit">品种</div></th>
						<td>***</td>
					</tr>
					<tr>
						<th><div class="datit">生产批次</div></th>
						<td>{{ $pro_input_batch }}</td>
					</tr>
					<tr>
						<th><div class="datit">生产周期</div></th>
						<td>{{ date('Y-m-d',strtotime($begin_time)) }}-{{ date('Y-m-d',strtotime($end_time)) }}</td>
					</tr>
					<tr>
						<th><div class="datit">生产企业</div></th>
						<td>{{ $company_info['company_name'] or '' }}</td>
					</tr>
					<tr>
						<th><div class="datit">农事记录人</div></th>
						<td>
							@foreach ($pro_unit_accounts as $pro_unit_account)
								{{ $pro_unit_account['real_name'] }}
							@endforeach

						</td>
					</tr> 
					</tbody>
				</table>
			</div>
		</div>

		<div class="box cls">
			<div class="hd"><h3>生产记录</h3></div>
			<div class="bd">
				<table class="jdtable">
					<thead>
					<tr>
						<td style="width:3.5rem;">

						</td>
						<td>

						</td>
						<td>

						</td>
					</tr>
					</thead>
					<tbody>
					@foreach ($pro_records as $pro_record)
					<tr>
						<td>
							<div class="jddate">
								<strong>{{ date('m-d',strtotime($pro_record['created_at'])) }}</strong><br />
								<span>{{ date('Y',strtotime($pro_record['created_at'])) }}</span>
							</div>
						</td>
						<td class="jdpictd">
							<div class="jdpic"><img src="{{ isset($pro_record['site_resources'][0]['resource_url']) ? url($pro_record['site_resources'][0]['resource_url']) : '' }}" alt=""></div>
						</td>
						<td>
							<div class="jdtxt">
								<p>{!! $pro_record['record_intro'] !!}</p>
							</div>
						</td>
					</tr>
					@endforeach

					</tbody>
					<tfoot>
					<tr>
						<td>

						</td>
						<td>

						</td>
						<td>

						</td>
					</tr>
					</tfoot>

				</table>
				<a href="{{ url('handles/' . $pro_unit_id) }}">更多农事记录</a>

			</div>
		</div>
<!-- 
		<div class="box cls" >
			<div class="hd"><h3>生产投入品</h3></div>
			<div class="bd">
				<ul class="itrp cls">
					@foreach ($pro_inputs as $pro_input)
					<li><a href="{{ url('inputs/info/' . $pro_unit_id . '/' . $pro_input['id']) }}" ><div class="pic"><img src="{{ isset($pro_input['site_resources'][0]['resource_url']) ? url($pro_input['site_resources'][0]['resource_url']) : '' }}"></div><p>{{ $pro_input['pro_input_name'] }}</p></a></li>
					@endforeach

				</ul>
			</div>
		</div> -->
	</div>

@endsection

@push('footscripts')
@endpush