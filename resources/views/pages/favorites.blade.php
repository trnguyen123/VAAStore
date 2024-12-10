<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Favorites</title>
    <link rel="stylesheet" href="{{ asset('public/css/fav.css') }}">
</head>
<body>
    <header>
        <div class="logo">
            <a href="{{ url('/home') }}">
                <img src="{{ asset('public/images/logo.png') }}" alt="Logo" class="logo">
            </a>
        </div>
    </header>

    <div class="container mt-4">
        <h2 class="mb-4">Danh Sách Yêu Thích</h2>
        <div id="favorites-list">
            <!-- Danh sách sản phẩm yêu thích sẽ được hiển thị ở đây -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log("Page loaded, calling fetchFavorites...");
            fetchFavorites();
        });

        function fetchFavorites() {
            console.log("Fetching favorites...");
            const customerId = localStorage.getItem('customer_id');
            console.log("Customer ID:", customerId);
            
            if (!customerId) {
                alert("Vui lòng đăng nhập để xem danh sách yêu thích.");
                return;
            }

            fetch("{{ route('fav.get') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ customer_id: customerId })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Parsed Data:", data);
                if (data.success) {
                    renderFavorites(data.favorites);
                } else {
                    document.getElementById('favorites-list').innerHTML = `<p>${data.message}</p>`;
                }
            })
            .catch(error => {
                console.error("Error fetching favorites:", error);
                document.getElementById('favorites-list').innerHTML = "<p>Không thể tải danh sách yêu thích.</p>";
            });
        }

        // Hàm render danh sách yêu thích
        function renderFavorites(favorites) {
            const BASE_URL = "http://localhost/vaastore";
            const container = document.getElementById('favorites-list');
            if (!favorites || favorites.length === 0) {
                container.innerHTML = "<p>Bạn chưa có sản phẩm nào trong danh sách yêu thích.</p>";
                return;
            }

            const favoriteItems = favorites.map(favorite => {
                // Kiểm tra nếu product có giá trị hợp lệ
                if (!favorite.product) {
                    console.warn("Invalid product:", favorite);  // Log cảnh báo nếu không có product
                    return ''; // Trả về chuỗi rỗng nếu không có sản phẩm hợp lệ
                }

                // Kiểm tra giá có hợp lệ không
                const price = favorite.product.price ? favorite.product.price.toLocaleString('vi-VN') : 'Giá không xác định';
                const imageUrl = `${BASE_URL}/public/${favorite.product.image}`;

                return `
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="${imageUrl}" class="img-fluid rounded-start" alt="${favorite.product.name}">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">${favorite.product.name}</h5>
                                    <p class="card-text">Giá: ${price} VND</p>
                                    <button class="btn btn-danger" onclick="removeFavorite(${favorite.product.product_id})">Xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = favoriteItems.join('');
        }

        // Hàm xóa một sản phẩm khỏi danh sách yêu thích
        async function removeFavorite(productId) {
            const customerId = localStorage.getItem('customer_id');

            if (!customerId) {
                alert("Vui lòng đăng nhập để thực hiện hành động này.");
                return;
            }

            try {
                const response = await fetch("{{ route('fav.del') }}", {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ customer_id: customerId, product_id: productId })
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();
                alert(data.message);
                fetchFavorites(); // Reload danh sách yêu thích
            } catch (error) {
                console.error("Error removing favorite:", error);
                alert("Không thể xóa sản phẩm. Vui lòng thử lại sau.");
            }
        }
    </script>
</body>
</html>
