<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VAA Store</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="resource/css/style.css">
  
</head>
<body>
  <div class="app">
    <header>  
      <div class="logo">
        <a href="{{ url('/home') }}">        
          <img src="{{ asset('public/images/logo.png') }}" alt="Logo" class="logo">
        </a>
      </div>
      <div class="menu">
        <ul> 
            @foreach ($categories as $category)
              <li><a href="{{ route('products.category', ['category_id' => $category->category_id]) }}">{{ $category->category_name }}</a></li>
            @endforeach
        </ul>
    </div>
      <div class = "others">
        <li> <input placeholder="Tìm kiếm" type="text"> <i class="fas fa-search"></i></li>
        <li> <a class="fa fa-user" href="{{ url('/login') }}"></a></li>
        <li> <a class="fa fa-shopping-bag" href=""></a></li>
      </div>
    </header>
    <div class="content">
      <h1>Danh sách sản phẩm trong danh mục: </h1> 
      <ul>
          @foreach ($products as $product)
          <img src="{{ asset('public/' . $product->product_img) }}" alt="Product Image" style="width: 100px; height: auto;">
          <li>Tên sản phẩm: {{ $product->product_name }} </li>
          <li>Giá: {{ $product->product_price }}</li>
          @endforeach
      </ul>
    </div>
  </div>
</body>
</html>