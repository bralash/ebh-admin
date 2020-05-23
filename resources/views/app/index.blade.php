<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>EBH Admin</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" rel="stylesheet">
	<meta name="csrf-token" content="{{csrf_token()}}" />
	<link rel="icon" href="{{url('img/favicon.png')}}"/>
</head>

<body>
	<div id="app">Loading...</div>
	<div id="aul">
		<input class="resource-url" type="hidden" value="{{url('api/v1')}}"/>
		<input class="app-url" type="hidden" value="{{url('/')}}"/>
	</div>
	{{-- <script src="{{url('js/app.bundle.js')}}"></script> --}}
	<script src="http://localhost:8088/js/app.bundle.js"></script>
</body>

</html>
