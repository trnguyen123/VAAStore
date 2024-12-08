@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container">
    <h1 class="my-4">Chi tiết đơn hàng #{{ $order->order_id }}</h1>

    <!-- Thông tin đơn hàng -->
    <div class="card mb-4">
        <div class="card-header">
            <h4>Thông tin đơn hàng</h4>
        </div>
        <div class="card-body">
            <p><strong>Khách hàng:</strong> {{ $order->customer->full_name }}</p>
            <p><strong>Email:</strong> {{ $order->customer->email }}</p>
            <p><strong>Số điện thoại:</strong> {{ $order->customer->phone_number }}</p>
            <p><strong>Ngày tạo:</strong> {{ $order->order_date->format('d/m/Y') }}</p>
            <p><strong>Ghi chú:</strong> {{ $order->order_note }}</p>
            <p><strong>Trạng thái:</strong> {{ $order->order_status }}</p>
        </div>
    </div>

    <!-- Chi tiết sản phẩm -->
    <div class="card">
        <div class="card-header">
            <h4>Sản phẩm trong đơn hàng</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID Sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Tổng tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $detail)
                        <tr>
                            <td>{{ $detail->product_id }}</td>
                            <td>{{ $detail->product->name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                            <td>{{ number_format($detail->quantity * $detail->price, 0, ',', '.') }} đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tổng tiền -->
    <div class="mt-4 text-end">
        <h5><strong>Tổng tiền:</strong> {{ number_format($order->orderDetails->sum(fn($d) => $d->quantity * $d->price), 0, ',', '.') }} đ</h5>
    </div>

    <!-- Nút hành động -->
    <div class="mt-4">
        <a href="{{ route('admin.orders') }}" class="btn btn-secondary">Quay lại</a>
    </div>
</div>
@endsection
