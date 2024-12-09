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
  <script src="{{ asset('public/js/search.js') }}" defer></script>
  <script src="{{ asset('public/js/popup.js') }}" defer></script>
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
    
        
      <li class="dropdown" id="user-dropdown" style="display: none;">
        <p class="dropdown-toggle" id="user-full-name"></p>
        <div class="dropdown-content">
          <a id="profile-link" href="#">Thông tin cá nhân</a>
            <form action="{{ route('logout') }}" method="POST" onsubmit="clearLocalStorage()">
              @csrf
              <button type="submit">Đăng xuất</button>
            </form>
        </div>
      </li>
      <li id="login-link" style="display: none;">
          <a class="fa fa-user" href="{{ url('/login') }}"></a>
      </li>   
      <li>
        <a class="fa fa-shopping-bag" href="#" id="cart-icon">
            <span id="cart-count" class="badge badge-danger">{{ session('cart') ? count(session('cart')) : 0 }}</span>
        </a>
      </li>
      <li>
          <a class="fa fa-heart" href="{{ url('/favorites') }}"></a> 
      </li>
    </div>
    </header>

    <div class="container mt-5">
    <div class="row">
      <!-- Image section -->
      <div class="col-md-6">
        <img src="{{ asset('public/' . $product->product_img) }}" class="product-image-main" alt="Product Image">
      </div>

      <!-- Product Details section -->
      <div class="col-md-6">
        <h1 class="product-title">{{ $product->product_name }}</h1>
        <div class="product-price">{{ number_format($product->product_price, 0, ',', '.') }}đ</div>
        <div class="size-options mb-3">
          <label>Chọn size:</label><br>
          <button class="btn btn-outline-secondary">S</button>
          <button class="btn btn-outline-secondary">M</button>
          <button class="btn btn-outline-secondary">L</button>
          <button class="btn btn-outline-secondary" disabled>XL</button>
          <button class="btn btn-outline-secondary">XXL</button>
        </div>
        <div class="quantity mb-3">
          <label>Số lượng:</label>
          <div class="input-group" style="width: 100px;">
            <button class="btn btn-outline-secondary">-</button>
            <input type="text" class="form-control text-center" value="1">
            <button class="btn btn-outline-secondary">+</button>
          </div><br>
          <button class="btn btn-outline-secondary"><i class="far fa-heart"></i></button>
        </div>
        <button class="btn btn-outline-dark btn-buy" data-product-id="{{ $product->product_id }}">
          THÊM VÀO GIỎ
        </button>
        <a href="{{ route('checkout', ['product_id' => $product->product_id]) }}">
          <button class="btn btn-dark btn-cart">MUA HÀNG</button>
        </a>      
        <div class="mt-4">
          <ul class="nav nav-tabs" id="productTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="intro-tab" data-bs-toggle="tab" data-bs-target="#intro" type="button" role="tab" aria-controls="intro" aria-selected="true">GIỚI THIỆU</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="false">CHI TIẾT SẢN PHẨM</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="care-tab" data-bs-toggle="tab" data-bs-target="#care" type="button" role="tab" aria-controls="care" aria-selected="false">BẢO QUẢN</button>
            </li>
          </ul>
          <div class="tab-content" id="productTabContent">
            <div class="tab-pane fade show active" id="intro" role="tabpanel" aria-labelledby="intro-tab">
              <div class="content-section">
                <p class="content-text">{{ $product->product_description }}</p>
                <button class="toggle-btn btn btn-link"><i class="fa-solid fa-sort-down toggle-icon"></i></button>
              </div>
            </div>
            <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
              <div class="content-section">
                <p class="content-text">Chi tiết sản phẩm...</p>
                <button class="toggle-btn btn btn-link">Xem thêm</button>
              </div>
            </div>
            <div class="tab-pane fade" id="care" role="tabpanel" aria-labelledby="care-tab">
              <div class="content-section">
                <p class="content-text">Hướng dẫn bảo quản...</p>
                <button class="toggle-btn btn btn-link">Xem thêm</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="related-products mt-5">
      <h2 class="text-center mb-4">CÓ THỂ BẠN SẼ THÍCH</h2>
      <div class="row">
        @foreach ($relatedProducts as $relatedProduct)
          <div class="col-md-3">
            <div class="product-card">
              <span class="new-label">NEW</span>
              <a href="{{ route('products.detail', ['product_id' => $relatedProduct->product_id]) }}" class="product-link">
                <img src="{{ asset('public/' . $relatedProduct->product_img) }}" class="img-fluid" alt="Product 1">
                <p class="product-name mt-2">{{ $relatedProduct->product_name }}</p>
              </a>
                <p class="product-price">{{ number_format($relatedProduct->product_price, 0, ',', '.') }}đ</p>
              <div class="mt-2">
                <button class="btn btn-outline-secondary add-to-favorite" onclick="addFavorite('{{ $product->product_id }}')">
                  <i class="far fa-heart"></i>
                </button>
                <button class="btn btn-dark"><i class="fas fa-shopping-bag"></i></button>
              </div>
            </div>
          </div>
        @endforeach
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
</body><br>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3>Liên hệ</h3>
                <p>Hotline: 1900 XXX XXX</p>
                <p>Email: xxxxxx@vaa.edu.vn</p>
                <p>Địa chỉ: 104 Nguyễn Văn Trỗi, phường 8, Phú Nhuận, Ho Chi Minh City, Vietnam</p>
            </div>
            <div class="col-md-4">
                <h3>Về chúng tôi</h3>
                <p><a href="#">Giới thiệu</a></p>
                <p><a href="#">Tuyển dụng</a></p>
                <p><a href="#">Blog</a></p>
            </div>
            <div class="col-md-4">
                <h3>Hỗ trợ</h3>
                <p><a href="#">Hướng dẫn mua hàng</a></p>
                <p><a href="#">Chính sách đổi trả</a></p>
                <p><a href="#">Câu hỏi thường gặp</a></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <p>&copy; 2024 VAA Store.</p>
                <div class="social-media">
                    <a href="#"><i class="fab fa-facebook-f me-2"></i></a>
                    <a href="#"><i class="fab fa-twitter me-2"></i></a>
                    <a href="#"><i class="fab fa-instagram me-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>
<script>
  // Lấy thông tin từ localStorage
  const fullName = localStorage.getItem('full_name');

  if (fullName) {
      // Nếu đã đăng nhập, hiển thị dropdown user
      document.getElementById('user-dropdown').style.display = 'block';
      document.getElementById('user-full-name').innerText = fullName;
  } else {
      // Nếu chưa đăng nhập, hiển thị liên kết đăng nhập
      document.getElementById('login-link').style.display = 'block';
  }

  function clearLocalStorage() {
    localStorage.removeItem('full_name');
    localStorage.removeItem('customer_id');
}
  document.addEventListener('DOMContentLoaded', function () { 
    const customerId = localStorage.getItem('customer_id');
    console.log('Customer ID from localStorage:', customerId);

    const profileLink = document.getElementById('profile-link');
    if (customerId) {
        const href = `/vaastore/profile/${customerId}`;
        profileLink.setAttribute('href', href);
        console.log('Setting href to:', href);
    } else {
        const href = '/vaastore/login';
        profileLink.setAttribute('href', href);
        console.log('Setting href to:', href);
    }
    console.log('Final Profile Link href:', profileLink.getAttribute('href'));
});
document.querySelectorAll('.add-to-favorite').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');  // Lấy productId từ data attribute
        addFavorite(productId);  // Truyền productId như một chuỗi
    });
});

  function addFavorite(productId) {
    const customerId = localStorage.getItem('customer_id');

    if (!customerId) {
        alert("Please log in to add favorites");
        return;
    }

    console.log("Sending data:", {
        customer_id: customerId,
        product_id: productId,  // productId là chuỗi
    });

    fetch('/vaastore/favorites/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({
            customer_id: customerId,
            product_id: productId,  // Đảm bảo product_id là chuỗi
        }),
    })
    .then(response => response.json())
    .then(data => alert(data.message))
    .catch(error => console.error('Error:', error));
}
</script>
</html>