<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>VAA Store</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="{{ asset('public/css/product.css') }}" rel='stylesheet' type='text/css' />
<script src="{{ asset('public/js/product.js') }}" defer></script> 
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
<div class="row mt-4">
    <!-- Sidebar -->
    <div class="col-md-3 filter-sidebar">
      <h5 class="mb-4">Lọc sản phẩm</h5>

      <!-- Bộ lọc mức giá -->
      <div class="filter-group mb-4">
        <label class="filter-label">Mức giá</label>
        <select class="form-select" id="filter-price">
          <option value="all">Tất cả</option>
          <option value="100.000-200.000">100.000₫ - 200.000₫</option>
          <option value="200.000-300.000">200.000₫ - 300.000₫</option>
          <option value="300.000-400.000">300.000₫ - 400.000₫</option>
          <option value="400.000-500.000">400.000₫ - 500.000₫</option>
          <option value="500.000-more">500.000₫ trở lên.</option>
        </select><br>
      </div>

      <!-- Nút áp dụng -->
      <button class="btn btn-dark w-100" id="apply-filters">Áp dụng lọc</button>
    </div>

    <!-- Product List -->
    <div class="col-md-9">
      <h2 class="mb-4"></h2>
      <div class="d-flex justify-content-end mb-3">
        <label for="sort" class="me-2">Sắp xếp theo</label>
        <select id="sort" class="form-select w-auto">
          <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Mặc định</option>
          <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Giá</option>
        </select>
      </div>
      <div class="row row-cols-1 row-cols-md-3 g-4" id="product-list">
        @foreach ($products as $product)
        <div class="col">
          <div class="product-card" data-price="{{ $product->product_price }}">
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
      {{ $products->links() }}
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

document.addEventListener('DOMContentLoaded', function() {
  const sortSelect = document.getElementById('sort');
  const sortOrder = localStorage.getItem('sortOrder');

  if (sortOrder) {
    sortSelect.value = sortOrder;
  }

  sortSelect.addEventListener('change', function() {
    localStorage.setItem('sortOrder', this.value);
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('sort', this.value);
    window.location.search = urlParams.toString();
  });
});

</script>
</html>