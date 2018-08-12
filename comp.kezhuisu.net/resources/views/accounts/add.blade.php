@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
<!-- 本页单独使用 -->
<link href="{{asset('dist/lib/datetimepicker/datetimepicker.min.css')}}" rel="stylesheet">
<script src="{{asset('dist/lib/datetimepicker/datetimepicker.min.js')}}"></script>
@endpush

@section('content')
    <div class="content-header">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="icon icon-home"></i></a></li>
            <li><a href="{{ url('accounts/') }}">帐号管理</a></li>
            <li class="active">增加新帐号</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">增加新帐号</div>
                </div>
                <div class="panel-body">
                    <form method="post"  id="addForm">
                        <input type="hidden" name="id" value="{{ $id or 0 }}"/>
                        <div class="form-group">
                            <label><span class="red">*</span> 手机号</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input name="mobile" value="{{ $mobile or '' }}" type="text" class="form-control" placeholder="请填写手机号">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><span class="red">*</span> 用户名</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input name="account_username" value="{{ $account_username or '' }}" type="text" class="form-control" placeholder="请输入用户名">
                                </div>
                            </div>
                            <div class="help-block">字母加数字，不超过20个字符。</div>
                        </div>
                        @if ($id <= 0 )
                        <div class="form-group">
                            <label><span class="red">*</span> 密码</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input name="account_password" type="password" class="form-control" placeholder="请输入密码">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><span class="red">*</span> 确认密码</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input name="sure_password" type="password" class="form-control" placeholder="现次输入密码">
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label>微信号</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input name="wx_account" value="{{ $wx_account or '' }}"  type="text" class="form-control" placeholder="请填写微信号">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>真实姓名</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input name="real_name" value="{{ $real_name or '' }}" type="text" class="form-control" placeholder="请填写真实姓名">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>状态</label>
                            <div class="row">
                                <div class="col-xs-3">
                                    <select name="account_status" class="form-control">
                                        <option value="">请选择类别</option>
                                        <option value="0" @if($account_status == 0) selected @endif>正常</option>
                                        @if($account_issuper == 0)
                                        <option value="1"  @if($account_status == 1) selected @endif>冻结</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>备注</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <textarea name="remarks" class="form-control text-con" placeholder="备注内容">{{ $remarks or '' }}</textarea>
                                </div>
                            </div>
                            <div class="help-block">不超过250字为宜</div>
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
    const SAVE_URL = "{{ url('api/accounts/ajax_save') }}";
    const LIST_URL = "{{url('accounts/')}}";
    const RECORD_ID = {{ $id }};
</script>
<script src="{{ asset('/js/lanmu/account_edit.js') }}"  type="text/javascript"></script>
@endpush