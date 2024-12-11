<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('public/css/all_product.css') }}" rel='stylesheet' type='text/css' />
    <title>Quản lý Đơn Hàng</title>
</head>
<body>
    <div class="container-ct">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Danh sách Đơn Hàng</h2>
                <a href="{{ url('/admin/') }}" class="btn btn-warning">Quay lại</a>
            </div>            
            <table class="table">
                <thead>
                    <tr>
                        <th>Mã Đơn Hàng</th>
                        <th>Khách Hàng</th>
                        <th>Ngày Đặt</th>
                        <th>Trạng Thái</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->customer_id }}</td>
                            <td>{{ $order->order_date }}</td>
                            <td>{{ $order->order_status }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->order_id) }}" class="btn btn-info">Xem</a>
                                <a href="{{ route('admin.orders.edit', $order->order_id) }}" class="btn btn-warning">Sửa</a>
                                <form action="{{ route('admin.orders.destroy', $order->order_id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>        
            </table>
            @if ($orders->lastPage() > 1)
                <ul class="custom-pagination">
                    @if ($orders->onFirstPage())
                        <li class="disabled"><span>&laquo;</span></li>
                    @else
                        <li><a href="{{ $orders->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                    @endif

                    @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                        <li class="{{ $page == $orders->currentPage() ? 'active' : '' }}">
                            <a href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    @if ($orders->hasMorePages())
                        <li><a href="{{ $orders->nextPageUrl() }}" rel="next">&raquo;</a></li>
                    @else
                        <li class="disabled"><span>&raquo;</span></li>
                    @endif
                </ul>
            @endif
    </div>
</div>
</body>
</html>
