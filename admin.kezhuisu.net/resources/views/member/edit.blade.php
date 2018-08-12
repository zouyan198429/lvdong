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
    var has_province = false;
     @if (!empty($province_id))
         has_province = true;
    @endif
    const AREA_JSON = {"province":{"id":"province_id","value":"{{ $province_id or '' }}"},"city":{"id":"city_id","value":"{{ $city_id or '' }}"},"area":{"id":"area_id","value":"{{ $area_id or '' }}"}};
    const SAVE_URL = "{{ url('api/member/ajax_save') }}";
    const LIST_URL = "{{url('member/')}}";
</script>
<script src="{{ asset('/js/lanmu/member_save.js') }}"  type="text/javascript"></script>
@endpush