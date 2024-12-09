<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Thông tin cá nhân</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="{{ asset('public/css/show_profile.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <a href="{{ url('/home') }}">
                <img src="{{ asset('public/images/logo.png') }}" alt="Logo" class="logo">
            </a>
        </div>
    </header>

    <div class="container mt-4">
        <h1>Thông tin cá nhân</h1>
    
        <!-- Thông báo nếu có lỗi -->
        <div id="message" style="display: none;" class="alert alert-danger"></div>
    
        <div id="profile-container" style="display: none;">
            <p><strong>Họ và tên:</strong> <span id="full-name"></span></p>
            <p><strong>Email:</strong> <span id="email"></span></p>
            <p><strong>Số điện thoại:</strong> <span id="phone-number"></span></p>
            <p><strong>Địa chỉ:</strong> <span id="address"></span></p>
            <p><strong>Giới tính:</strong> <span id="gender"></span></p>
            <p><strong>Ngày sinh:</strong> <span id="date-of-birth"></span></p>
            <a href="{{ route('profile.editpage') }}" id="editProfileLink" class="btn btn-primary">Chỉnh sửa thông tin</a>
        </div>
        <!-- Thông báo nếu chưa đăng nhập -->
        <p id="login-message" style="display: none;">Vui lòng đăng nhập để xem thông tin cá nhân.</p>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3>Liên hệ</h3>
                    <p>Hotline: 1900 XXX XXX</p>
                    <p>Email: xxxxxx@vaa.edu.vn</p>
                    <p>Địa chỉ: 104 Nguyễn Văn Trỗi, Phường 8, Quận Phú Nhuận, TPHCM</p>
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
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const cusId = localStorage.getItem('customer_id');  // Lấy customer_id từ localStorage

    // Lấy CSRF token từ thẻ meta
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Kiểm tra nếu `customer_id` tồn tại
    if (cusId) {
        // Gọi API lấy thông tin từ server
        fetch('/vaastore/profile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,  // Sử dụng csrfToken đã lấy từ meta
            },
            body: JSON.stringify({ customer_id: cusId })  // Gửi customer_id trong payload
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const customer = data.customer;

                    // Hiển thị thông tin người dùng
                    document.getElementById('profile-container').style.display = 'block';
                    document.getElementById('full-name').innerText = customer.full_name;
                    document.getElementById('email').innerText = customer.email;
                    document.getElementById('phone-number').innerText = customer.phone_number || 'Không có thông tin';
                    document.getElementById('address').innerText = customer.address || 'Không có thông tin';
                    document.getElementById('gender').innerText = customer.gender === 'male' ? 'Nam' : (customer.gender === 'female' ? 'Nữ' : 'Không có thông tin');
                    document.getElementById('date-of-birth').innerText = customer.date_of_birth || 'Không có thông tin';
                } else {
                    // Hiển thị thông báo lỗi
                    document.getElementById('message').style.display = 'block';
                    document.getElementById('message').innerText = 'Không thể lấy thông tin người dùng.';
                }
            })
            .catch(error => {
                console.error('Lỗi khi lấy thông tin người dùng:', error);
                document.getElementById('message').style.display = 'block';
                document.getElementById('message').innerText = 'Đã xảy ra lỗi khi kết nối với server.';
            });
    } else {
        // Hiển thị thông báo chưa đăng nhập
        document.getElementById('login-message').style.display = 'block';
    }
    
    editProfileLink.addEventListener('click', function(event) {
        console.log('Chuyển đến trang chỉnh sửa thông tin với customer_id:', cusId);  // Log để xem customer_id
        fetch('/vaastore/profile/edit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,  // Sử dụng csrfToken đã lấy từ meta
            },
            body: JSON.stringify({ customer_id: cusId })  // Gửi customer_id trong payload
        })
        .then(response => {
            console.log('Phản hồi từ server:', response);  // Log để kiểm tra phản hồi từ server
            return response.json();  // Chuyển đổi phản hồi thành JSON
        })
        .then(data => {
            console.log('Dữ liệu nhận được từ server:', data);  // Log dữ liệu JSON trả về
            if (data.success) {
                // Nếu thành công, chuyển hướng đến trang chỉnh sửa
                console.log('Chuyển hướng đến trang chỉnh sửa');
                window.location.href = '{{ route('profile.editpage') }}';
            } else {
                // Nếu có lỗi
                alert(data.message || 'Đã xảy ra lỗi khi cập nhật.');
            }
        })
        .catch(error => {
            console.error('Lỗi khi gửi yêu cầu:', error);
            alert('Đã xảy ra lỗi trong quá trình yêu cầu: ' + error.message);  // Hiển thị lỗi chi tiết
        });
    });
});

</script>
</html>
