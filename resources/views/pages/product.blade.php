<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop VaaT7</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="resource/css/style.css">
  
</head>
<body>
  <div id="app">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">{{ shopName }}</a>
      </div>
    </nav>

    <div class="header-wrapper color-background-1 gradient header-wrapper--border-bottom">
      <div class="search-icon">
        <i class="fas fa-search"></i>
      </div>
      <div class="cart-icon">
        <i class="fas fa-shopping-cart"></i>
      </div>
      <div class="profile-icon">
        <i class="fas fa-user"></i>
      </div>
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
              <button class="btn btn-primary">Thêm vào giỏ hàng</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/vue@3.2.46/dist/vue.global.prod.js"></script>
  <script>
    const app = Vue.createApp({
      data() {
        return {
          shopName: 'STeam7',
          images: [
            '/images/1.jpg',
            'image2.jpg',
            'image3.jpg'
          ],
          products: [
            { id: 1, name: 'Áo thun', description: 'Áo thun cotton cao cấp', image: '/images/1.jpg' },
            { id: 2, name: 'Áo thun', description: 'Áo thun cotton cao cấp', image: 'product1.jpg' },
            { id: 3, name: 'Áo thun', description: 'Áo thun cotton cao cấp', image: 'product1.jpg' },
            { id: 4, name: 'Áo thun', description: 'Áo thun cotton cao cấp', image: 'product1.jpg' },
            // ... thêm các sản phẩm khác
          ]
        }
      }
    });

    app.mount('#app');
  </script>
</body>
</html>