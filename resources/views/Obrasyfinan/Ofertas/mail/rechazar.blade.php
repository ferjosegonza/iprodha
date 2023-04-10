<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<style type="text/css">
		body{
			font-family: 'Verdana';
			font-size: 15px;
		}
		h1{
			font-size: 20px;
			font-weight: bold;
			text-decoration: underline;
		}
	</style>
</head>
<body>
	<h1>Saludos, {{$name}}.</h1>
	<p>La oferta de obra "{{$oferta}}" fue rechazada debido a:</p>
	<p>{{$comentario}}</p>
</body>
</html>