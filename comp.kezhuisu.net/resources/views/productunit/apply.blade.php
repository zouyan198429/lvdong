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
                                    <select class="form-control">
                                        <option value="">请选择类别</option>
                                        <option value="apple">种植</option>
                                        <option value="banana">养殖</option>
                                        <option value="orange">林业</option>
                                        <option value="orange">渔业</option>
                                        <option value="orange">其他</option>
                                    </select>
                                </div>
                                <div class="col-xs-3">
                                    <select class="form-control">
                                        <option value="">请选择产品</option>
                                        <option value="apple">苹果</option>
                                        <option value="banana">香蕉</option>
                                        <option value="orange">桔子</option>
                                    </select>
                                </div>
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

    });

    //ajax提交表单
    function ajax_form(){
        if (!SUBMIT_FORM) return false;//false，则返回

        // 验证信息
        var id = $('input[name=id]').val();
        if(!judge_validate(4,'生产单元id',id,true,'digit','','')){
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