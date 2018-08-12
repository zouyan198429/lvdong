@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="tpl-content-page-title">
        系统基本设置
    </div>

    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 系统基本设置
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-8">
                    <form class="am-form am-form-horizontal"  method="post"  id="addForm">
                        @foreach ($dataList as $info)
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">{{ $info['site_name'] }}</label>
                            <div class="am-u-sm-9">
                                <input type="hidden"  name="name{{ $info['id'] }}[]" value="{{ $info['id'] }}">
                                <input type="text" name="name{{ $info['id'] }}[]"  value="{{ $info['site_val'] }}" placeholder="{{ $info['site_name'] }}">
                            </div>
                        </div>
                        @endforeach
                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-2">
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

<script>
    const SAVE_URL = "{{ url('api/sys/ajax_save') }}";
    const LIST_URL = "{{url('sys')}}";

</script>
<script src="{{ asset('/js/lanmu/sys_edit.js') }}"  type="text/javascript"></script>
@endpush
