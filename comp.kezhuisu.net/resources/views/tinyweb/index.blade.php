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
            <li class="active">微站设置</li>
        </ul>
    </div>
    <div class="content-body">

        <div class="container-fluid">
            <ul class="nav nav-tabs" style="margin-bottom:20px;">
                <li class="active"><a data-tab href="#tabContent1">底部导航</a></li>
                <li><a data-tab href="#tabContent2">微站模板</a></li>
                <li><a data-tab href="#tabContent3">其他设置</a></li>
            </ul>
            <div class="panel">
                <div class="panel-body">
                        <div class="tab-content">

                            <div class="tab-pane active" id="tabContent1">
                                <!-- con2  -->

                                <div class="alert alert-warning alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <p>最多可设置5个菜单</p>
                                </div>

                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="80">ID</th>
                                        <th width="240">导航名称</th>
                                        <th>图标</th>
                                        <th>链接地址</th>
                                        <th width="200"> 是否显示</th>
                                        <th width="120">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($menuList as $menu)
                                    <tr>
                                        <td>{{ $menu['id'] }}</td>
                                        <td>{{ $menu['menu_name'] }}</td>
                                        <td><img  data-toggle="lightbox" src="{{ $menu['site_resources'][0]['resource_url']  or ''  }}" /></td>
                                        <td>{{ $menu['menu_url'] }}</td>
                                        <td>

                                            <div class="switch">
                                                <input class="mod_show_is_open" type="checkbox" data-id="{{ $menu['id'] or 0 }}" value="1"  @if($menu['menu_is_show'] == 1) checked="checked" @endif >
                                                <label>显示</label>
                                            </div>

                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-xs btn-primary menu_edit" data-id="{{ $menu['id'] }}" data-menu_name="{{ $menu['menu_name'] }}"  data-menu_url="{{ $menu['menu_url'] }}"   data-resource_id="{{ $menu['resource_id'] }}"  data-menu_pic_url="{{ $menu['site_resources'][0]['resource_url']  or ''  }}" data-picjson='@json($menu["site_resources"])'>编辑</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="menu_add" >
                                        <td>
                                            <span class="menu_id">0</span>
                                            <input type="hidden" value="0" name="menu_id">
                                        </td>
                                        <td><input type="text" name="menu_name" class="form-control" placeholder="自定义"></td>
                                        <td>
                                            @component('component.upfileone.piconecode')
                                            @slot('fileList')
                                            grid
                                            @endslot
                                            @slot('upload_id')
                                            menuUploader
                                            @endslot
                                            @endcomponent
                                            {{--
                                            <input type="text" name="resource_id" value="44">
                                            <img  src="" />
                                            <input type="file"  class="form-control"  value="上传图标">
                                            --}}
                                        </td>
                                        <td><input type="text" name="menu_url" class="form-control" placeholder="链接地址"></td>
                                        <td>
                                            <div class="switch">
                                                <input name="menu_is_show" value="1" type="checkbox" checked="checked">
                                                <label>显示</label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-xs btn-primary menu_oper">提交</a>
                                            <a href="#" class="btn btn-xs btn-primary menu_reset">重置</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>


                            </div>
                            <div class="tab-pane" id="tabContent2">
                                <!-- con2  -->

                                <div class="cards">
                                    @foreach ($tempList as $temp)
                                    <div class="col-md-3 col-sm-4 col-lg-2">
                                        <div class="card text-center">
                                            <img  data-toggle="lightbox" src="{{ $temp['site_resources'][0]['resource_url']  or ''  }}" alt="">

                                            <div class="btn-group" style="padding:10px;">
                                                <button class="btn apply " data-id="{{ $temp['id'] }}">应用</button>
                                                <button class="btn browse"  data-id="{{ $temp['id'] }}">预览</button>
                                                @if (isset($config['site_template_id']) && $config['site_template_id'] == $temp['id'])
                                                    <i class="icon icon-heart"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>

                            </div>
                            <div class="tab-pane" id="tabContent3">
                                <!-- con3  -->
                                <form method="post"  id="addForm">
                                    <input type="hidden" name="id" value="{{ $config['id'] or 0 }}"/>
                                    <div class="form-group">
                                        <label>背景照片</label>
                                        <div class="row">
                                            {{--上传图片--}}
                                            @component('component.upfileone.piconecode')
                                            @slot('fileList')
                                            grid
                                            @endslot
                                            @endcomponent
                                            {{--
                                            <div class="col-xs-6">
                                                <input type="file" class="form-control " value="">
                                            </div>
                                            --}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>第三方代码</label>
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <textarea class="form-control text-con"  name="third_code"  placeholder="请输入关站描述">{{ $config['third_code'] or '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="help-block">不超过250字为宜</div>
                                    </div>

                                    <div style="height:10px;" ></div>
                                    <button  type="button" id="submitBtn" class="btn btn-primary">提交</button>
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('footscripts')
<script>
    const MENU_SAVE_URL = "{{ url('api/tinyweb/' . $pro_unit_id . '/menu_save') }}";
    const IS_SHOW_SAVE_URL = "{{ url('api/tinyweb/' . $pro_unit_id . '/menu_is_show') }}";
    const SHOW_URL = '{{ config('public.tinyWebURL') . $pro_unit_id }}';
    const APPLY_SAVE_URL = "{{ url('api/tinyweb/' . $pro_unit_id . '/ajax_apply') }}";
    const SAVE_URL = "{{ url('api/tinyweb/' . $pro_unit_id . '/ajax_save') }}";
    const LIST_URL = "{{url('tinyweb/' . $pro_unit_id)}}";
    const RECORD_ID = {{ $config['id'] or 0 }};
    // 仅选择日期
    $(".form-date").datetimepicker(
            {
                language:  "zh-CN",
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                forceParse: 0,
                format: "yyyy-mm-dd"
            });
    var SUBMIT_FORM = true;//防止多次点击提交
    $(function(){
        // 一张图片上传
        @component('component.upfileone.piconejsinitincludeone')
        @slot('site_resources')
        @json($config['site_resources'] ?? [])
        @endslot
        @endcomponent
        // 菜单一张图片上传
        @component('component.upfileone.piconejsinitincludeone')
        @slot('site_resources')
        []
        @endslot
        @slot('upload_id')
        menuUploader
        @endslot
        @endcomponent
        //预览
        $(document).on("click",".browse",function(){
            var id = $(this).data("id");
            //var index_query = layer.confirm('您确定**吗？不可恢复!', {
            //    btn: ['确定','取消'] //按钮
            //}, function(){
            open_url(id);
            //    layer.close(index_query);
            //}, function(){
            //});
            return false;
        });
        //应用
        $(document).on("click",".apply",function(){
            var id = $(this).data("id");
            var index_query = layer.confirm('您确定应用吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                ajax_apply(id);
                layer.close(index_query);
            }, function(){
            });
            return false;
        });

        //提交
        $(document).on("click","#submitBtn",function(){
            //var index_query = layer.confirm('您确定提交保存吗？', {
            //    btn: ['确定','取消'] //按钮
            //}, function(){
            ajax_form();
            //    layer.close(index_query);
            // }, function(){
            //});
            return false;
        });
        // 开通/关闭显示菜单
        $(document).on("change",".mod_show_is_open",function(){
            var obj = $(this);
            var menu_is_show = 0;
            if(obj.is(':checked')) {
                menu_is_show = 1;
            }
            var id = obj.data('id');
            //if(obj.closest('tr').find('input[name=menu_is_show]').is(':checked')) {
                //alert('选中'+tem_val);
            //    menu_is_show = 1;
            //}
            //var index_query = layer.confirm('您确定提交修改吗？', {
            //    btn: ['确定','取消'] //按钮
            //}, function(){
             //   layer.close(index_query);
                ajax_open_menu(id,menu_is_show);
             //}, function(){
            //});
            return false;
        });

        //菜单编辑
        $(document).on("click",".menu_edit",function(){
            var obj = $(this);
            var id = obj.data('id');

            var menu_name = obj.data('menu_name');
            var menu_url = obj.data('menu_url');
            var picjson = obj.data('picjson');
            // var resource_id = obj.data('resource_id');
            var menu_pic_url = obj.data('menu_pic_url');

            var parantObj = obj.closest('tr');
            var menu_is_show = false;
            if(parantObj.find('.mod_show_is_open').is(':checked')) {
                menu_is_show = 1;
            }
            var addObj = $('.menu_add');
            addObj.find('input[name=menu_is_show]').prop('checked', menu_is_show);


            addObj.find('img').prop('src', menu_pic_url);

            addObj.find('.menu_id').html(id);
            addObj.find('input[name=menu_id]').val(id);

            addObj.find('input[name=menu_name]').val(menu_name);
            // addObj.find('input[name=resource_id]').val(resource_id);
            addObj.find('input[name=menu_url]').val(menu_url);

            // 获得图片资源id
            var selImgObj = $('#menuUploader').closest('.resourceBlock').find(".upload_img");
            selImgObj.empty();
            // var responseObj = $.parseJSON(picjson);
            var htmlStr = '';//
            var menupicObj = {
                "data_list":picjson
            };
            htmlStr = resolve_baidu_template('baidu_template_pic_show',menupicObj,'');
            selImgObj.append(htmlStr);

        });

        //菜单重置
        $(document).on("click",".menu_reset",function(){
            var obj = $(this);
            var addObj = $('.menu_add');
            addObj.find('input[name=menu_is_show]').prop('checked', true);


            // addObj.find('img').prop('src', '');
            var id = 0;
            addObj.find('.menu_id').html(id);
            addObj.find('input[name=menu_id]').val(id);

            addObj.find('input[name=menu_name]').val('');
            // addObj.find('input[name=resource_id]').val('44');
            addObj.find('input[name=menu_url]').val('');
            // 移除资源
            // 获得图片资源id
            var selImgObj = $('#menuUploader').closest('.resourceBlock').find(".upload_img");
            selImgObj.empty();
            // 移除文件
            var uploader = $('#menuUploader').data('zui.uploader');
            var files = uploader.getFiles();
            for (var i = 0; i < files.length; i++) {
                uploader.removeFile(files[i]);// 将文件从文件队列中移除
            }
        });


        // 提交修改菜单
        $(document).on("click",".menu_oper",function(){

            var index_query = layer.confirm('您确定提交保存吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                judgeModifMenu();
                layer.close(index_query);
             }, function(){
            });
            return false;
        });

    });
</script>
<script src="{{ asset('/js/lanmu/tinyweb.js') }}"  type="text/javascript"></script>
@endpush
@push('footlast')
@component('component.upfileincludejs')
@endcomponent
@endpush