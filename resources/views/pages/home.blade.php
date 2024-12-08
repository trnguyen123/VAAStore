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
          <a id="profile-link" href="#">Thông tin cá nhân</a>
          <a href="">Đổi mật khẩu</a>
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
                    <button class="btn btn-outline-secondary"><i class="far fa-heart"></i></button>
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
    <div id="cart-popup" class="cart-popup d-none">
      <div class="cart-popup-overlay"></div>
      <div class="cart-popup-content">
        <div class="cart-popup-header">
          <h4 class="text-center">Giỏ hàng của bạn</h4>
          <button id="close-cart-popup" class="btn-close">&times;</button>
        </div>
        <div class="cart-popup-body">
          <p>Đang tải...</p> <!-- Nội dung giỏ hàng sẽ được thêm vào đây -->
        </div>
        <div class="cart-popup-footer text-center">
          <p class="mb-2"><strong>Tổng cộng: <span id="cart-total">300,000₫</span></strong></p>
          <a href="{{ url('/checkout') }}" class="btn btn-primary w-100">Thanh toán</a>
        </div>
      </div>
    </div>
  </div>
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="add-to-cart-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="1500">
      <div class="toast-header">
        <strong class="me-auto">Thông báo</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        Sản phẩm đã được thêm vào giỏ hàng thành công!
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
  document.addEventListener('DOMContentLoaded', function () {
    const customerId = localStorage.getItem('customer_id');
    if (customerId) {
        document.getElementById('profile-link').setAttribute('href', `/vaastore/profile/${customerId}`);
    } else {
        document.getElementById('profile-link').setAttribute('href', '/vaastore/login');
    }
});
  
  $(document).ready(function () {
    // Xử lý sự kiện khi nhấn nút thêm vào giỏ hàng
    $('.add-to-cart-btn').on('click', function (e) {
        e.preventDefault();

        var product_id = $(this).data('product-id'); // Lấy ID sản phẩm từ thuộc tính data

        $.ajax({
            url: '{{ route('addToCart') }}', // Đường dẫn đến route thêm sản phẩm vào giỏ hàng
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Thêm token CSRF
                product_id: product_id // ID sản phẩm
            },
            success: function (response) {
                if (response.status === 'success') {
                    // Cập nhật số lượng sản phẩm trong giỏ hàng
                    $('#cart-count').text(response.cart_count);
                    // Cập nhật nội dung của popup giỏ hàng
                    updateCartPopup(response.cart_items);
                    var toast = new bootstrap.Toast(document.getElementById('add-to-cart-toast'));
        toast.show();
                } else {
                    alert('Lỗi khi thêm sản phẩm vào giỏ hàng.');
                }
            },
            error: function () {
                alert('Đã xảy ra lỗi. Vui lòng thử lại.');
            }
        });
    });

    // Hàm để cập nhật nội dung của popup giỏ hàng
    function updateCartPopup(cartItems) {
    let cartContent = '<div class="cart-items">';
    if (cartItems.length > 0) {
        cartItems.forEach(item => {
            cartContent += `
                <div class="cart-item d-flex align-items-center mb-3">
                    <img src="${item.image}" alt="${item.name}" class="rounded me-2" style="width: 50px; height: 50px;">
                    <div class="flex-grow-1">
                        <p class="mb-0">${item.name}</p>
                        <p class="text-muted mb-0">${item.price.toLocaleString()}₫</p>
                        <input type="number" class="form-control quantity-input" 
                                value="${item.quantity}" 
                                data-product-id="${item.product_id}" 
                                min="1">
                    </div>
                    <button class="btn btn-sm btn-outline-danger remove-item" data-product-id="${item.product_id}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
        });
        cartContent += '</div>';
    } else {
        cartContent = '<p class="text-center">Hiện tại chưa có sản phẩm nào.</p>';
    }
    $('.cart-popup-body').html(cartContent);
}

// Xóa sản phẩm
document.addEventListener('click', function (event) {
    if (event.target.classList.contains('remove-item')) {
        const productId = event.target.getAttribute('data-product-id');
        
        // Tạo FormData object
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('product_id', productId);

        fetch('{{ route('removeFromCart') }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('cart-count').textContent = data.cart_count;
                updateCartPopup(data.cart_items);
            } else {
                alert('Lỗi khi xóa sản phẩm khỏi giỏ hàng.');
            }
        })
        .catch(() => {
            alert('Đã xảy ra lỗi. Vui lòng thử lại.');
        });
    }
});

// Cập nhật số lượng
document.addEventListener('change', function (event) {
    if (event.target.classList.contains('quantity-input')) {
        const productId = event.target.getAttribute('data-product-id');
        const quantity = event.target.value;
        
        // Tạo FormData object
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('product_id', productId);
        formData.append('quantity', quantity);

        fetch('{{ route('updateCartQuantity') }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('cart-count').textContent = data.cart_count;
                updateCartPopup(data.cart_items);
            } else {
                alert('Lỗi khi cập nhật số lượng sản phẩm.');
            }
        })
        .catch(() => {
            alert('Đã xảy ra lỗi. Vui lòng thử lại.');
        });
    }
});
});
</script>


