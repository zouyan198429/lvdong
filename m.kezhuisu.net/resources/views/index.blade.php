@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
	@include('menu')
	<div class="main" class="ui-content">
		<div class="box cls">
			<div class="hd"><h3>商品档案</h3></div>
			<div class="bd">

				<table class="datable" >
					<tbody>
					<tr>
						<th><div class="datit">生产批次</div></th>
						<td>{{ $pro_input_batch }}</td>
					</tr>
					<tr>
						<th><div class="datit">生产周期</div></th>
						<td>{{ date('Y-m-d',strtotime($begin_time)) }}-{{ date('Y-m-d',strtotime($end_time)) }}</td>
					</tr>
					<tr>
						<th><div class="datit">生产负责</div></th>
						<td>
							@foreach ($pro_unit_accounts as $pro_unit_account)
								{{ $pro_unit_account['real_name'] }}
							@endforeach

						</td>
					</tr>
					<tr>
						<th><div class="datit">商品产地</div></th>
						<td>{{ $pro_input_addr }}</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="box cls">
			<div class="hd"><h3>生产节点</h3></div>
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

			</div>
		</div>

		<div class="box cls" >
			<div class="hd"><h3>生产投入品</h3></div>
			<div class="bd">
				<ul class="itrp cls">
					@foreach ($pro_inputs as $pro_input)
					<li><a href="{{ url('inputs/info/' . $pro_unit_id . '/' . $pro_input['id']) }}" ><div class="pic"><img src="{{ isset($pro_input['site_resources'][0]['resource_url']) ? url($pro_input['site_resources'][0]['resource_url']) : '' }}"></div><p>{{ $pro_input['pro_input_name'] }}</p></a></li>
					@endforeach

				</ul>
			</div>
		</div>
	</div>

@endsection

@push('footscripts')
@endpush