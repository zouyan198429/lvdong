<!doctype html>
<html>

<head>
	@include('head')
</head>

<body >
<div id="output"></div>
</body>
</html>
@include('pagefoot')
<script src="{{asset('js/jquery.qrcode.min.js')}}"></script>
<script>
$(function(){
	$('#output').qrcode('{{ $url }}');
});

</script>