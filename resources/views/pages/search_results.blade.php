<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VAA Store</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="{{ asset('public/css/product.css') }}" rel='stylesheet' type='text/css' />
  <link href="{{ asset('public/css/popup.css') }}" rel='stylesheet' type='text/css' />
  <script src="{{ asset('public/js/search.js') }}" defer></script>
  <script src="{{ asset('public/js/popup.js') }}" ></script>
  <script>
    const csrfToken = "{{ csrf_token() }}";
    const routes = {
        addToCart: "{{ route('addToCart') }}",
        removeFromCart: "{{ route('removeFromCart') }}",
        updateCartQuantity: "{{ route('updateCartQuantity') }}"
    };
</script>
</head>
<body>
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
          <a class="fa fa-shopping-bag" href="#" id="cart-icon">
              <span id="cart-count" class="badge badge-danger">{{ session('cart') ? count(session('cart')) : 0 }}</span>
          </a>
      </li>
      
      
        <li>
            <a class="fa fa-heart" href="{{ url('/favorites') }}"></a> 
        </li>
    </div>
    </header><br>

<div class="container">
    <h2>Kết quả tìm kiếm cho: "{{ $query }}"</h2>

    <!-- Biểu mẫu tìm kiếm -->
    <form action="{{ route('search') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Nhập từ khóa..." value="{{ $query }}">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
        </div>
    </form>

    <div class="row">
        @if($products->isEmpty())
            <p>Không tìm thấy sản phẩm nào.</p>
        @else
            @foreach ($products as $product)
            <div class="col-md-3">
                <div class="product-card">
                  <a href="{{ route('products.detail', ['product_id' => $product->product_id]) }}" class="product-card-link">
                    <img src="{{ asset('public/' . $product->product_img) }}" class="img-fluid rounded-start" alt="...">
                    <p class="product-name mt-2">{{ $product->product_name }}</p>
                  </a>
                  <p class="product-price">{{ number_format($product->product_price, 0, ',', '.') }}₫</p>
                  <div class="mt-2">
                  <button class="btn btn-outline-danger favorite-btn" data-product-id="{{ $product->product_id }}">
                    <i class="far fa-heart"></i> 
                  </button>
                  <button class="btn btn-dark add-to-cart-btn" data-product-id="{{ $product->product_id }}">
                      <i class="fas fa-shopping-bag"></i>
                  </button>                  
                  </div>
                </div>
              </div>
            @endforeach
        @endif
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
        <nav>
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($products->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="fas fa-angle-left"></i> <!-- Icon for "Previous" -->
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">
                            <i class="fas fa-angle-left"></i> <!-- Icon for "Previous" -->
                        </a>
                    </li>
                @endif

                {{-- Page Number Links --}}
                @foreach ($products->links()->elements[0] as $page => $url)
                    @if ($page == $products->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span> <!-- Active Page -->
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a> <!-- Other Pages -->
                        </li>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($products->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">
                            <i class="fas fa-angle-right"></i> <!-- Icon for "Next" -->
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="fas fa-angle-right"></i> <!-- Icon for "Next" -->
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
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