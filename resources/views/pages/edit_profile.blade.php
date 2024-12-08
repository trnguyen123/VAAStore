<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa thông tin cá nhân</title>
    <link rel="stylesheet" href="{{ asset('css/edit-profile.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h1>Chỉnh sửa thông tin cá nhân</h1>

        <!-- Thông báo lỗi hoặc thành công -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Hiển thị form chỉnh sửa -->
        @if($customer)
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="full_name">Họ và tên:</label>
                    <input 
                        type="text" 
                        name="full_name" 
                        id="full_name" 
                        class="form-control @error('full_name') is-invalid @enderror" 
                        value="{{ old('full_name', $customer->full_name) }}" 
                        required>
                    @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email:</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        value="{{ old('email', $customer->email) }}" 
                        required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="phone_number">Số điện thoại:</label>
                    <input 
                        type="text" 
                        name="phone_number" 
                        id="phone_number" 
                        class="form-control @error('phone_number') is-invalid @enderror" 
                        value="{{ old('phone_number', $customer->phone_number) }}">
                    @error('phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="address">Địa chỉ:</label>
                    <input 
                        type="text" 
                        name="address" 
                        id="address" 
                        class="form-control @error('address') is-invalid @enderror" 
                        value="{{ old('address', $customer->address) }}">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="gender">Giới tính:</label>
                    <select 
                        name="gender" 
                        id="gender" 
                        class="form-control @error('gender') is-invalid @enderror">
                        <option value="male" {{ old('gender', $customer->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                        <option value="female" {{ old('gender', $customer->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
                        <option value="other" {{ old('gender', $customer->gender) == 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
            </form>
        @else
            <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để chỉnh sửa thông tin cá nhân.</p>
        @endif
    </div>
</body>
</html>
