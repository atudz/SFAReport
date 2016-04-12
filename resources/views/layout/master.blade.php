<!DOCTYPE html>
<html data-ng-app="app">
<head>
 	@include('layout.assets.head')
    @include('layout.assets.css')
</head>
<body>
	@include('layout.header')	
	@include('layout.sidebar')	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div data-ng-view>
			<!-- @yield('content') -->			
		</div>		
		@include('layout.footer')
	</div><!--/.row-->	
	@include('layout.assets.js')
</body>

</html>
