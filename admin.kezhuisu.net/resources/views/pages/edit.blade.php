@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
<script src="{{asset('dist/lib/kindeditor/kindeditor.min.js')}}"></script>
@endpush

@section('content')
    <div class="tpl-content-page-title">
        编辑新闻
    </div>

    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 编辑新闻
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-8">
                    <form class="am-form am-form-horizontal" method="post"  id="addForm">
                        <input type="hidden" name="id" value="{{ $id or 0 }}"/>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">标题</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-name" name="intro_title" value="{{ $intro_title or '' }}" placeholder="标题">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">内容</label>
                            <div class="am-u-sm-9">
                                <textarea class="kindeditor" rows="25" id="doc-ta-1" name="intro_content">{!!  htmlspecialchars($intro_content ?? '' )   !!}</textarea>
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
    const SAVE_URL = "{{ url('api/pages/ajax_save') }}";
    const LIST_URL = "{{url('pages/')}}";
</script>
<script src="{{ asset('/js/lanmu/pages_edit.js') }}"  type="text/javascript"></script>
@endpush