<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="cache-control" content="private, max-age=0, no-cache">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    @include('layout.assets.head')
    @include('layout.assets.css')
</head>
<body>
	<!--[if lt IE 9]>
        <div class="lt-ie9-bg">
            <p class="browsehappy">You are using an <strong>outdated</strong> browser.</p>
            <p>Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        </div>
    <![endif]-->

    @yield('content')

    @include('layout.assets.js')
</body>

</html>
