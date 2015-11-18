<!DOCTYPE html>
<html>
<head>
 	<meta name="csrf-token" content="{{ csrf_token() }}" />  
 	@include('layout.assets.head')
    @include('layout.assets.css')

</head>
<body>
	@include('layout.header')	
	@include('layout.sidebar')	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
				<li class="active">@yield('title')</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">@yield('title')</h1>
			</div>
		</div><!--/.row-->
		
		@yield('content')

	@include('layout.footer')	
	@include('layout.assets.js')
</body>

</html>
