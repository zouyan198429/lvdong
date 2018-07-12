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
    var SUBMIT_FORM = true;//防止多次点击提交
    $(function(){
        // 富文本
        KindEditor.create('textarea.kindeditor', {
            basePath: '/dist/lib/kindeditor/',
            allowFileManager : true,
            bodyClass : 'article-content',
            afterBlur : function(){
                this.sync();
            }
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

        var new_title = $('input[name=new_title]').val();
        if(!judge_validate(4,'标题',new_title,true,'length',2,40)){
            return false;
        }

        var new_content = $('textarea[name=new_content]').val();
//        if(!judge_validate(4,'内容',new_content,false,'length',3,25000)){
//            return false;
//        }

        var volume = $('input[name=volume]').val();
        if(!judge_validate(4,'阅读量',volume,false,'digit','','')){
            return false;
        }


        var new_source = $('input[name=new_source]').val();
        if(!judge_validate(4,'新闻来源',new_source,false,'length',2,20)){
            return false;
        }

        // 验证通过
        SUBMIT_FORM = false;//标记为已经提交过
        var data = $("#addForm").serialize();
        console.log("{{ url('api/news/ajax_save') }}");
        console.log(data);
        var layer_index = layer.load();
        $.ajax({
            'type' : 'POST',
            'url' : '{{ url('api/news/ajax_save') }}',
            'data' : data,
            'dataType' : 'json',
            'success' : function(ret){
                console.log(ret);
                if(!ret.apistatus){//失败
                    SUBMIT_FORM = true;//标记为未提交过
                    //alert('失败');
                    err_alert(ret.errorMsg);
                }else{//成功
                    go("{{url('news/')}}");
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