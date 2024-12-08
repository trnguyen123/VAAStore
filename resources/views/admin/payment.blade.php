@extends('layouts.admin')

@section('title', 'Quản lí thanh toán')

@section('content')
<div class="container">
    <h1 class="my-4">Quản lí thanh toán</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID Thanh toán</th>
                <th>Tên khách hàng</th>
                <th>Phương thức</th>
                <th>Số tiền</th>
                <th>Trạng thái</th>
                <th>Ngày thanh toán</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->customer_name }}</td>
                    <td>{{ $payment->method }}</td>
                    <td>{{ number_format($payment->amount, 0, ',', '.') }} đ</td>
                    <td>{{ $payment->status }}</td>
                    <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ url('/admin/payment/view/'.$payment->id) }}" class="btn btn-info btn-sm">Xem</a>
                        <a href="{{ url('/admin/payment/delete/'.$payment->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
