<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('public/css/all_product.css') }}" rel='stylesheet' type='text/css' />
    <title>Quản lí danh sách khách hàng</title>
</head>
<body>
    <div class="container-ct">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Danh sách khách hàng</h2>
                <a href="{{ url('/admin/') }}" class="btn btn-warning">Quay lại</a>
            </div>            
            <table class="table">
                <thead>
                    <tr>
                        <th>Mã khách hàng</th>
                        <th>Họ và tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                        <tr>
                            <td>{{ $customer->customer_id }}</td>          
                            <td>{{ $customer->full_name }}</td>         
                            <td>{{ $customer->email }}</td>        
                            <td>{{ $customer->phone_number }}</td>        
                            <td>{{ $customer->address }}</td>      
                            <td>
                                <a href="{{ route('admin.edit_customer', $customer->customer_id) }}" class="btn btn-warning">Sửa</a>
                                <form action="{{ route('admin.del_customer', $customer->customer_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này không?')">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>        
            </table>
            <div class="pagination pagination-sm justify-content-center"> {{ $customers->links() }} </div>
        </div>
    </div>
</body>
</html>
