<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('public/css/edit_product.css') }}" rel='stylesheet' type='text/css' />
    <title>Sửa Đơn Hàng</title>
</head>
<body>
    <div class="container-ct">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Sửa Đơn Hàng</h2>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update', $order->order_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="customer_id">Khách Hàng</label>
                        <input type="text" class="form-control" id="customer_id" name="customer_id" value="{{ $order->customer_id }}" required>
                    </div>
                    <div class="form-group">
                        <label for="order_status">Trạng Thái</label>
                        <select class="form-control" id="order_status" name="order_status" required>
                            <option value="Pending" {{ $order->order_status == 'Pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="Completed" {{ $order->order_status == 'Completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="Canceled" {{ $order->order_status == 'Canceled' ? 'selected' : '' }}>Hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
