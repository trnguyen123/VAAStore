<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <link rel="stylesheet" href="{{ asset('css/edit-profile.css') }}"> 
</head>
<body>
    <div class="container">
        <h1>Thông tin cá nhân</h1>
        <!-- Thông báo lỗi hoặc thành công -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($customer)
            <form action="{{ url('/update-profile') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="full_name">Họ và tên:</label>
                    <input type="text" name="full_name" id="full_name" class="form-control" value="{{ $customer->full_name }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $customer->email }}" required>
                </div>

                <div class="form-group">
                    <label for="phone_number">Số điện thoại:</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ $customer->phone_number }}">
                </div>

                <div class="form-group">
                    <label for="address">Địa chỉ:</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ $customer->address }}">
                </div>

                <div class="form-group">
                    <label for="gender">Giới tính:</label>
                    <select name="gender" id="gender" class="form-control">
                        <option value="male" {{ $customer->gender == 'male' ? 'selected' : '' }}>Nam</option>
                        <option value="female" {{ $customer->gender == 'female' ? 'selected' : '' }}>Nữ</option>
                        <option value="other" {{ $customer->gender == 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
            </form>
        @else
            <p>Vui lòng đăng nhập để chỉnh sửa thông tin cá nhân.</p>
        @endif
    </div>

    <script src="{{ asset('js/app.js') }}"></script> <!-- Kết nối file JS -->
</body>
</html>
