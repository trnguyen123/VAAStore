<!DOCTYPE html>
<head>
<title>Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{ asset('public/css/bootstrap.min.css') }}" >
<link href="{{ asset('public/css/style.css') }}" rel='stylesheet' type='text/css' />
<link href="{{ asset('public/css/style-responsive.css') }}" rel="stylesheet"/>
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{ asset('public/css/font-awesome.css') }}" rel="stylesheet"> 
<link rel="stylesheet" href="{{ asset('public/css/morris.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('public/css/monthly.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="{{ asset('public/js/jquery2.0.3.min.js') }}"></script>
<script src="{{ asset('public/js/raphael-min.js') }}"></script>
<script src="{{ asset('public/js/morris.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<section id="container">
	<aside>
		<div id="sidebar" class="nav-collapse">
			<!-- sidebar menu start-->
			<div class="brand">
				<a class="logo" href="{{ url('/admin/') }}">
					<img src="{{ asset('public/images/logo.png') }}" alt="Logo" class="logo-img">
				</a>
			</div>
			<div class="leftside-navigation">
				<ul class="sidebar-menu" id="nav-accordion">
					<li>
						<a class="" href="{{ url('/admin/') }}">
							<i class="fa fa-dashboard"></i>
							<span>Dashboard</span>
						</a>
					</li>
					<li class="sub-menu">
						<a class="">
							<i class="fa fa-book"></i>
							<span>Sản phẩm </span>
						</a>
						<ul class="sub">
							<li><a href="{{ url('/admin/add-product') }}">Thêm sản phẩm</a></li>
						</ul>
						<ul class="sub">
							<li><a href="{{ url('/admin/all-product') }}">Xem sản phẩm</a></li>
						</ul>
					</li>
					<li class="sub-menu">
						<a class="">
							<i class="fa-regular fa-user"></i>
							<span>Thành viên </span>
						</a>
						<ul class="sub">
							<li><a href={{ route('admin.all_customer') }}>Xem thành viên</a></li>
						</ul>
					</li>
					<li class="sub-menu">
						<a class="">
							<i class="fa-solid fa-tag"></i>
							<span>Đơn hàng </span>
						</a>
						<ul class="sub">
							<li><a href="{{ url('/admin/orders') }}">Xem đơn hàng</a></li>
						</ul>
					</li>
					<li class="sub-menu">
						<a class="">
							<i class="fa-solid fa-tag"></i>
							<span>Thanh toán </span>
						</a>
						<ul class="sub">
							<li><a href="{{ url('/admin/payments') }}">Quản lí thanh toán</a></li>
						</ul>
					</li>
					<li class="sub-menu">
						<a class="" href="{{ url('/login/admin') }}">
							<i class="fa fa-key"></i>
							<span>Đăng xuất</span>
						</a>
					</li>				
				</ul>    
			</div>
		</div>
	</aside>
	<section id="main-content">
		<div class="wrapper">
			<form method="GET" action="{{ route('admin.dashboard') }}">
				<label for="selected_date">Chọn ngày:</label>
				<input type="date" id="selected_date" name="selected_date" value="{{ request('selected_date') }}">
				<button type="submit">Lọc</button>
			</form>
			<h1 class="text-center text-primary">Danh thu của cửa hàng</h1>
			<canvas id="revenueChart"></canvas>	
		</div>
	</section>
</section>
<script src="{{ asset('public/js/bootstrap.js') }}"></script>
<script src="{{ asset('public/js/scripts.js') }}"></script>
<!-- morris JavaScript -->	
<script>
	// Prepare data for the chart 
	const labels = @json($revenueData->pluck('date')); // Lấy dữ liệu ngày
	const data = @json($revenueData->pluck('revenue')); // Lấy doanh thu
	// Configure and render the chart 
	const ctx = document.getElementById('revenueChart').getContext('2d'); 
	const revenueChart = new Chart(ctx, { 
		type: 'bar', 
		data: { 
			labels: labels, 
			datasets: [{ 
				label: 'Doanh thu (VND)', 
				data: data, 
				backgroundColor: 'rgba(75, 192, 192, 0.2)', 
				borderColor: 'rgba(75, 192, 192, 1)',
				borderWidth: 1 
			}] 
		}, 
		options: { 
			scales: { 
				y: { 
					beginAtZero: true 
				} 
			} 
		} 
	});
</script>
</body>
</html>
