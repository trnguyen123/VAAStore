
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lí thanh toán</title>
    <link href="{{ asset('public/css/all_product.css') }}" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="brand">
        <a class="logo" href="{{ url('/admin/') }}">
            <img src="{{ asset('public/images/logo.png') }}" alt="Logo" class="logo-img">
        </a>
	</div>
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
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr>
                        <td>{{ $payment->payment_id }}</td>
                        <td>{{ $payment->order->customer->full_name }}</td>
                        <td>{{ $payment->payment_method }}</td>
                        <td>{{ number_format($payment->total_amount, 0, ',', '.') }} đ</td>
                        <td>{{ $payment->payment_status }}</td>
                        <td>
                            <a href="{{ route('admin.payments.edit', ['payment' => $payment->payment_id]) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="{{ url('/admin/payment/delete/'.$payment->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>   
        </div>
        @if ($payments->lastPage() > 1)
                <ul class="custom-pagination">
                    @if ($payments->onFirstPage())
                        <li class="disabled"><span>&laquo;</span></li>
                    @else
                        <li><a href="{{ $payments->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                    @endif

                    @foreach ($payments->getUrlRange(1, $payments->lastPage()) as $page => $url)
                        <li class="{{ $page == $payments->currentPage() ? 'active' : '' }}">
                            <a href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    @if ($payments->hasMorePages())
                        <li><a href="{{ $payments->nextPageUrl() }}" rel="next">&raquo;</a></li>
                    @else
                        <li class="disabled"><span>&raquo;</span></li>
                    @endif
                </ul>
            @endif     
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
