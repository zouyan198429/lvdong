@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="tpl-content-page-title">
        管理员
    </div>

    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 管理员列表
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-9">
                    <form class="am-form am-form-horizontal" method="post"  id="addForm">
                        <input type="hidden" name="id" value="{{ $id or 0 }}"/>
                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">类别</label>
                            <div class="am-u-sm-9">
                                <select name="admin_type">
                                    @foreach ($admin_types as $k=>$type)
                                    <option value="{{ $k }}"  @if(isset($admin_type) && $admin_type == $k) selected @endif >{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">用户名</label>
                            <div class="am-u-sm-9">
                                <input type="text"  name="admin_username" value="{{ $admin_username or '' }}" placeholder="帐户名">
                                <small>主要用于登录</small>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">登录密码</label>
                            <div class="am-u-sm-9">
                                <input type="password"   name="admin_password" placeholder="登录密码">
                                <small>6-12位，</small>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">确认密码</label>
                            <div class="am-u-sm-9">
                                <input type="password"  name="sure_password"  placeholder="登录密码">
                                <small>再输入一次</small>
                            </div>
                        </div>



                        <div class="am-form-group">
                            <label for="user-QQ" class="am-u-sm-3 am-form-label">真实姓名</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-QQ" name="real_name" value="{{ $real_name or '' }}" placeholder="输入真实姓名">
                            </div>
                        </div>


                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <button  type="button" id="submitBtn" class="am-btn am-btn-primary">提交</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <div class="tpl-alert"></div>
@endsection

@push('footscripts')
@endpush
@push('footlast')
<script type="text/javascript">
    const SAVE_URL = "{{ url('api/admin/ajax_save') }}";
    const LIST_URL = "{{url('admin/')}}";
</script>
<script src="{{ asset('/js/lanmu/admin_edit.js') }}"  type="text/javascript"></script>
@endpush