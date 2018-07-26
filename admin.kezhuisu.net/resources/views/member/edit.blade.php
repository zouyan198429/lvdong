@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
<script src="{{asset('dist/lib/jquery/jquery.js')}}"></script>
<link href="{{asset('dist/lib/datetimepicker/datetimepicker.min.css')}}" rel="stylesheet">
<script src="{{asset('dist/lib/datetimepicker/datetimepicker.min.js')}}"></script>
@endpush

@section('content')
    <div class="tpl-content-page-title">
        编辑会员
    </div>

    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 编辑会员
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-8">
                    <form class="am-form am-form-horizontal" method="post"  id="addForm">
                        <input type="hidden" name="id" value="{{ $id or 0 }}"/>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">公司类型</label>
                            <div class="am-u-sm-9">
                                <select  name="company_type_id"  class="form-control chosen-select">
                                    <option value="">公司类型</option>
                                    @foreach ($typesList as $typeinfo)
                                        <option value="{{ $typeinfo['id'] }}" @if($typeinfo['id'] == $company_type_id) selected @endif>{{ $typeinfo['type_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">公司等级</label>
                            <div class="am-u-sm-9">
                                <select  name="company_rank_id"  class="form-control chosen-select">
                                    <option value="">公司等级</option>
                                    @foreach ($ranksList as $rankinfo)
                                        <option value="{{ $rankinfo['id'] }}" @if($rankinfo['id'] == $company_rank_id) selected @endif>{{ $rankinfo['rank_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">公司名称</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="company_name" value="{{ $company_name or '' }}" placeholder="公司名称">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">公司简称</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="company_simple_name" value="{{ $company_simple_name or '' }}" placeholder="公司简称">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">统一社会信用代码</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="ccredit_code" value="{{ $ccredit_code or '' }}" placeholder="统一社会信用代码">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">注册资金</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="reg_capital" value="{{ $reg_capital or '' }}" placeholder="注册资金">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">法定代表人</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="legal_name" value="{{ $legal_name or '' }}" placeholder="法定代表人">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">联系人</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="company_linkman" value="{{ $company_linkman or '' }}" placeholder="联系人">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">电话</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="company_tel" value="{{ $company_tel or '' }}" placeholder="电话">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">手机</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="company_mobile" onkeyup="isnum(this) " onafterpaste="isnum(this)" value="{{ $company_mobile or '' }}" placeholder="手机">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">微信号</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="company_wx" value="{{ $company_wx or '' }}" placeholder="微信号">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">传真</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="company_fax" value="{{ $company_fax or '' }}" placeholder="传真">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">邮箱</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="company_email" value="{{ $company_email or '' }}" placeholder="邮箱">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">所在地区</label>
                            <div class="am-u-sm-9">
                                @include('public.area_select.area_select', ['province_id' => 'province_id','city_id' => 'city_id','area_id' => 'area_id'])
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">所在地址</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="company_addr" value="{{ $company_addr or '' }}" placeholder="所在地址">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">生产地址</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="product_addr" value="{{ $product_addr or '' }}" placeholder="生产地址">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">主营产品</label>
                            <div class="am-u-sm-9">
                                <textarea type="text" name="company_mainproduct" placeholder="主营产品">{{ $company_mainproduct or '' }}</textarea>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">成立时间</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="company_createtime"  class="form-control form-date" value="{{ $company_createtime or '' }}" placeholder="成立时间">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">联系方式</label>
                            <div class="am-u-sm-9">
                                <textarea type="text" name="contact_way"  placeholder="联系方式">{{ $contact_way or '' }}</textarea>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">vip起止</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="company_vipbegin" style="width:150px;" class="form-control form-date" value="{{ $company_vipbegin or '' }}" placeholder="vip起">
                                --
                                <input type="text" name="company_vipend" style="width:150px;"  class="form-control form-date" value="{{ $company_vipend or '' }}" placeholder="vip止">
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

</script>
@endpush
@push('footlast')
<script type="text/javascript">
    var SUBMIT_FORM = true;//防止多次点击提交
    $(function(){
        reset_area_sel(0,1,'');//初始化省

        //当前省市区县
        @if (!empty($province_id))
            var area_json = {"province":{"id":"province_id","value":"{{ $province_id or '' }}"},"city":{"id":"city_id","value":"{{ $city_id or '' }}"},"area":{"id":"area_id","value":"{{ $area_id or '' }}"}}
            init_area_sel(area_json,1);
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

    });

    //ajax提交表单
    function ajax_form(){
        if (!SUBMIT_FORM) return false;//false，则返回

        // 验证信息
        var id = $('input[name=id]').val();
        if(!judge_validate(4,'记录id',id,true,'digit','','')){
            return false;
        }

        var company_type_id = $('select[name=company_type_id]').val();
        if(!judge_validate(4,'公司类型',company_type_id,true,'digit','','')){
            return false;
        }

        var company_rank_id = $('select[name=company_rank_id]').val();
        if(!judge_validate(4,'公司等级',company_rank_id,true,'digit','','')){
            return false;
        }

        var company_name = $('input[name=company_name]').val();
        if(!judge_validate(4,'公司名称',company_name,true,'length',2,40)){
            return false;
        }

        var company_simple_name = $('input[name=company_simple_name]').val();
        if(!judge_validate(4,'公司简称',company_simple_name,false,'length',2,40)){
            return false;
        }

        var ccredit_code = $('input[name=ccredit_code]').val();
        if(!judge_validate(4,'统一社会信用代码',ccredit_code,false,'length',2,40)){
            return false;
        }

        var reg_capital = $('input[name=reg_capital]').val();
        if(!judge_validate(4,'注册资金',reg_capital,false,'length',2,40)){
            return false;
        }

        var legal_name = $('input[name=legal_name]').val();
        if(!judge_validate(4,'法定代表人',legal_name,false,'length',2,40)){
            return false;
        }

        var company_linkman = $('input[name=company_linkman]').val();
        if(!judge_validate(4,'联系人',company_linkman,false,'length',2,40)){
            return false;
        }

        var company_tel = $('input[name=company_tel]').val();
        if(!judge_validate(4,'电话',company_tel,false,'length',2,40)){
            return false;
        }

        var company_mobile = $('input[name=company_mobile]').val();
        if(!judge_validate(4,'手机',company_mobile,false,'mobile','','')){
            return false;
        }

        var company_wx = $('input[name=company_wx]').val();
        if(!judge_validate(4,'微信号',company_wx,false,'length',2,40)){
            return false;
        }

        var company_fax = $('input[name=company_fax]').val();
        if(!judge_validate(4,'传真',company_fax,false,'length',2,40)){
            return false;
        }

        var company_email = $('input[name=company_email]').val();
        if(!judge_validate(4,'邮箱',company_email,false,'email','','')){
            return false;
        }

        var company_addr = $('input[name=company_addr]').val();
        if(!judge_validate(4,'所在地址',company_addr,false,'length',2,40)){
            return false;
        }

        var product_addr = $('input[name=product_addr]').val();
        if(!judge_validate(4,'生产地址',product_addr,false,'length',2,40)){
            return false;
        }

        var company_mainproduct = $('textarea[name=company_mainproduct]').val();
        if(!judge_validate(4,'主营产品',company_mainproduct,false,'length',2,40)){
            return false;
        }

        var company_createtime = $('input[name=company_createtime]').val();
        if(!judge_validate(4,'成立时间',company_createtime,false,'date','','')){
            return false;
        }

        var contact_way = $('textarea[name=contact_way]').val();
        if(!judge_validate(4,'联系方式',contact_way,false,'length',2,400)){
            return false;
        }

        var company_vipbegin = $('input[name=company_vipbegin]').val();
        if(!judge_validate(4,'vip起',company_vipbegin,false,'date','','')){
            return false;
        }

        var company_vipend = $('input[name=company_vipend]').val();
        if(!judge_validate(4,'vip止',company_vipend,false,'date','','')){
            return false;
        }

        if(company_vipbegin != '' ){
            if(!judge_validate(4,'vip止必须',company_vipend,true,'data_size',company_vipbegin,5)){
                return false;
            }
        }

        // 验证通过
        SUBMIT_FORM = false;//标记为已经提交过
        var data = $("#addForm").serialize();
        console.log("{{ url('api/member/ajax_save') }}");
        console.log(data);
        var layer_index = layer.load();
        $.ajax({
            'type' : 'POST',
            'url' : '{{ url('api/member/ajax_save') }}',
            'data' : data,
            'dataType' : 'json',
            'success' : function(ret){
                console.log(ret);
                if(!ret.apistatus){//失败
                    SUBMIT_FORM = true;//标记为未提交过
                    //alert('失败');
                    err_alert(ret.errorMsg);
                }else{//成功
                    go("{{url('member/')}}");
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

</script>
@endpush