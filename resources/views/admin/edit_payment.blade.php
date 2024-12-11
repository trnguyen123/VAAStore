<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('public/css/all_product.css') }}" rel="stylesheet" type="text/css">
    <title>Sửa Thanh Toán</title>
</head>
<body>
    <div class="container-ct">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Sửa Thanh Toán</h2>
                <a href="{{ url('/admin/payments') }}" class="btn btn-warning">Quay lại</a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.payments.update', $payment->payment_id) }}" method="POST">
                    @csrf
                    @method('POST') <!-- Giữ nguyên phương thức POST như yêu cầu -->
                    <div class="form-group">
                        <label for="payment_id">Mã Thanh Toán</label>
                        <input type="text" class="form-control" id="payment_id" name="payment_id" value="{{ $payment->payment_id }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="payment_status">Trạng Thái</label>
                        <select class="form-control" id="payment_status" name="payment_status" required>
                            <option value="Pending" {{ $payment->payment_status == 'Pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="Completed" {{ $payment->payment_status == 'Completed' ? 'selected' : '' }}>Hoàn thành</option>
                        </select>                    
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
