@extends('layouts.admin')

@section('title', 'Chỉnh sửa đơn hàng')

@section('content')
<div class="container">
    <h1 class="my-4">Chỉnh sửa đơn hàng #{{ $order->order_id }}</h1>

    <form action="{{ route('admin.order.update', $order->order_id) }}" method="POST">
        @csrf
        @method('POST')

        <div class="mb-3">
            <label for="order_status" class="form-label">Trạng thái đơn hàng</label>
            <select id="order_status" name="order_status" class="form-select" required>
                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Đã giao</option>
                <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Hủy</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="order_note" class="form-label">Ghi chú</label>
            <textarea id="order_note" name="order_note" class="form-control" rows="3">{{ old('order_note', $order->order_note) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật đơn hàng</button>
        <a href="{{ route('admin.orders') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
