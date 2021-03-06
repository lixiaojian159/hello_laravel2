<!DOCTYPE html>
<html>
<head>
	<title>@yield('title','sample') - Laravel 入门教程</title>
	<link rel="stylesheet" type="text/css" href="/css/app.css">
</head>
<body>
	@include('layouts._header')
	@include('shared._messages')
	<div class="container">
        @yield('content')
    </div>
	@include('layouts._footer')
</body>
<script src="/js/app.js"></script>
</html>
