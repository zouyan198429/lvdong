<!doctype html>
<html>

<head>
	@include('head')
</head>

<body style="text-align: center;" >
<div id="output" style="padding: 10px; margin:50px auto;"></div>
</body>
</html>
@include('pagefoot')
<script src="{{asset('js/jquery.qrcode.min.js')}}"></script>
<script>
$(function(){
	$('#output').qrcode('{{ $url }}');
});

</script>