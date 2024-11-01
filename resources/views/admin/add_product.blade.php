<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('public/css/add_product.css') }}" rel='stylesheet' type='text/css' />
    <title>Thêm sản phẩm</title>
</head>
<body>
    <div class="container-ct">
        <div class="card">
            <div class="card-header">
                <h2>Thêm sản phẩm</h2>
            </div>
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
         
            <form action="{{ url('/admin/add-product') }}" method="post" name="add_prd" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="">Mã sản phẩm</label>
                    <input type="text" name="product_id" class="form-control"> 
                </div>
            
                <div class="form-group">
                    <label for="">Mã nhóm</label>
                    <input type="text" name="category_id" class="form-control">
                </div>
            
                <div class="form-group">
                    <label for="">Tên sản phẩm</label>
                    <input type="text" name="product_name" class="form-control"> 
                </div>
            
                <div class="form-group">
                    <label for="">Ngày nhập</label>
                    <input type="text" name="product_date" class="form-control"> 
                </div>
            
                <div class="form-group">
                    <label for="">Mô tả</label>
                    <input type="text" name="product_description" class="form-control"> 
                </div>
            
                <div class="form-group">
                    <label for="">Số lượng</label>
                    <input type="text" name="product_amount" class="form-control"> 
                </div>
            
                <div class="form-group">
                    <label for="">Giá</label>
                    <input type="text" name="product_price" class="form-control"> 
                </div>
            
                <div class="form-group">
                    <label for="">Hình ảnh</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="button-container">
                    <input type="submit" name="them" class="btn-add" value="Thêm">
                    <input type="button" name="huy" class="btn-cancel" value="Hủy" onclick="window.location='{{ url('admin/all-product') }}'">
                </div>
            </form>            
        </div>
    </div>
</body>
</html>
