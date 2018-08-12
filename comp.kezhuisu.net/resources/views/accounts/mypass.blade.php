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
            <li class="active">修改密码</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">修改密码</div>
                </div>
                <div class="panel-body">
                    <form  method="post"  id="addForm">
                        <div class="form-group">
                            <label>密码</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input name="account_password"  type="password" class="form-control" placeholder="请输入密码">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>确认密码</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input  name="sure_password"  type="password" class="form-control" placeholder="现次输入密码">
                                </div>
                            </div>
                        </div>
                        <button  type="button" id="submitBtn"  class="btn btn-primary">提交</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('footscripts')
<script>
    const SAVE_URL = "{{ url('api/accounts/ajax_password_save') }}";
    const SET_URL = "{{url('accounts/mypass')}}";

</script>
<script src="{{ asset('/js/lanmu/account_password.js') }}"  type="text/javascript"></script>
@endpush