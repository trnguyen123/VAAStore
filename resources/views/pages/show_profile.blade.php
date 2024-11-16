<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="{{ asset('public/css/product.css') }}" rel='stylesheet' type='text/css'>
    <link href="{{ asset('public/css/show-profile.css') }}" rel="stylesheet"> <!-- Thêm file CSS nếu cần -->
</head>
<body>
    <!-- Header -->
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

    <div class="container mt-4">
        <h1>Thông tin cá nhân</h1>

        <!-- Thông báo lỗi hoặc thành công -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($customer)
            <div class="profile-info">
                <p><strong>Họ và tên:</strong> {{ $customer->full_name }}</p>
                <p><strong>Email:</strong> {{ $customer->email }}</p>
                <p><strong>Số điện thoại:</strong> {{ $customer->phone_number }}</p>
                <p><strong>Địa chỉ:</strong> {{ $customer->address }}</p>
                <p><strong>Giới tính:</strong> 
                    @if($customer->gender == 'male')
                        Nam
                    @elseif($customer->gender == 'female')
                        Nữ
                    @else
                        Khác
                    @endif
                </p>
                <p><strong>Ngày sinh:</strong> {{ $customer->date_of_birth }}</p>
            </div>

            <!-- Nút chỉnh sửa thông tin -->
            <a href="{{ route('edit') }}" class="btn btn-primary">Chỉnh sửa thông tin</a>
        @else
            <p>Vui lòng đăng nhập để xem thông tin cá nhân.</p>
        @endif
    </div>

    <!-- Footer -->
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

    <script src="{{ asset('js/app.js') }}"></script> <!-- Kết nối file JS -->
</body>
</html>
