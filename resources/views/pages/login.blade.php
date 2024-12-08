<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="{{ asset('public/css/login_signup.css') }}" rel='stylesheet' type='text/css' />
</head>
<body>
    <div class="container">
        <div class="form-container" id="login-form">
            <div>
                <a class="logo" href="{{ url('/home') }}">        
                  <img src="{{ asset('public/images/logo.png') }}" alt="Logo" class="logo">
                </a>
            </div>
            <h2>Đăng nhập</h2>
            <form id="login-form">
                @csrf
                <div class="input-group">
                    <label for="login-username">Tài khoản</label>
                    <input type="text" id="login-username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="login-password">Mật khẩu</label>
                    <input type="password" id="login-password" name="password" required>
                </div>
                <button type="button" id="login-submit">Đăng nhập</button>
                <p><a href="">Quên mật khẩu?</a></p>
                <p>Nếu bạn chưa có tài khoản <a href="{{ url('/signup') }}" id="show-register">Đăng kí tại đây</a></p>
            </form>            
        </div>
        <div class="alert alert-danger" id="login-error" style="display: none;">
            <p id="error-message"></p>
        </div>        
    </div>
</body>
<script>
    document.getElementById('login-submit').addEventListener('click', function () {
        // Lấy giá trị từ form
        const username = document.getElementById('login-username').value;
        const password = document.getElementById('login-password').value;

        // Gửi yêu cầu AJAX
        axios.post('{{ route("login.post") }}', {
            username: username,
            password: password,
            _token: '{{ csrf_token() }}' // Bảo mật với CSRF token
        })
        .then(response => {
            console.log(response.data);

            if (response.data.success) {
                const user = response.data;
                localStorage.setItem('customer_id', user.customer_id); // Lưu customer_id vào localStorage
                localStorage.setItem('full_name', user.full_name);
                setTimeout(() => {
                window.location.href = '/vaastore/home';
            }, 1000);            
            } else {
                // Hiển thị lỗi nếu đăng nhập không thành công
                document.getElementById('login-error').style.display = 'block';
                document.getElementById('error-message').innerText = 'Tên đăng nhập hoặc mật khẩu không đúng.';
            }
        })
        .catch(error => {
            console.error('Đăng nhập thất bại:', error);
            document.getElementById('login-error').style.display = 'block';
            document.getElementById('error-message').innerText = 'Đã xảy ra lỗi, vui lòng thử lại.';
        });
    });
</script>

</html>
