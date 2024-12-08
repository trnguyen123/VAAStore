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
<header>  
    <div class="logo">
        <a href="{{ url('/home') }}">        
            <img src="{{ asset('public/images/logo.png') }}" alt="Logo" class="logo">
        </a>
    </div>
</header>
<body>
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
                            <a href="{{ route('products.detail', ['product_id' => $product->product_id]) }}">
                                <img src="{{ asset('public/' . $product->product_img) }}" class="img-fluid" alt="{{ $product->product_name }}">
                                <p class="product-name">{{ $product->product_name }}</p>
                                <p class="product-price">{{ number_format($product->product_price, 0, ',', '.') }}₫</p>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

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
</body>
</html>