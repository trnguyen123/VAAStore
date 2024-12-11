@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi Tiết Đơn Hàng</h1>
    <p><strong>Mã Đơn Hàng:</strong> {{ $order->order_id }}</p>
    <p><strong>Khách Hàng:</strong> {{ $order->customer_id }}</p>
    <p><strong>Ngày Giao:</strong> {{ $order->shipping_date }}</p>
    <p><strong>Ghi Chú:</strong> {{ $order->order_note }}</p>
    <p><strong>Trạng Thái:</strong> {{ $order->order_status }}</p>

    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay Lại</a>
</div>
@endsection
