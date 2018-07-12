@extends('layouts.app')

@push('headscripts')
{{--  本页单独使用 --}}
<script src="{{asset('js/jquery.js')}}"></script>
<!-- 弹出层-->
<script src="{{ asset('js/layer/layer.js') }}"></script>
<style type="text/css">
	.commentScore {
		padding-left: 0;
		overflow: hidden;
		margin-bottom: 1.25rem;
	}
	.commentScore li {
		float: left;
		list-style: none;
		width: 27px;
		height: 27px;
		background: url({{ asset('img/star.gif') }})
	}
	.commentScore li a {
		display: block;
		width: 100%;
		padding-top: 27px;
		overflow: hidden;
	}
	.commentScore li.light {
		background-position: 0 -29px;
	}
</style>
@endpush

@section('content')
	@include('menu')

	<form method="post"  id="addForm" action="{{url('comment/' . $pro_unit_id . '/save')}}">
		@csrf
		<input type="hidden" name="company_id" value="{{ $company_id }}"/>

		<div class="box cls">
		<div class="hd"><h3>反馈</h3></div>
		<div class="bd">
			<div class="feed-contain">
				<textarea name="comment_content" style="height:8rem; margin-bottom:1rem;"  placeholder="留言内容，不超过250字"></textarea>
				{{--
				<ul class="commentScore">
					<li class="light"><a href="javascript:;">1</a></li>
					<li><a href="javascript:;">2</a></li>
					<li><a href="javascript:;">3</a></li>
					<li><a href="javascript:;">4</a></li>
					<li><a href="javascript:;">5</a></li>
				</ul>
				--}}
				<div class="c"></div>
				<input type="text" name="comment_mobile" id="tellnum" placeholder="手机号">
				{{--
				<button  type=""  class="ui-btn ui-mini" id="sendyzm" >发送验证码</button>
				<input type="text" name="ee" id="codeyz" placeholder="验证码">
				--}}

			</div>

			<input type="submit"  class="ui-btn ui-mini" id="tijiao"  value="提交"  />
		</div>
	</div>
	</form>

	<div class="box cls">
		<div class="hd"><h3>用户反馈</h3></div>
		<div class="bd">
			<ul class="feedlist">
				@foreach ($pro_comments as $pro_comment)
				<li>
					<h4>{{ $pro_comment['comment_mobile'] }}<span>{{ date('m-d',strtotime($pro_comment['created_at'])) }}</span></h4>
					<div class="fcon">
						{!! $pro_comment['comment_content'] !!}
					</div>
				</li>
				@endforeach
			</ul>
		</div>
	</div>

@endsection

@push('footscripts')
<script>
	var SUBMIT_FORM = true;//防止多次点击提交
	$(function(){
		$(document).on("click","#tijiao",function(){
			SUBMIT_FORM = false;//标记为已经提交过
			var layer_index = layer.load();
			var comment_mobile = $('input[name=comment_mobile]').val();
			var comment_content = $('textarea[name=comment_content]').val();
			if(comment_content == ''){
				layer.msg('请填写留言内容!');
				SUBMIT_FORM = true;
				layer.close(layer_index);//手动关闭
				return false;

			}
			var str_len = comment_content.length;
			if( str_len > 250){
				layer.msg('留言内容最多250个字符!');
				SUBMIT_FORM = true;
				layer.close(layer_index);//手动关闭
				return false;
			}

			var reg2 = /^1[0-9]{10}$/;
			if(!judge_reg(comment_mobile,reg2)){
				layer.msg('手机号格式不正确!');
				SUBMIT_FORM = true;
				layer.close(layer_index);//手动关闭
				return false;
			}
			layer.close(layer_index);//手动关闭
			// 验证通过
			SUBMIT_FORM = false;//标记为已经提交过
			var data = $("#addForm").serialize();
			console.log("{{url('comment/' . $pro_unit_id . '/save')}}");
			console.log(data);
			var layer_index = layer.load();
			$.ajax({
				'type' : 'POST',
				'url' : '{{url('comment/' . $pro_unit_id . '/save')}}',
				'data' : data,
				'dataType' : 'json',
				'success' : function(ret){
					console.log(ret);
					if(!ret.apistatus){//失败
						SUBMIT_FORM = true;//标记为未提交过
						//alert('失败');
						layer.alert(ret.errorMsg, {icon: 5});
						// err_alert(ret.errorMsg);
					}else{//成功
						layer.msg('提交成功!', function(){
							location.reload();
						});
						// layer.alert('提交成功!', {icon: 6});
						{{--go("{{url('inputcls/')}}");--}}
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
			return true;
		})
	});
	//判断正则表达式
	//value需要判断的值
	//reg正则表达式
	function judge_reg(value,reg2){
		if(reg2.test(value)){
			return true;
		}else{
			return false;
		}
	}

	var num=finalnum = tempnum= 0;
	var lis = document.getElementsByTagName("li");
	//num:传入点亮星星的个数
	//finalnum:最终点亮星星的个数
	//tempnum:一个中间值
	function fnShow(num) {
		finalnum= num || tempnum;//如果传入的num为0，则finalnum取tempnum的值
		for (var i = 0; i < lis.length; i++) {
			lis[i].className = i < finalnum? "light" : "";//点亮星星就是加class为light的样式
		}
	}
	for (var i = 1; i <= lis.length; i++) {
		lis[i - 1].index = i;
		lis[i - 1].onmouseover = function() { //鼠标经过点亮星星。
			fnShow(this.index);//传入的值为正，就是finalnum
		}
		lis[i - 1].onmouseout = function() { //鼠标离开时星星变暗
			fnShow(0);//传入值为0，finalnum为tempnum,初始为0
		}
		lis[i - 1].onclick = function() { //鼠标点击,同时会调用onmouseout,改变tempnum值点亮星星
			tempnum= this.index;
		}
	}
</script>
@endpush