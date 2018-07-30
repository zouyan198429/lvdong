@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
<link href="{{asset('dist/lib/datetimepicker/datetimepicker.min.css')}}" rel="stylesheet">
<script src="{{asset('dist/lib/datetimepicker/datetimepicker.min.js')}}"></script>

<link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css">
<script src="{{asset('dist/lib/kindeditor/kindeditor.min.js')}}"></script>
{{--
<link href="{{asset('dist/lib/uploader/zui.uploader.min.css')}}" rel="stylesheet">
<script src="{{asset('dist/lib/uploader/zui.uploader.min.js')}}"></script>
--}}
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

            <ul class="nav nav-tabs" style="margin-bottom:20px;">
                <li class="active"><a data-tab href="#tabContent1">基本信息</a></li>
                <li><a data-tab href="#tabContent2">企业简介</a></li>
                <li><a data-tab href="#tabContent3">资质证书</a></li>
            </ul>


            <div class="panel">
                <div class="panel-body">
                        <div class="tab-content">

                            <div class="tab-pane active" id="tabContent1">
                                <!-- con1  -->

                                <form  method="post"  id="addForm1">
                                <div class="form-group">
                                    <label>企业名称</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input type="text"  name="company_name" value="{{ $company_name or '' }}"  class="form-control" placeholder="请输入企业名称">
                                        </div>
                                    </div>
                                    <div class="help-block">如：西安某某农业技术有限公司</div>
                                </div>
                               <!--  <div class="form-group">
                                    <label>企业简称</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input type="text"  name="company_simple_name" value="{{ $company_simple_name or '' }}"  class="form-control" placeholder="请输入企业简称">
                                        </div>
                                    </div>
                                    <div class="help-block">如：西安某某农业</div>
                                </div> -->
<!-- 
                                <div class="form-group">
                                    <label>所在地区</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="row">
                                                @include('public.area_select.area_select', ['province_id' => 'province_id','city_id' => 'city_id','area_id' => 'area_id'])
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label>公司地址</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input type="text"  name="company_addr" value="{{ $company_addr or '' }}"  class="form-control" placeholder="请输入公司地址">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>生产地址</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input type="text"  name="product_addr" value="{{ $product_addr or '' }}"  class="form-control" placeholder="请输入生产地址">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>主营产品</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <textarea class="form-control text-con"   name="company_mainproduct"  placeholder="请输入关站描述">{{ $company_mainproduct or '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="help-block">不超过250字为宜</div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label>统一社会信用代码</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input type="text"   name="ccredit_code" value="{{ $ccredit_code or '' }}"  class="form-control" placeholder="请输入统一社会信用代码或营业执照号码">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>成立时间</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input type="text"  name="company_createtime" value="{{ $company_createtime or '' }}"  class="form-control form-date" placeholder="请输入成立时间">
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label>注册资金</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input type="text"  name="reg_capital" value="{{ $reg_capital or '' }}"  class="form-control" placeholder="请输入注册资金">
                                        </div>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label>法定代表人</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input type="text"  name="legal_name" value="{{ $legal_name or '' }}"  class="form-control" placeholder="请输入法定代表人">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>联系方式</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <textarea class="form-control text-con"   name="contact_way"  style="height:10em" placeholder="请输入联系方式">{{ $contact_way or '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="help-block">不超过250字为宜</div>
                                </div>
                                <div style="height:10px;" ></div>

                                <button  type="button" id="submitBtn1" class="btn btn-primary w240">提交</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="tabContent2">

                                <form  method="post"  id="addForm2" action="{{ url('company/intro_save') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $company_extend['id'] or 0 }}"/>
                                <!-- con2  -->
                                <textarea id="company_intro" name="company_intro" class="form-control kindeditor" style="height:450px; width:100%; ">{!!  htmlspecialchars($company_extend['company_intro'] ?? '' )   !!}</textarea>

                                <div style="height:10px;" ></div>

                                    <button  type="submit" id="submitBtn2" class="btn btn-primary w240">提交</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="tabContent3">
                                <!-- con3  -->
                                <!-- <div class="alert alert-warning alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <p>营业执照为必要资质，有机认证为选传。</p>
                                </div>
                                <div class="alert alert-warning alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <p>一次最多上传9张图片。</p>
                                </div> -->
                                <form method="post"  id="addFormfile">
                                    <input type="hidden" name="id" value="0"/>
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

                                <hr>

                                <div class="c"></div>
                                @foreach ($honors as $honor)
                                <div class="rzlist">

                                    <span class="rztag">
                                        @switch($honor['status'])
                                            @case(0)
                                                <i class="fa fa-clock-o" aria-hidden="true"></i> 正在审核
                                                @break
                                            @case(1)
                                                <i class="fa fa-check-square" aria-hidden="true"></i> 已审核

                                                @break
                                            @case(2)
                                                <i class="fa " aria-hidden="true"></i> 未通过审核
                                                @break
                                        @endswitch
                                    </span>
                                    <a href="{{ $honor['site_resources'][0]['resource_url'] or '' }}" target="_blank"><img  data-toggle="lightbox"  src="{{ $honor['site_resources'][0]['resource_url']  or ''  }}" alt=""></a>
                                </div>
                                @endforeach

                                <div class="c"></div>

                            </div>
                        </div>



                </div>
            </div>



        </div>
    </div>
@endsection


@push('footscripts')
<script type="text/javascript">
    {{--
    KindEditor.create('textarea.kindeditor', {
        basePath: "{{asset('dist/lib/kindeditor/')}}",
        allowFileManager : true,
        bodyClass : 'article-content'
    });

    $('#uploaderExample').uploader({
        autoUpload: true,            // 当选择文件后立即自动进行上传操作
        url: 'your/file/upload/url'  // 文件上传提交地址
    });
    --}}
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
        reset_area_sel(0,1,'');//初始化省

        //当前省市区县
        @if (!empty($province_id))
            var area_json = {"province":{"id":"province_id","value":"{{ $province_id or '' }}"},"city":{"id":"city_id","value":"{{ $city_id or '' }}"},"area":{"id":"area_id","value":"{{ $area_id or '' }}"}}
            init_area_sel(area_json,1);
        @endif
        // 富文本
        KindEditor.create('textarea.kindeditor', {
            basePath: '/dist/lib/kindeditor/',
            allowFileManager : true,
            bodyClass : 'article-content',
            afterBlur : function(){
                this.sync();
            }
        });
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
        $(document).on("click","#submitBtn1",function(){
            //var index_query = layer.confirm('您确定提交保存吗？', {
            //    btn: ['确定','取消'] //按钮
            //}, function(){
            ajax_form1();
            //    layer.close(index_query);
            // }, function(){
            //});
            return false;
        });
        //提交-修改公司介绍
        $(document).on("click","#submitBtn2",function(){
            //var index_query = layer.confirm('您确定提交保存吗？', {
            //    btn: ['确定','取消'] //按钮
            //}, function(){
           ajax_form2();
            //    layer.close(index_query);
            // }, function(){
            //});
            return false;
        });

    });

    // 上传完后回调
    function uploadComplete(){
        // 判断是否上传图片
        var uploader = $('#myUploader').data('zui.uploader');
        var files = uploader.getFiles();
        var filesCount = files.length;

        var imgObj = $('#myUploader').closest('.resourceBlock').find(".upload_img")

        if( (!judge_list_checked(imgObj,3)) && filesCount <=0 ) {//没有选中的
            layer_alert('请选择要上传的图片！',3,0);
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
                    ajax_img_save();
                }
            },1000);
        }else{
            ajax_img_save();
        }
    }

    // 验证通过后，ajax保存
    function ajax_img_save(){
        // 验证通过
        SUBMIT_FORM = false;//标记为已经提交过
        var data = $("#addFormfile").serialize();

        console.log("{{ url('api/company/ajax_img_save') }}");
        console.log(data);
        var layer_index = layer.load();
        $.ajax({
            'type' : 'POST',
            'url' : '{{ url('api/company/ajax_img_save') }}',
            'data' : data,
            'dataType' : 'json',
            'success' : function(ret){
                console.log(ret);
                if(!ret.apistatus){//失败
                    SUBMIT_FORM = true;//标记为未提交过
                    //alert('失败');
                    err_alert(ret.errorMsg);
                }else{//成功
                    go("{{url('company/')}}");
                    // var supplier_id = ret.result['supplier_id'];
                    //if(SUPPLIER_ID_VAL <= 0 && judge_integerpositive(supplier_id)){
                    //    SUPPLIER_ID_VAL = supplier_id;
                    //    $('input[name="supplier_id"]').val(supplier_id);
                    //}
                    // save_success();
                }
                layer.close(layer_index)//手动关闭
            }
        });
        return false;
    }

    //ajax提交表单
    function ajax_form1(){
        if (!SUBMIT_FORM) return false;//false，则返回

        var company_name = $('input[name=company_name]').val();
        if(!judge_validate(4,'企业全称',company_name,true,'length',2,40)){
            return false;
        }

        var company_simple_name = $('input[name=company_simple_name]').val();
        if(!judge_validate(4,'企业简称',company_simple_name,false,'length',2,30)){
            return false;
        }

        var company_addr = $('input[name=company_addr]').val();
        if(!judge_validate(4,'公司地址',company_addr,false,'length',2,60)){
            return false;
        }

        var product_addr = $('input[name=product_addr]').val();
        if(!judge_validate(4,'生产地址',product_addr,false,'length',2,60)){
            return false;
        }

        var company_mainproduct = $('textarea[name=company_mainproduct]').val();
        if(!judge_validate(4,'主营项目',company_mainproduct,false,'length',2,1000)){
            return false;
        }

        var ccredit_code = $('input[name=ccredit_code]').val();
        if(!judge_validate(4,'统一社会信用代码',ccredit_code,false,'length',2,50)){
            return false;
        }


        var company_createtime = $('input[name=company_createtime]').val();
        if(!judge_validate(4,'成立时间',company_createtime,true,'date','','')){
            return false;
        }

        var reg_capital = $('input[name=reg_capital]').val();
        if(!judge_validate(4,'注册资金',reg_capital,false,'length',3,50)){
            return false;
        }

        var legal_name = $('input[name=legal_name]').val();
        if(!judge_validate(4,'法定代表人',legal_name,false,'length',3,50)){
            return false;
        }

        var contact_way = $('textarea[name=contact_way]').val();
        if(!judge_validate(4,'联系方式',contact_way,false,'length',3,250)){
            return false;
        }

        // 验证通过
        SUBMIT_FORM = false;//标记为已经提交过
        var data = $("#addForm1").serialize();
        console.log("{{ url('api/company/ajax_save') }}");
        console.log(data);
        var layer_index = layer.load();
        $.ajax({
            'type' : 'POST',
            'url' : '{{ url('api/company/ajax_save') }}',
            'data' : data,
            'dataType' : 'json',
            'success' : function(ret){
                console.log(ret);
                if(!ret.apistatus){//失败
                    SUBMIT_FORM = true;//标记为未提交过
                    //alert('失败');
                    err_alert(ret.errorMsg);
                }else{//成功
                    go("{{url('company/')}}");
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
    //ajax提交表单
    function ajax_form2(){
        if (!SUBMIT_FORM) return false;//false，则返回

        var company_intro = $('textarea[name=company_intro]').val();
//        if(!judge_validate(4,'公司简介',company_intro,false,'length',3,25000)){
//            return false;
//        }

        // 验证通过
        SUBMIT_FORM = false;//标记为已经提交过
        var data = $("#addForm2").serialize();
        console.log("{{ url('api/company/ajax_intro_save') }}");
        console.log(data);
        var layer_index = layer.load();
        $.ajax({
            'type' : 'POST',
            'url' : '{{ url('api/company/ajax_intro_save') }}',
            'data' : data,
            'dataType' : 'json',
            'success' : function(ret){
                console.log(ret);
                if(!ret.apistatus){//失败
                    SUBMIT_FORM = true;//标记为未提交过
                    //alert('失败');
                    err_alert(ret.errorMsg);
                }else{//成功
                    go("{{url('company/')}}");
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