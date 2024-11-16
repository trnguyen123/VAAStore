<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link href="{{ asset('public/css/login_signup.css') }}" rel='stylesheet' type='text/css' />
</head>
<body>
    <div class="container">
        <div class="form-container" id="register-form" style="display: block;">
            <div>
                <a class="logo" href="{{ url('/home') }}">        
                    <img src="{{ asset('public/images/logo.png') }}" alt="Logo" class="logo">
                </a>
            </div>
            <h2>Đăng Ký</h2>
            <form action="{{ route('signup.post') }}" method="post">
                @csrf 
                <div class="input-group">
                    <label for="full_name">Họ và tên</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>
                <div class="input-group">
                    <label for="register-username">Tài khoản</label>
                    <input type="text" id="register-username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="register-email">Email</label>
                    <input type="email" id="register-email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="register-password">Mật khẩu</label>
                    <input type="password" id="register-password" name="password" required>
                </div>
                <div class="input-group">
                    <label for="register-password_confirmation">Xác nhận mật khẩu</label>
                    <input type="password" id="register-password_confirmation" name="password_confirmation" required>
                </div>
                <button type="submit">Đăng Ký</button>
                <p>Đã có tài khoản? <a href="{{ url('/login') }}" id="show-login">Đăng nhập tại đây</a></p>
            </form>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</body>
</html>
