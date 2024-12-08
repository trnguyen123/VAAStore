<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('public/css/all_product.css') }}" rel='stylesheet' type='text/css' />
    <title>Quản lí danh sách sản phẩm</title>
</head>
<body>
    <div class="container-ct">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Danh sách sản phẩm</h2>
                <a href="{{ url('/admin/') }}" class="btn btn-warning">Quay lại</a>
            </div>            
            <table class="table">
                <thead>
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th>Mã nhóm</th>
                        <th>Tên sản phẩm</th>
                        <th>Ngày nhập</th>
                        <th>Mô tả</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Hình ảnh</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->product_id }}</td>          
                            <td>{{ $product->category_id }}</td>         
                            <td>{{ $product->product_name }}</td>        
                            <td>{{ $product->product_date }}</td>        
                            <td>{{ $product->product_description }}</td> 
                            <td>{{ $product->product_amount }}</td>      
                            <td>{{ number_format($product->product_price, 0, ',', '.') }} VNĐ</td> 
                            <td>
                                @if($product->product_img)                  
                                <img src="{{ asset('public/' . $product->product_img) }}" alt="Product Image" style="width: 100px; height: auto;">
                                @else
                                    <p>Không có hình ảnh</p>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product->product_id) }}" class="btn btn-warning">Sửa</a>
                                <form action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')">Xóa</button>
                                </form>
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>        
            </table>
            <div class="pagination pagination-sm justify-content-center"> {{ $products->links() }} </div>
        </div>
    </div>
</body>

</html>