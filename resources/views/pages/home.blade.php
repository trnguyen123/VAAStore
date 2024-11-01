<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VAA Store</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="{{ asset('public/css/home.css') }}" rel='stylesheet' type='text/css' />
</head>

<body>
  <div id="app">
    <header>  
      <div >
        <img src="{{ asset('public/images/logo.png') }}" alt="Logo" class="logo">
        <a class="logo" href="#"></a>
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
        <li> <a class="fa fa-user" href=""></a></li>
        <li> <a class="fa fa-shopping-bag" href=""></a></li>
      </div>
    </header>

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="public/images/slide1.jpg" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            
          </div>
        </div>
        <div class="carousel-item">
          <img src="public/images/slide2.jpg" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
          </div>
        </div>
        <div class="carousel-item">
          <img src="public/images/slide3.jpg" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <div class="container mt-5">
      <h2 class="text-center">NEW ARRIVAL</h2>
      <div class="product-slider">
        <div class="product-wrapper">
          <div class="row">
            <div class="col-md-3">
              <div class="card">
                <img src="public/images/blazer-ke-serge.jpg" class="img-fluid rounded-start" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Áo Gile Ke Serge</h5>
                  <p class="card-text">Mô tả sản phẩm ngắn gọn.</p>
                  <p class="card-text"><small class="text-muted">Giá: 1.290.000₫</small>
                    <button class="btn btn-cart float-end">
                      <i class="fa fa-shopping-bag"></i>
                    </button>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <img src="public/images/chan-vay-but-chi-lam-cobalt.jpg" class="img-fluid rounded-start" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Áo Gile Ke Serge</h5>
                  <p class="card-text">Mô tả sản phẩm ngắn gọn.</p>
                  <p class="card-text"><small class="text-muted">Giá: 1.290.000₫</small>
                    <button class="btn btn-cart float-end">
                      <i class="fa fa-shopping-bag"></i>
                    </button>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <img src="public/images/chan-vay-lua-xoe.jpg" class="img-fluid rounded-start" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Áo Gile Ke Serge</h5>
                  <p class="card-text">Mô tả sản phẩm ngắn gọn.</p>
                  <p class="card-text"><small class="text-muted">Giá: 1.290.000₫</small></p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <img src="public/images/dam-lua-xoe-tay-dai.jpg" class="img-fluid rounded-start" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Áo Gile Ke Serge</h5>
                  <p class="card-text">Mô tả sản phẩm ngắn gọn.</p>
                  <p class="card-text"><small class="text-muted">Giá: 1.290.000₫</small></p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <img src="public/images/gile-ke-serge.jpg" class="img-fluid rounded-start" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Áo Gile Ke Serge</h5>
                  <p class="card-text">Mô tả sản phẩm ngắn gọn.</p>
                  <p class="card-text"><small class="text-muted">Giá: 1.290.000₫</small></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button class="prev btn btn-secondary">
          <i class="fas fa-chevron-left"></i>
        </button>
        <button class="next btn btn-secondary">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
      <div class="text-center">
        <button class="btn btn-dark mt-3">Xem tất cả</button>
      </div>
    </div><hr class="short-line">

    <div class="container mt-5">
      <h2 class="text-center">NEW ARRIVAL</h2>
      <div class="product-slider">
        <div class="product-wrapper">
          <div class="row">
            <div class="col-md-3">
              <div class="card">
                <img src="public/images/blazer-ke-serge.jpg" class="img-fluid rounded-start" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Áo Gile Ke Serge</h5>
                  <p class="card-text">Mô tả sản phẩm ngắn gọn.</p>
                  <p class="card-text"><small class="text-muted">Giá: 1.290.000₫</small>
                    <button class="btn btn-cart float-end">
                      <i class="fa fa-shopping-bag"></i>
                    </button>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <img src="public/images/chan-vay-but-chi-lam-cobalt.jpg" class="img-fluid rounded-start" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Áo Gile Ke Serge</h5>
                  <p class="card-text">Mô tả sản phẩm ngắn gọn.</p>
                  <p class="card-text"><small class="text-muted">Giá: 1.290.000₫</small>
                    <button class="btn btn-cart float-end">
                      <i class="fa fa-shopping-bag"></i>
                    </button>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <img src="public/images/chan-vay-lua-xoe.jpg" class="img-fluid rounded-start" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Áo Gile Ke Serge</h5>
                  <p class="card-text">Mô tả sản phẩm ngắn gọn.</p>
                  <p class="card-text"><small class="text-muted">Giá: 1.290.000₫</small></p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <img src="public/images/dam-lua-xoe-tay-dai.jpg" class="img-fluid rounded-start" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Áo Gile Ke Serge</h5>
                  <p class="card-text">Mô tả sản phẩm ngắn gọn.</p>
                  <p class="card-text"><small class="text-muted">Giá: 1.290.000₫</small></p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <img src="public/images/gile-ke-serge.jpg" class="img-fluid rounded-start" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Áo Gile Ke Serge</h5>
                  <p class="card-text">Mô tả sản phẩm ngắn gọn.</p>
                  <p class="card-text"><small class="text-muted">Giá: 1.290.000₫</small></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button class="prev btn btn-secondary">
          <i class="fas fa-chevron-left"></i>
        </button>
        <button class="next btn btn-secondary">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
      <div class="text-center">
        <button class="btn btn-dark mt-3">Xem tất cả</button>
      </div>
    </div><hr class="short-line">

    <div class="container mt-5">
      <h2 class="text-center">NEW ARRIVAL</h2>
      <div class="product-slider">
        <div class="product-wrapper">
          <div class="row">
            <div class="col-md-3">
              <div class="card">
                <img src="public/images/blazer-ke-serge.jpg" class="img-fluid rounded-start" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Áo Gile Ke Serge</h5>
                  <p class="card-text">Mô tả sản phẩm ngắn gọn.</p>
                  <p class="card-text"><small class="text-muted">Giá: 1.290.000₫</small>
                    <button class="btn btn-cart float-end">
                      <i class="fa fa-shopping-bag"></i>
                    </button>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <img src="public/images/chan-vay-but-chi-lam-cobalt.jpg" class="img-fluid rounded-start" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Áo Gile Ke Serge</h5>
                  <p class="card-text">Mô tả sản phẩm ngắn gọn.</p>
                  <p class="card-text"><small class="text-muted">Giá: 1.290.000₫</small>
                    <button class="btn btn-cart float-end">
                      <i class="fa fa-shopping-bag"></i>
                    </button>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <img src="public/images/chan-vay-lua-xoe.jpg" class="img-fluid rounded-start" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Áo Gile Ke Serge</h5>
                  <p class="card-text">Mô tả sản phẩm ngắn gọn.</p>
                  <p class="card-text"><small class="text-muted">Giá: 1.290.000₫</small></p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <img src="public/images/dam-lua-xoe-tay-dai.jpg" class="img-fluid rounded-start" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Áo Gile Ke Serge</h5>
                  <p class="card-text">Mô tả sản phẩm ngắn gọn.</p>
                  <p class="card-text"><small class="text-muted">Giá: 1.290.000₫</small></p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <img src="public/images/gile-ke-serge.jpg" class="img-fluid rounded-start" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Áo Gile Ke Serge</h5>
                  <p class="card-text">Mô tả sản phẩm ngắn gọn.</p>
                  <p class="card-text"><small class="text-muted">Giá: 1.290.000₫</small></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button class="prev btn btn-secondary">
          <i class="fas fa-chevron-left"></i>
        </button>
        <button class="next btn btn-secondary">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
      <div class="text-center">
        <button class="btn btn-dark mt-3">Xem tất cả</button>
      </div>
    </div><br>

    <script src="https://cdn.jsdelivr.net/npm/vue@3.2.46/dist/vue.global.prod.js"></script>
    

      <script>
      const productWrapper = document.getElementById('product-wrapper');
      const prevButton = document.querySelector('.prev');
      const nextButton = document.querySelector('.next');
  
      let currentIndex = 0;
      const itemsPerPage = 4; // Adjust this according to your layout
      const totalItems = document.querySelectorAll('.product-wrapper .col-md-3').length;
  
      function updateSlider() {
        const offset = -currentIndex * (100 / itemsPerPage); // Calculate the offset based on currentIndex
        productWrapper.style.transform = `translateX(${offset}%)`; // Move the slider
      }

      nextButton.addEventListener('click', () => {
        if (currentIndex < Math.ceil(totalItems / itemsPerPage) - 1) {
          currentIndex++;
          updateSlider();
        }
      });

      prevButton.addEventListener('click', () => {
        if (currentIndex > 0) {
          currentIndex--;
          updateSlider();
        }
      });
    </script>

  </div>

  
</body>

<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h3>Liên hệ</h3>
        <p>Hotline: 1900 XXX XXX</p>
        <p>Email: xxxxxx@vaa.edu.vn</p>
        <p>Địa chỉ: 104 Nguyễn Văn Trỗi, Phường 8, Quận Phú Nhuận, TPHCM </p>
      </div>
      <div class="col-md-4">
        <h3>Về chúng tôi</h3>
        <p>Giới thiệu</p>
        <p>Tuyển dụng</p>
        <p>Blog</p>
      </div>
      <div class="col-md-4">
        <h3>Hỗ trợ</h3>
        <p>Hướng dẫn mua hàng</p>
        <p>Chính sách đổi trả</p>
        <p>Câu hỏi thường gặp</p>
      </div>
    </div>
  </div>
</footer>
</html>
