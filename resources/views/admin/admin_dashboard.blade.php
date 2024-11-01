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
</head>
<body>
<section id="container">
<header class="header fixed-top clearfix">
<div class="brand">
	<a class="logo" href="{{ url('/admin/') }}">
		<img src="{{ asset('public/images/logo.png') }}" alt="Logo" style="width: 70px; height: 70px; margin-top :-15px ; margin-left: 65px;" class="logo">
    </a>
</div>
</header>
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
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
						<li><a href="{{ url('/admin/all-customer') }}">Xem thành viên</a></li>
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
		<h2>Chào mừng bạn đến với trang Admin </h2>
	</div>
 <!-- footer -->
		  <div class="footer">
			<div class="wthree-copyright">
			  <p>© 2024 VAA Store. All rights reserved | Design by Group 7</a></p>
			</div>
		  </div>
  <!-- / footer -->
</section>
<!--main content end-->
</section>
<script src="{{ asset('public/js/bootstrap.js') }}"></script>
<script src="{{ asset('public/js/jquery.dcjqaccordion.2.7.js') }}"></script>
<script src="{{ asset('public/js/scripts.js') }}"></script>
<script src="{{ asset('public/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('public/js/jquery.nicescroll.js') }}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="{{ asset('public/js/jquery.scrollTo.js') }}"></script>
<!-- morris JavaScript -->	
<script>
	$(document).ready(function() {
		//BOX BUTTON SHOW AND CLOSE
	   jQuery('.small-graph-box').hover(function() {
		  jQuery(this).find('.box-button').fadeIn('fast');
	   }, function() {
		  jQuery(this).find('.box-button').fadeOut('fast');
	   });
	   jQuery('.small-graph-box .box-close').click(function() {
		  jQuery(this).closest('.small-graph-box').fadeOut(200);
		  return false;
	   });
	   
	    //CHARTS
	    function gd(year, day, month) {
			return new Date(year, month - 1, day).getTime();
		}
		
		graphArea2 = Morris.Area({
			element: 'hero-area',
			padding: 10,
        behaveLikeLine: true,
        gridEnabled: false,
        gridLineColor: '#dddddd',
        axes: true,
        resize: true,
        smooth:true,
        pointSize: 0,
        lineWidth: 0,
        fillOpacity:0.85,
			data: [
				{period: '2015 Q1', iphone: 2668, ipad: null, itouch: 2649},
				{period: '2015 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
				{period: '2015 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
				{period: '2015 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
				{period: '2016 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
				{period: '2016 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
				{period: '2016 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
				{period: '2016 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
				{period: '2017 Q1', iphone: 10697, ipad: 4470, itouch: 2038},
			
			],
			lineColors:['#eb6f6f','#926383','#eb6f6f'],
			xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
			pointSize: 2,
			hideHover: 'auto',
			resize: true
		});
		
	   
	});
	</script>
</body>
</html>
