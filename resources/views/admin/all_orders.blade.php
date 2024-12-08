@extends('layouts.admin')

@section('title', 'Danh sách đơn hàng')

@section('content')
<div class="container">
    <h1 class="my-4">Danh sách đơn hàng</h1>

    <!-- Hiển thị thông báo nếu có -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID Đơn hàng</th>
                <th>Tên khách hàng</th>
                <th>Ngày tạo</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->customer->full_name }}</td>
                    <td>{{ $order->order_date->format('d/m/Y') }}</td>
                    <td>{{ number_format($order->orderDetails->sum(fn($d) => $d->quantity * $d->price), 0, ',', '.') }} đ</td>
                    <td>{{ $order->order_status }}</td>
                    <td>
                        <a href="{{ route('admin.order.show', $order->order_id) }}" class="btn btn-info btn-sm">Xem</a>
                        <a href="{{ route('admin.order.edit', $order->order_id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                        <a href="{{ route('admin.order.delete', $order->order_id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">Xóa</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
