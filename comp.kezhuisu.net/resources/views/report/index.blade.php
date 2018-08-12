@extends('layouts.app')

@push('headscripts')
    {{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="content-header">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="icon icon-home"></i></a></li>
            <li class="active">检测报告</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">检测报告</div>
                </div>
                <div class="panel-body">
                    <div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <p>一次最多上传9张图片。</p>
                    </div>
                    <form method="post"  id="addForm">
                        <input type="hidden" name="id" value="{{ $id or 0 }}"/>
                        {{--上传图片--}}
                        @component('component.upfileone.piconecode')
                        @slot('fileList')
                        grid
                        @endslot
                        @endcomponent
                        {{--
                        <div id="uploaderExample" class="uploader">
                            <div class="file-list" data-drag-placeholder="请拖拽文件到此处"></div>
                            <button type="button" class="btn btn-primary uploader-btn-browse"><i class="icon icon-cloud-upload"></i> 选择文件</button>

                        </div>
                        --}}
                    </form>
                    <div class="cards">
                        @foreach ($reportsList as $report)
                        <div class="col-md-3 col-sm-4 col-lg-2 text-center">
                            <div class="text-center">
                                <img data-toggle="lightbox"  src="{{ $report['site_resources'][0]['resource_url'] or '' }}" alt="">
                                <p><a href="#" class="del" data-id="{{ $report['id'] }}"><i class="icon icon-times"></i></a></p>
                            </div>
                        </div>
                        @endforeach

                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection


@push('footscripts')
<script>
    const SAVE_URL = "{{ url('api/report/' . $pro_unit_id . '/ajax_save') }}";
    const DEL_URL = "{{ url('api/report/ajax_del') }}";
    const LIST_URL = "{{url('report/' . $pro_unit_id)}}";
    const  RECORD_PRO_ID = {{ $pro_unit_id }};
    $(function(){
        // 九张图片上传
        @include('component.upfileone.piconejsinitincludenine',[
            'uploadComplete' => 'uploadComplete();',
        ])
        // 一张图片上传
        {{--@component('component.upfileone.piconejsinitincludeone')--}}
        {{--@slot('uploadComplete')--}}
        {{--uploadComplete();--}}
        {{--@endslot--}}
        {{--@slot('site_resources')--}}
        {{--[]--}}
        {{--@endslot--}}
        {{--@endcomponent--}}
        //提交
        $(document).on("click",".del",function(){
            var id = $(this).data("id");
            var index_query = layer.confirm('您确定删除吗？不可恢复!', {
                btn: ['确定','取消'] //按钮
            }, function(){
                ajax_form(id);
                layer.close(index_query);
            }, function(){
            });
            return false;
        })
    });

</script>
<script src="{{ asset('/js/lanmu/report.js') }}"  type="text/javascript"></script>
@endpush
@push('footlast')
@component('component.upfileincludejs')
@endcomponent
@endpush