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
                                <input type="text" id="user-name" name="new_title" value="{{ $new_title or '' }}" placeholder="标题">
                            </div>
                        </div>
                        {{--
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">封面图片</label>
                            <div class="am-u-sm-9">
                                <div class="am-form-group am-form-file">
                                    <button type="button" class="am-btn am-btn-default am-btn-sm">
                                        <i class="am-icon-cloud-upload"></i> 选择要上传的文件</button>
                                    <input type="file" multiple>
                                </div>
                            </div>
                        </div>
                        --}}
                        {{--
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">阅读权限</label>
                            <div class="am-u-sm-9">
                                <div class="am-form-group">
                                    <label class="am-checkbox-inline">
                                        <input type="checkbox" value="option1"> 全部
                                    </label>
                                    <label class="am-checkbox-inline">
                                        <input type="checkbox" value="option1"> 种植
                                    </label>
                                    <label class="am-checkbox-inline">
                                        <input type="checkbox" value="option2"> 养殖
                                    </label>
                                    <label class="am-checkbox-inline">
                                        <input type="checkbox" value="option3"> 渔业
                                    </label>
                                </div>
                            </div>
                        </div>
                        --}}
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">内容</label>
                            <div class="am-u-sm-9">
                                <textarea class="kindeditor" name="new_content" rows="15" id="doc-ta-1">{!!  htmlspecialchars($new_content ?? '' )   !!}</textarea>
                            </div>
                        </div>
                        {{--
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">发布时间</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-name" placeholder="可自行设定">
                            </div>
                        </div>
                        --}}

                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">阅读量</label>
                            <div class="am-u-sm-9">
                                <input type="text"  onkeyup="isnum(this) " onafterpaste="isnum(this)" name="volume" value="{{ $volume or '' }}" id="user-name" placeholder="可自行设定">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-QQ" class="am-u-sm-3 am-form-label">新闻来源</label>
                            <div class="am-u-sm-9">
                                <input type="text" pattern="[0-9]*" id="user-QQ" name="new_source" value="{{ $new_source or '' }}" placeholder="新闻来源">
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
    const SAVE_URL = "{{ url('api/news/ajax_save') }}";
    const LIST_URL = "{{url('news/')}}";
</script>
<script src="{{ asset('/js/lanmu/news_edit.js') }}"  type="text/javascript"></script>
@endpush