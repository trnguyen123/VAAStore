@extends('admin.admin_dashboard')
@section('content')
<h2>Chi tiết khách hàng</h2>
<p>ID: {{ $customer->customer_id }}</p>
<p>Họ và tên: {{ $customer->full_name }}</p>
<p>Email: {{ $customer->email }}</p>
<p>Điện thoại: {{ $customer->phone_number }}</p>
<p>Địa chỉ: {{ $customer->address }}</p>
<p>Ngày sinh: {{ $customer->date_of_birth }}</p>
<p>Giới tính: {{ $customer->gender }}</p>
<a href="{{ route('admin.show_customer) }}" class="btn btn-primary">Quay lại</a>
@endsection
