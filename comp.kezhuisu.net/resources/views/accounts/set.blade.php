@extends('layouts.app')

@push('headscripts')
    {{--  本页单独使用 --}}
    <link href="{{asset('dist/lib/datetimepicker/datetimepicker.min.css')}}" rel="stylesheet">
    <script src="{{asset('dist/lib/datetimepicker/datetimepicker.min.js')}}"></script>
@endpush

@section('content')
    <div class="content-header">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="icon icon-home"></i></a></li>
            <li><a href="{{ url('accounts/') }}">帐号管理</a></li>
            <li class="active">资料设置</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">资料设置</div>
                </div>
                <div class="panel-body">
                    <form method="post"  id="addForm">
                        <div class="form-group">
                            <label>用户名</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <span class="text-gray">{{ $account_username or '' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>微信号</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" name="wx_account"  value="{{ $wx_account or '' }}"  class="form-control" placeholder="请填写微信号">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>真实姓名</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" name="real_name" value="{{ $real_name or '' }}"  class="form-control" placeholder="请填写真实姓名">
                                </div>
                            </div>
                        </div>


                        <button type="button" id="submitBtn" class="btn btn-primary">提交</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('footscripts')
<script>
    const SAVE_URL = "{{ url('api/accounts/ajax_set_save') }}";
    const SET_URL = "{{url('accounts/set')}}";
</script>
<script src="{{ asset('/js/lanmu/account_set.js') }}"  type="text/javascript"></script>
@endpush