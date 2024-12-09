<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
      <form action="{{ route('search') }}" method="GET" id="search-form">
        <li class="search">
          <input placeholder="Tìm kiếm" type="text" name="query" id="search-input">
          <button type="submit" style="background: none; border: none; cursor: pointer;">
            <i class="fas fa-search"></i>
          </button>
        </li>
      </form>
      <li class="dropdown" id="user-dropdown" style="display: none;">
        <p class="dropdown-toggle" id="user-full-name"></p>
        <div class="dropdown-content">
          <a id="profile-link" href="{{ route('profile.page') }}">Thông tin cá nhân</a>
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
                    <button class="btn btn-outline-secondary add-to-favorite" onclick="addFavorite('{{ $product->product_id }}')">
                      <i class="far fa-heart"></i>
                    </button>                  
                    <button class="btn btn-dark add-to-cart-btn" data-product-id="{{ $product->product_id }}">
                      <i class="fas fa-shopping-bag"></i>
                    </button>                  
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
              <a href={{ route('checkout') }} class="btn btn-primary">Thanh toán</a>
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
const customerId = localStorage.getItem('customer_id');
console.log('Customer ID:', customerId); // Log giá trị để kiểm tra

fetch('/vaastore/profile', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken, 
    },
    body: JSON.stringify({ customer_id: customerId }),
})
    .then(response => response.json())
    .then(data => console.log('Profile data:', data))
    .catch(error => console.error('Error:', error));

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


