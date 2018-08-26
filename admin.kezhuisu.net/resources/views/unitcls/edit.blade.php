@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="tpl-content-page-title">
        编辑生产单元分类
    </div>

    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 编辑生产单元分类
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-8">
                    <form class="am-form am-form-horizontal" method="post"  id="addForm">
                        <input type="hidden" name="id" value="{{ $id or 0 }}"/>
                        <div class="am-form-group" >
                            <label for="user-name" class="am-u-sm-3 am-form-label">父级分类</label>
                            <div class="am-u-sm-9">
                                <select class="form-control" name="pro_unit_parent_id">
                                    <option value="">请选择分类</option>
                                    <option value="0"  @if ( 0 == $pro_unit_parent_id ) selected @endif>父级分类</option>
                                    @foreach ($parents as $item)
                                    <option value="{{ $item['id'] }}"  @if ( $item['id'] == $pro_unit_parent_id ) selected @endif>{{ $item['pro_unit_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">名称</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-name" name="pro_unit_name" value="{{ $pro_unit_name or '' }}" placeholder="标题">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">排序[降序]</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="pro_unit_order" onkeyup="isnum(this) " onafterpaste="isnum(this)"  value="{{ $pro_unit_order or '' }}" id="user-name" placeholder="可自行设定">
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
    const SAVE_URL = "{{ url('api/unitcls/ajax_save') }}";
    const LIST_URL = "{{url('unitcls/')}}";

</script>
<script src="{{ asset('/js/lanmu/unitcls_edit.js') }}"  type="text/javascript"></script>
@endpush