<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>VAA Store</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="{{ asset('public/css/product.css') }}" rel='stylesheet' type='text/css' />
<script src="{{ asset('public/js/product.js') }}" defer></script> <!-- Sử dụng defer để trì hoãn thực thi cho đến khi tải xong HTML -->
<script src="{{ asset('public/js/search.js') }}" defer></script>
<script src="{{ asset('public/js/popup.js') }}" defer></script>
</head>
<body>
<div class="app">
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
      <form action="{{ route('search') }}" method="GET" id="search-form">
        <li class="search">
          <input placeholder="Tìm kiếm" type="text" name="query" id="search-input">
          <button type="submit" style="background: none; border: none; cursor: pointer;">
            <i class="fas fa-search"></i>
          </button>
        </li>
      </form>

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
<div class="row mt-4">
    <!-- Sidebar -->
    <div class="col-md-3 filter-sidebar">
      <h5>Lọc sản phẩm</h5>
      <button class="btn btn-outline-dark mb-2">Size</button>
      <button class="btn btn-outline-dark mb-2">Màu sắc</button>
      <button class="btn btn-outline-dark mb-2">Mức giá</button>
      <button class="btn btn-outline-dark mb-2">Mức chiết khấu</button>
      <button class="btn btn-outline-dark mb-2">Nâng cao</button>
      <button class="btn btn-dark">Lọc</button>
    </div>

    <!-- Product List -->
    <div class="col-md-9">
      <h2 class="mb-4"></h2>
      <div class="d-flex justify-content-end mb-3">
        <label for="sort" class="me-2">Sắp xếp theo</label>
        <select id="sort" class="form-select w-auto">
          <option value="default">Mặc định</option>
          <option value="price">Giá</option>
        </select>
      </div>
      <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($products as $product)
        <div class="col">
          <div class="product-card">
            <div class="label">Special Price</div>
              <a href="{{ route('products.detail', ['product_id' => $product->product_id]) }}" class="product-card-link">
                <img src="{{ asset('public/' . $product->product_img) }}" alt="{{ $product->product_name }}">
                <div class="product-name">{{ $product->product_name }}</div>
              </a>
              <div class="product-price">
                {{ number_format($product->product_price, 0, ',', '.') }}đ
                <span class="old-price">{{ number_format($product->product_old_price, 0, ',', '.') }}đ</span>
              </div>
              <div class="mt-2">
                <a href="{{ url('/favorites') }}">
                  <button class="btn btn-outline-secondary"><i class="far fa-heart"></i></button>
                </a>
                <a href="{{ url('/carts') }}">
                  <button class="btn btn-dark"><i class="fas fa-shopping-bag"></i></button>
                </a>                
              </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
</div>

<!-- Popup giỏ hàng -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content rounded-3 shadow-lg">
          <div class="modal-header bg-primary text-white">
              <h5 class="modal-title" id="cartModalLabel">Giỏ hàng của bạn</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body cart-popup-body">
              <p>Đang tải nội dung giỏ hàng...</p>
          </div>
          <div class="modal-footer">
              <div class="d-flex justify-content-between w-100">
                  <div>
                      <strong>Tổng số lượng: </strong><span id="total-quantity">0</span>
                  </div>
                  <div>
                      <strong>Tổng giá: </strong><span id="total-price">0₫</span>
                  </div>
              </div>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
              <a href="/checkout" class="btn btn-primary">Thanh toán</a>
          </div>
      </div>
  </div>
</div>
    
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="add-to-cart-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="1500">
    <div class="toast-header bg-success text-white">
      <i class="bi bi-check-circle me-2"></i> <!-- Thêm icon check-circle -->
      <strong class="me-auto">Thông báo</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      <span class="fw-bold">Sản phẩm đã được thêm vào giỏ hàng thành công!</span>
    </div>
  </div>
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