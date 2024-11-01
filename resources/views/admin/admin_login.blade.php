
<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<head>
<title>Đăng nhập</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link rel="stylesheet" href="{{ asset('public/css/bootstrap.min.css') }}" >
<link href="{{ asset('public/css/style2.css') }}" rel='stylesheet' type='text/css' />
<link href="{{ asset('public/css/style-responsive.css') }}" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{ asset('public/css/font-awesome.css') }}" rel="stylesheet"> 
<link rel="stylesheet" href="{{ asset('public/css/morris.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('public/css/monthly.css') }}">
<script src="{{ asset('public/js/jquery2.0.3.min.js') }}"></script>
<script src="{{ asset('public/js/raphael-min.js') }}"></script>
<script src="{{ asset('public/js/morris.js') }}"></script>
</head>
<body>
	<div class="wrapper">
		<img src="{{ asset('public/images/logo.png') }}" alt="Logo" class="center-logo">
		<form action="{{ route('admin.login.post') }}" method="post" class="login-form">
			@csrf <!-- Token bảo mật bắt buộc trong Laravel -->
			<input type="username" class="ggg" name="Username" placeholder="Tài khoản" required="">
			<input type="password" class="ggg" name="Password" placeholder="Mật khẩu" required="">
			<div class="clearfix"></div>
			<input type="submit" value="Đăng nhập" name="login">
		</form>
	
		@if($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
	</div>
	
<script src="{{ asset('public/js/bootstrap.js') }}"></script>
<script src="{{ asset('public/js/jquery.dcjqaccordion.2.7.js') }}"></script>
<script src="{{ asset('public/js/scripts.js') }}"></script>
<script src="{{ asset('public/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('public/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('public/js/jquery.scrollTo.js') }}"></script>
</body>
</html>
