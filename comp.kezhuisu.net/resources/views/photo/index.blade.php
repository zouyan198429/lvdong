@extends('layouts.app')

@push('headscripts')
    {{--  本页单独使用 --}}
@endpush

@section('content')
    <div class="content-header">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="icon icon-home"></i></a></li>
            <li class="active">企业相册</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p>新用户至少需要申请一个生产单元！</p>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">企业相册</div>
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
                        @foreach ($photosList as $photo)
                        <div class="col-md-4 col-sm-6 col-lg-3">
                            <div class="card">
                                <img data-toggle="lightbox"  src="{{ $photo['site_resources'][0]['resource_url'] or '' }}" alt="">
                                <div class="pre with-padding clearfix">
                                    <h4 class="text-ellipsis">{{ $photo['phonto_name'] }}</h4>
                                    <p class="text-gray">上传日期：{{ date('Y-m-d',strtotime($photo['created_at'])) }}</p>
                                    <i class="icon icon-times pull-right del"  data-id="{{ $photo['id'] }}"></i>
                                </div>
                            </div>
                        </div>
                        @endforeach



                    </div>
                    {{--
                    <ul class="pager">
                        <li class="previous"><a href="">«</a></li>
                        <li><a href="">1</a></li>
                        <li class="active"><a href="">2</a></li>
                        <li><a href="">3</a></li>
                        <li><a href="">4</a></li>
                        <li><a href="">5</a></li>
                        <li class="next"><a href="">»</a></li>
                    </ul>
                    --}}

                </div>
            </div>
        </div>
    </div>
@endsection


@push('footscripts')

<script type="text/javascript">
    const SAVE_URL = "{{ url('api/photo/ajax_save') }}";
    const LIST_URL = "{{url('photo/')}}";
    const DEL_URL = "{{ url('api/photo/ajax_del') }}";//删除页面地址

    var SUBMIT_FORM = true;//防止多次点击提交
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
<script src="{{ asset('/js/lanmu/phone.js') }}"  type="text/javascript"></script>
@endpush
@push('footlast')
@component('component.upfileincludejs')
@endcomponent
@endpush