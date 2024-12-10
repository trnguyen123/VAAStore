<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('public/css/edit_product.css') }}" rel="stylesheet" type="text/css">
    <title>Sửa khách hàng</title>
</head>
<body>
    <div class="container-ct">
        <div class="card">
            <div class="card-header">
                <h2>Sửa khách hàng</h2>
            </div>
            <form action="{{ route('admin.update_customer', $customer->customer_id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="full_name">Họ và tên</label>
                    <input type="text" id="full_name" name="full_name" value="{{ $customer->full_name }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ $customer->email }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="phone_number">Điện thoại</label>
                    <input type="text" id="phone_number" name="phone_number" value="{{ $customer->phone_number }}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <input type="text" id="address" name="address" value="{{ $customer->address }}" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật khách hàng</button>
                <a href="{{ url('/all-customer') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</body>
</html>
