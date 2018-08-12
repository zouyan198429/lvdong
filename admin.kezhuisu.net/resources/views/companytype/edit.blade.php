@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
<script src="{{asset('dist/lib/kindeditor/kindeditor.min.js')}}"></script>
@endpush

@section('content')
    <div class="tpl-content-page-title">
        编辑公司类型
    </div>

    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 编辑公司类型
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-8">
                    <form class="am-form am-form-horizontal" method="post"  id="addForm">
                        <input type="hidden" name="id" value="{{ $id or 0 }}"/>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">名称</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-name" name="type_name" value="{{ $type_name or '' }}" placeholder="名称">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <button  type="button" id="submitBtn"  class="am-btn am-btn-primary">提交</button>
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
    const SAVE_URL = "{{ url('api/companyType/ajax_save') }}";
    const LIST_URL = "{{url('companyType/')}}";

</script>
<script src="{{ asset('/js/lanmu/companytype_edit.js') }}"  type="text/javascript"></script>
@endpush