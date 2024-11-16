<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VAA Store</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="{{ asset('public/css/home.css') }}" rel='stylesheet' type='text/css' />
  <script src="{{ asset('public/js/home.js') }}" defer></script>

</head>

<body>
  <div id="app">
    <header>  
      <div class="logo">
          <a href="{{ url('/home') }}">        
              <img src="{{ asset('public/images/logo.png') }}" alt="Logo" class="logo">
          </a>
      </div>
      <div class="menu">
        <ul> 
            @foreach ($categories as $category)
                <li><a href="{{ route('products.category', ['category_id' => $category->category_id]) }}">{{ $category->category_name }}</a></li>
            @endforeach
            <li><a href="{{ route('allProduct') }}">ALL PRODUCTS</a></li>
        </ul>
    </div>
    
      <div class="others">
        <li class="search">
            <input placeholder="Tìm kiếm" type="text" id="search-input">
            <i class="fas fa-search"></i>
        </li>
    
        @if(session('full_name'))
        <li class="dropdown">
            <p class="dropdown-toggle">{{ session('full_name') }}</p>
            <div class="dropdown-content">
              <a href="{{ route('profile') }}">Thông tin cá nhân</a>
              <a href="">Đổi mật khẩu</a>
              <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Đăng xuất</button>
                </form>
            </div>
        </li>
        @else
            <li>
                <a class="fa fa-user" href="{{ url('/login') }}"></a>
            </li>
        @endif

    
        <li>
            <a class="fa fa-shopping-bag" href="{{ url('/carts') }}"></a>
        </li>
        <li>
            <a class="fa fa-heart" href="{{ url('/favorites') }}"></a> 
        </li>
    </div>
    </header>

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="public/images/slide1.jpg" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            
          </div>
        </div>
        <div class="carousel-item">
          <img src="public/images/slide2.jpg" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
          </div>
        </div>
        <div class="carousel-item">
          <img src="public/images/slide3.jpg" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    @foreach ($categories as $category)
    <div class="container mt-5">
      <h2 class="text-center">{{ $category->category_name }}</h2>
      <div class="product-slider">
        <div class="product-wrapper">
          <div class="row">
            @foreach ($category->products as $product)
              <div class="col-md-3">
                <div class="product-card">
                  <span class="new-label">NEW</span>
                  <a href="{{ route('products.detail', ['product_id' => $product->product_id]) }}" class="product-card-link">
                    <img src="{{ asset('public/' . $product->product_img) }}" class="img-fluid rounded-start" alt="...">
                    <p class="product-name mt-2">{{ $product->product_name }}</p>
                  </a>
                  <p class="product-price">{{ number_format($product->product_price, 0, ',', '.') }}₫</p>
                  <div class="mt-2">
                    <button class="btn btn-outline-secondary"><i class="far fa-heart"></i></button>
                    <button class="btn btn-dark"><i class="fas fa-shopping-bag"></i></button>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
        <button class="prev btn btn-secondary">
          <i class="fas fa-chevron-left"></i>
        </button>
        <button class="next btn btn-secondary">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
      <div class="text-center">
        <a href="{{ route('products.category', ['category_id' => $category->category_id]) }}" class="btn btn-dark mt-3">Xem tất cả</a>
      </div>
    </div><br>
    @endforeach

    
      

  </div>

  
</body>

<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h3>Liên hệ</h3>
        <p>Hotline: 1900 XXX XXX</p>
        <p>Email: xxxxxx@vaa.edu.vn</p>
        <p>Địa chỉ: 104 Nguyễn Văn Trỗi, Phường 8, Quận Phú Nhuận, TPHCM </p>
      </div>
      <div class="col-md-4">
        <h3>Về chúng tôi</h3>
        <p>Giới thiệu</p>
        <p>Tuyển dụng</p>
        <p>Blog</p>
      </div>
      <div class="col-md-4">
        <h3>Hỗ trợ</h3>
        <p>Hướng dẫn mua hàng</p>
        <p>Chính sách đổi trả</p>
        <p>Câu hỏi thường gặp</p>
      </div>
    </div>
  </div>
</footer>
</html>
