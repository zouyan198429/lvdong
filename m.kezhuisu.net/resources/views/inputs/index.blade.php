@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
	@include('menu')
	<div class="box cls">
		<div class="hd"><h3>投入品</h3></div>
		<div class="bd">

			<ul class="trplist">
				@foreach ($pro_inputs as $pro_input)
				<li>
					<a href="{{ url('inputs/info/' . $pro_unit_id . '/' . $pro_input['id']) }}">
						<div class="pic">
							<img src="{{ isset($pro_input['site_resources'][0]['resource_url']) ? url($pro_input['site_resources'][0]['resource_url']) : '' }}" alt="Skaret View" style="width:200px;"  >
						</div>
						<p>【{{ $pro_input['site_pro_input']['pro_input_name'] or '' }}】 {{ $pro_input['pro_input_name'] }}</p>
					</a>
				</li>
				@endforeach

			</ul>

		</div>
	</div>

@endsection

@push('footscripts')
@endpush