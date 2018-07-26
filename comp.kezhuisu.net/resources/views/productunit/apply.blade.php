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
            <li><a href="{{ url('productunit/') }}">生产单元</a></li>
            <li class="active">申请生产单元</li>
        </ul>
    </div>
    <div class="content-body">
        <div class="container-fluid">
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p>提交申请后，我们会在3个工作日内完成审核。</p>
            </div>
            <div class="panel">
                <div class="panel-body">
                    <form  method="post"  id="addForm">
                        <input type="hidden" name="id" value="{{ $id or 0 }}"/>
                        <div class="form-group">
                            <label>类别</label>
                            <div class="row">
                                <div class="col-xs-3">
                                    <select class="form-control" name="site_pro_unit_id">
                                        <option value="">请选择</option>
                                        @foreach ($unitcls as $key=>$item)
                                            <option value="{{ $key }}" @if ( $key == $site_pro_unit_id ) selected @endif>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xs-3">
                                    <select class="form-control"  name="site_pro_unit_id_two">
                                        <option value="">请选择</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>上传图片</label>
                            <div class="row">
                                {{--上传图片--}}
                                @component('component.upfileone.piconecode')
                                @slot('fileList')
                                grid
                                @endslot
                                @endcomponent
                                {{--
                                <div class="col-xs-6">
                                    <input type="file" class="form-control" value="">
                                </div>
                                --}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>产品全称</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" name="pro_input_name" value="{{ $pro_input_name or '' }}"  class="form-control" placeholder="请输入产品名称">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>品种/品牌</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" name="pro_input_brand" value="{{ $pro_input_brand or '' }}"  class="form-control" placeholder="请输入品种/品牌">
                                </div>
                            </div>
                            <div class="help-block">如：红富士</div>
                        </div>
                        <div class="form-group">
                            <label>批次</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" name="pro_input_batch" value="{{ $pro_input_batch or '' }}"  class="form-control" placeholder="请输入品种/品牌">
                                </div>
                            </div>
                            <div class="help-block">如：第0101批</div>
                        </div>
                        <div class="form-group">
                            <label>生产记录起止日期</label>
                            <div class="row">
                                <div class="col-xs-3">
                                    <input type="text" name="begin_time" value="{{ $begin_time or '' }}"  class="form-control form-date" placeholder="选择或者输入一个日期：yyyy-MM">
                                </div>
                                <div class="col-xs-3">
                                    <input type="text"  name="end_time" value="{{ $end_time or '' }}"  class="form-control form-date" placeholder="选择或者输入一个日期：yyyy-MM">
                                </div>
                            </div>
                            <div class="help-block">可选择到月</div>
                        </div>
                        <div class="form-group">
                            <label>维护负责人</label>
                            <div class="{{--checkbox-custom--}} checkbox-primary selAccounts">
                                @foreach ($accountList as $account)
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="{{ $account['id'] or '' }}" name="accout_id[]"  @if($account['checked'] == 1) checked="checked" @endif > {{ $account['real_name'] or '' }}
                                </label>
                                @endforeach
                            </div>
                            <div class="help-block">可选择多人共同维护，如果没有请到<a href="{{ url('accounts/') }}">帐号管理</a>栏目进行添加。</div>
                        </div>
                        <div class="form-group">
                            <label>产品简介</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <textarea name="pro_input_intro"  class="form-control text-con" placeholder="请输入关站描述">{{ $pro_input_intro or '' }}</textarea>
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
    // 仅选择日期
    $(".form-date").datetimepicker({
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
        @json($site_resources ?? [])
        @endslot
        @endcomponent
        //当前省市区县
        @if ($site_pro_unit_id >0 )
            changeCls({{ $site_pro_unit_id }} ,{{ $site_pro_unit_id_two }});
        @endif
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
        })

        //第一级分类值变动
        $(document).on("change",'select[name=site_pro_unit_id]',function(){
            var obj = $(this);
            var selval = obj.val();
            changeCls(selval,0);
            return false;
        });
    });
    // 下拉框选择事件
    function changeCls(area_id,second_id){
        var obj =$('select[name=site_pro_unit_id_two]');
        var empty_option_json = {"": "请选择"};
        var empty_option_html = reset_sel_option(empty_option_json);//请选择省
        obj.empty();//清空下拉
        obj.append(empty_option_html);

        var option_html = "";
        var level = 2;
        if(area_id>0 && level>0){
            var layer_index = layer.load();//layer.msg('加载中', {icon: 16});
            //ajax请求银行信息
            var data = {};
            data['area_id'] = area_id;
            data['level'] = level;
            $.ajax({
                'async': false,//同步
                'type' : 'POST',
                'url' : '/api/unitCls',
                'data' : data,
                'dataType' : 'json',
                'success' : function(ret){
                    if(!ret.apistatus){//失败
                        //alert('失败');
                        err_alert(ret.errorMsg);
                    }else{//成功
                        //alert('成功');
                        option_html = reset_sel_option(ret.result);
                        obj.append(option_html);
                        console.log('加载成功');
                    }
                    layer.close(layer_index);//手动关闭
                }
            });
        }
        if(second_id > 0){
            obj.val(second_id);
        }
    }
    //ajax提交表单
    function ajax_form(){
        if (!SUBMIT_FORM) return false;//false，则返回

        // 验证信息
        var id = $('input[name=id]').val();
        if(!judge_validate(4,'生产单元id',id,true,'digit','','')){
            return false;
        }

        var site_pro_unit_id = $('select[name=site_pro_unit_id]').val();
        if(!judge_validate(4,'类别',site_pro_unit_id,true,'digit','','')){
            return false;
        }

        // 判断是否上传图片
        var uploader = $('#myUploader').data('zui.uploader');
        var files = uploader.getFiles();
        var filesCount = files.length;

        var imgObj = $('#myUploader').closest('.resourceBlock').find(".upload_img")

        if( (!judge_list_checked(imgObj,3)) && filesCount <=0 ) {//没有选中的
            layer_alert('请选择要上传的图片！',3,0);
            return false;
        }


        var pro_input_name = $('input[name=pro_input_name]').val();
        if(!judge_validate(4,'产品全称',pro_input_name,true,'length',2,40)){
            return false;
        }

        var pro_input_brand = $('input[name=pro_input_brand]').val();
        if(!judge_validate(4,'品种/品牌',pro_input_brand,true,'length',2,20)){
            return false;
        }

        var pro_input_batch = $('input[name=pro_input_batch]').val();
        if(!judge_validate(4,'批次',pro_input_batch,true,'length',2,30)){
            return false;
        }

        var begin_time = $('input[name=begin_time]').val();
        if(!judge_validate(4,'开始日期',begin_time,true,'date','','')){
            return false;
        }

        var end_time = $('input[name=end_time]').val();
        if(!judge_validate(4,'结束日期',end_time,true,'date','','')){
            return false;
        }

        if(!judge_validate(4,'结束日期必须',end_time,true,'data_size',begin_time,5)){
            return false;
        }

        if(!judge_list_checked('selAccounts',2)) {//没有选中的
            layer_alert('请选择维护负责人！',3,0);
            return false;
        }

        var pro_input_intro = $('textarea[name=pro_input_intro]').val();
        if(!judge_validate(4,'备注',pro_input_intro,false,'length',3,250)){
            return false;
        }

        // 上传图片
        if(filesCount > 0){
            var layer_index = layer.load();
            uploader.start();
            var intervalId = setInterval(function(){
                var status = uploader.getState();
                console.log('获取上传队列状态代码',uploader.getState());
                if(status == 1){
                    layer.close(layer_index)//手动关闭
                    clearInterval(intervalId);
                    ajax_save();
                }
            },1000);
        }else{
            ajax_save();
        }

    }

    function ajax_save(){
        // 验证通过
        SUBMIT_FORM = false;//标记为已经提交过
        var data = $("#addForm").serialize();
        console.log("{{ url('api/productunit/ajax_save') }}");
        console.log(data);
        var layer_index = layer.load();
        $.ajax({
            'type' : 'POST',
            'url' : '{{ url('api/productunit/ajax_save') }}',
            'data' : data,
            'dataType' : 'json',
            'success' : function(ret){
                console.log(ret);
                if(!ret.apistatus){//失败
                    SUBMIT_FORM = true;//标记为未提交过
                    //alert('失败');
                    err_alert(ret.errorMsg);
                }else{//成功
                    go("{{url('productunit/')}}");
                    // var supplier_id = ret.result['supplier_id'];
                    //if(SUPPLIER_ID_VAL <= 0 && judge_integerpositive(supplier_id)){
                    //    SUPPLIER_ID_VAL = supplier_id;
                    //    $('input[name="supplier_id"]').val(supplier_id);
                    //}
                    // save_success();
                }
                layer.close(layer_index)//手动关闭
            }
        })
        return false;
    }
</script>
@endpush
@push('footlast')
@component('component.upfileincludejs')
@endcomponent
@endpush