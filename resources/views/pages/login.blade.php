
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="{{ asset('public/css/login_signup.css') }}" rel='stylesheet' type='text/css' />
</head>
<body>
    <div class="container">
        <div class="form-container" id="login-form">
            <div >
                <a class="logo" href="{{ url('/home') }}">        
                  <img src="{{ asset('public/images/logo.png') }}" alt="Logo" class="logo">
                </a>
            </div>
            <h2>Đăng nhập</h2>
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label for="login-username">Username</label>
                    <input type="text" id="login-username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" name="password" required>
                </div>
                <button type="submit">Login</button>
                <p>Don't have an account? <a href="{{ url('/signup') }}" id="show-register">Register here</a></p>
            </form>
        </div>
    </div>
</body>
</html>