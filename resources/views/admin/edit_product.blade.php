<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('public/css/edit_product.css') }}" rel='stylesheet' type='text/css' />
    <title>Sửa sản phẩm</title>
</head>
<body>
    <div class="container-ct">
        <div class="card">
            <div class="card-header">
                <h2>Sửa sản phẩm</h2>
            </div>
            <form action="{{ url('admin/update-product/' . $product->product_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="product_name">Tên sản phẩm</label>
                    <input type="text" id="product_name" name="product_name" value="{{ $product->product_name }}" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="category_id">Mã nhóm</label>
                    <input type="text" id="category_id" name="category_id" value="{{ $product->category_id }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="product_date">Ngày nhập</label>
                    <input type="date" id="product_date" name="product_date" value="{{ $product->product_date }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="product_description">Mô tả</label>
                    <textarea id="product_description" name="product_description" class="form-control" rows="4">{{ $product->product_description }}</textarea>
                </div>

                <div class="form-group">
                    <label for="product_amount">Số lượng</label>
                    <input type="number" id="product_amount" name="product_amount" value="{{ $product->product_amount }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="product_price">Giá</label>
                    <input type="number" id="product_price" name="product_price" value="{{ $product->product_price }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="product_img">Hình ảnh</label>
                    <input type="file" id="product_img" name="product_img" class="form-control">
                    @if($product->product_img)
                        <p>Hình ảnh hiện tại:</p>
                        <img src="{{ asset('public/' . $product->product_img) }}" alt="Current Product Image" style="width: 100px; height: auto;">
                    @else
                        <p>Không có hình ảnh</p>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
                <button href="{{ url('admin/all-product') }}" class="btn btn-secondary">Quay lại</a> </button>
            </form>
        </div>
    </div>
</body>
</html>
