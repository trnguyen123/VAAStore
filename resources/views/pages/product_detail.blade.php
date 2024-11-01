<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail Page</title>
    <link rel="stylesheet" href="{{ asset('css/product_Detail.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

        <div class="menu">
            <ul>
                @foreach($categories as $category)
                    <li>
                        <a href="{{ url('category/' . $category->category_id) }}">
                            {{ $category->category_name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <main>
            <p>HELLO</p>
        </main>

        <footer class="footer" id="footer">
            <div class="footer-container">
                <div class="footer-section about">
                    <h4>About</h4>
                    <p><a href="#">About us</a></p>
                    <p><a href="#">We're hiring</a></p>
                    <p><a href="#">Support</a></p>
                    <p><a href="#">Find store</a></p>
                    <p><a href="#">Shipment</a></p>
                    <p><a href="#">Payment</a></p>
                    <p><a href="#">Gift card</a></p>
                    <p><a href="#">Return</a></p>
                    <p><a href="#">Help</a></p>
                </div>
                <div class="footer-section store-info">
                    <h4>Store</h4>
                    <p><i class="fa fa-map-marker"></i> VAA Store</p>
                    <p><i class="fa fa-phone"></i> 0123456789</p>
                    <p><i class="fa fa-envelope"></i> hahahaha@mail.com</p>
                    <h4>We accept</h4>
                    <p><i class="fa-brands fa-cc-amex"></i> Amex</p>
                    <p><i class="fa-solid fa-credit-card"></i> Credit Card</p>
                    <div class="social-icons">
                        <i class="fa-brands fa-facebook"></i>
                        <i class="fa-brands fa-instagram"></i>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
</body>
</html>
