<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop VaaT7</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('resources/css/style.css') }}">
  <style>
    .navbar-brand{
        color: #ffffff;
        font-size: 30px;
    }

    .header-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        background-color: #33CCFF; /* Thay đổi màu nền nếu cần */
        background-image: linear-gradient(to right, #007bff, #000000); /* Thay đổi gradient nếu cần */
        border-bottom: 2px solid #ccc;
    }

    .search-icon, .cart-icon, .profile-icon, .menu-icon {
        font-size: 20px;
        color: #fff;
        cursor: pointer;
        margin: 0 20px;
    }

    /**/
    footer {
      background-color: #f2f2f2;
      padding: 30px;
      text-align: center;   
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .row {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    .col-md-4 {
      flex: 1;
      padding: 15px;
      margin: 0 20px;
    }

    h3 {
      text-align: left;
      font-size: 20px;
      margin-bottom: 10px;
    }

    p {
      text-align: left;
      margin-bottom: 5px;
    }

    /**/
    .collection-container, .new-container, .special-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px;
      margin: 20px;
    }

    .collection-items {
      display: flex;
      justify-content: space-between;
      width: 80%;
    }

    .collection-item {
      text-align: center;
    }

    .collection-item img {
      max-width: 100%;
      height: auto;
    }

    .view-all {
      margin-top: 20px;
    }

    .short-line {
      width: 50rem;
      border-top: 2px solid black;
      border-radius: 2px; /* Làm tròn góc */
      margin: 20px auto; /* Căn giữa đường gạch ngang */
    }

    /**/
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 250px; /* Độ rộng của menu ẩn */
      height: 100%;
      background-color: #f0f0f0;
      padding: 20px;
      transform: translateX(-100%); /* Ẩn menu ban đầu */
      transition: transform 0.3s ease-in-out;
    }

    .show-sidebar {
      transform: translateX(0); /* Hiển thị menu */
    }
  </style>
</head>

<body>
  <div id="app">
    <div class="slide-bar">
      <div class="menu-icon" @click="toggleMenu">
          <i class="fas fa-bars"></i>
      </div>
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
      <div class="icons">
          <i class="fa-solid fa-magnifying-glass icon"></i>
          <i class="fas fa-heart icon"></i>
          <i class="fas fa-shopping-cart icon"></i>
          <i class="fa-solid fa-user icon"></i>
      </div>
  </div>
  <div class="menu" v-if="showMenu">
      <ul>
          <li v-for="category in categories" :key="category.category_id">
              <a :href="'/category/' + category.category_id">{{ category.category_name }}</a>
          </li>
      </ul>
  </div>
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div v-for="(image, index) in images" :key="index" class="carousel-item" :class="{ active: index === 0 }">
          <img :src="image" class="d-block w-100" alt="...">
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div v-for="product in products" :key="product.id" class="col-md-4">
          <div class="card">
            <img :src="product.image" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">{{ product.name }}</h5>
              <p class="card-text">{{ product.description }}</p>
              <button class="btn btn-primary">Xem chi tiết</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="collection-container">
      <h2>OUR COLLECTION</h2>
        <div class="collection-items">
          <div class="collection-item" v-for="item in items" :key="item.id">
            <img :src="item.image" :alt="item.title">
            <p>{{ item.title }}</p>
          </div>
        </div>
       <a href="collection.blade.php" class="view-all">Xem tất cả</a>
    </div><hr class="short-line">

    <div class="new-container">
      <h2>NEW</h2>
        <div class="collection-items">
          <div class="collection-item" v-for="item in news" :key="item.id">
            <img :src="item.image" :alt="item.title">
            <p>{{ item.title }}</p>
          </div>
        </div>
       <a href="new.blade.php" class="view-all">Xem tất cả</a>
    </div><hr class="short-line">

    <script src="https://cdn.jsdelivr.net/npm/vue@3.2.46/dist/vue.global.prod.js"></script>
      <script>
        const app = Vue.createApp({
          data() {
            return {
              isSidebarVisible: false,
              shopName: 'STeam7',
              images: [
                '/images/1.jpg',
                'image2.jpg',
                'image3.jpg'
              ],
              products: [
                { id: 1, name: 'Áo thun', description: 'Áo thun cotton cao cấp', image: 'product1.jpg' },
                { id: 2, name: 'Áo thun', description: 'Áo thun cotton cao cấp', image: 'product1.jpg' },
                { id: 3, name: 'Áo thun', description: 'Áo thun cotton cao cấp', image: 'product1.jpg' },
                { id: 4, name: 'Áo thun', description: 'Áo thun cotton cao cấp', image: 'product1.jpg' },
                // ... thêm các sản phẩm khác
              ],
              items: [
                { image: 'anh1.jpg', title: ' 4TH ANNIVERSARY' },
                { image: 'anh4.jpg', title: ' | POPPOP COLLAB' },
                { image: 'anh1.jpg', title: ' 4TH ANNIVERSARY' },
                { image: 'anh1.jpg', title: ' 4TH ANNIVERSARY' },
              ],
              news: [
                { image: 'anh1.jpg', title: ' 4TH ANNIVERSARY' },
                { image: 'anh4.jpg', title: ' | POPPOP COLLAB' },
                { image: 'anh1.jpg', title: ' 4TH ANNIVERSARY' },
                { image: 'anh1.jpg', title: ' 4TH ANNIVERSARY' },
              ],
              specials: [
                { image: 'anh1.jpg', title: ' 4TH ANNIVERSARY' },
                { image: 'anh4.jpg', title: ' | POPPOP COLLAB' },
                { image: 'anh1.jpg', title: ' 4TH ANNIVERSARY' },
                { image: 'anh1.jpg', title: ' 4TH ANNIVERSARY' },
              ]
            }
          },
          methods: {
            toggleSidebar() {
              this.isSidebarVisible = !this.isSidebarVisible;
            }
          }
        });

        app.mount('#app');
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
        <p>Địa chỉ: 104 Nguyễn Văn Trỗi, phường 8, Phú Nhuận, Ho Chi Minh City, Vietnam</p>
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
