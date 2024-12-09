<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chỉnh sửa thông tin cá nhân</title>
    <link rel="stylesheet" href="{{ asset('css/edit_profile.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
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
        <h1>Chỉnh sửa thông tin cá nhân</h1>

        <!-- Thông báo lỗi hoặc thành công -->
        <div id="message"></div>

        <!-- Hiển thị form chỉnh sửa -->
        <form id="editProfileForm">
            <div class="form-group mb-3">
                <label for="full_name">Họ và tên:</label>
                <input 
                    type="text" 
                    name="full_name" 
                    id="full_name" 
                    class="form-control" 
                    required>
            </div>

            <div class="form-group mb-3">
                <label for="email">Email:</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control" 
                    required>
            </div>

            <div class="form-group mb-3">
                <label for="phone_number">Số điện thoại:</label>
                <input 
                    type="text" 
                    name="phone_number" 
                    id="phone_number" 
                    class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="address">Địa chỉ:</label>
                <input 
                    type="text" 
                    name="address" 
                    id="address" 
                    class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="gender">Giới tính:</label>
                <select 
                    name="gender" 
                    id="gender" 
                    class="form-control">
                    <option value="male">Nam</option>
                    <option value="female">Nữ</option>
                    <option value="other">Khác</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="date_of_birth">Ngày sinh:</label>
                <input 
                    type="date" 
                    name="date_of_birth" 
                    id="date_of_birth" 
                    class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
        </form>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const customerId = localStorage.getItem('customer_id');  // Lấy customer_id từ localStorage
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');  // Lấy CSRF token

        console.log('Customer ID:', customerId);
        console.log('CSRF Token:', csrfToken);

        if (customerId) {
            // Gửi POST request để lấy thông tin người dùng từ server
            console.log('Đang gửi yêu cầu đến server...');
            
            fetch('/vaastore/profile/edit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken  // Đảm bảo gửi token để bảo vệ khỏi CSRF
                },
                body: JSON.stringify({ customer_id: customerId })  // Truyền customer_id trong body request
            })
            .then(response => {
                console.log('Phản hồi từ server:', response);
                return response.json();
            })
            .then(data => {
                console.log('Dữ liệu nhận được từ server:', data);
                if (data.success) {
                    // Đổ dữ liệu vào các trường form nếu thành công
                    const customer = data.customer;
                    document.getElementById('full_name').value = customer.full_name;
                    document.getElementById('email').value = customer.email;
                    document.getElementById('phone_number').value = customer.phone_number || '';
                    document.getElementById('address').value = customer.address || '';
                    document.getElementById('gender').value = customer.gender;
                    document.getElementById('date_of_birth').value = customer.date_of_birth || '';
                } else {
                    // Nếu có lỗi, hiển thị thông báo
                    document.getElementById('message').innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            })
            .catch(error => {
                console.error('Có lỗi xảy ra khi tải thông tin người dùng:', error);
                document.getElementById('message').innerHTML = `<div class="alert alert-danger">Đã xảy ra lỗi khi tải thông tin người dùng.</div>`;
            });
        } else {
            console.log('Không tìm thấy customer_id trong localStorage.');
            document.getElementById('message').innerHTML = `<div class="alert alert-danger">Vui lòng đăng nhập để chỉnh sửa thông tin.</div>`;
        }

        // Xử lý khi gửi form
        document.getElementById('editProfileForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);  // Lấy dữ liệu từ form
            formData.append('customer_id', customerId);  // Thêm customer_id vào formData

            console.log('Gửi dữ liệu form:', formData);
            
            fetch('/vaastore/profile/update', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken  // Đảm bảo gửi CSRF token
                },
                body: formData  // Gửi formData, bao gồm cả customer_id
            })
            .then(response => {
                console.log('Phản hồi từ server khi cập nhật:', response);
                return response.json();
            })
            .then(data => {
                console.log('Dữ liệu nhận được từ server khi cập nhật:', data);
                const messageDiv = document.getElementById('message');
                if (data.success) {
                    messageDiv.innerHTML = '<div class="alert alert-success">Cập nhật thông tin thành công</div>';
                    setTimeout(function() {
                        window.location.href = '/vaastore/profile';  
                    }, 500);  // Đợi 1.5 giây trước khi chuyển hướng
                } else {
                    messageDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            })
            .catch(error => {
                console.error('Có lỗi xảy ra khi gửi form:', error);
            });
        });
    });
</script>
</html>
