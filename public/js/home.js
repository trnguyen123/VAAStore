// Slider logic
document.addEventListener("DOMContentLoaded", function () {
    const sliders = document.querySelectorAll('.product-slider');

    sliders.forEach(slider => {
        const wrapper = slider.querySelector('.product-wrapper');
        const items = wrapper.querySelectorAll('.col-md-3');
        const prev = slider.querySelector('.prev');
        const next = slider.querySelector('.next');
        const itemsPerPage = 5;
        const totalItems = items.length;
        let currentIndex = 0;

        // Tính kích thước wrapper
        const itemWidth = 100 / itemsPerPage;
        wrapper.style.width = `${itemWidth * totalItems}%`;
        items.forEach(item => {
            item.style.flex = `0 0 ${itemWidth}%`;
            item.style.maxWidth = `${itemWidth}%`;
        });

        // Hàm cập nhật slider
        function updateSlider() {
            const offset = -currentIndex * (100 / itemsPerPage);
            wrapper.style.transform = `translateX(${offset}%)`;
        }

        // Sự kiện cho nút "Next"
        next.addEventListener('click', () => {
            if (currentIndex < Math.ceil(totalItems / itemsPerPage) - 1) {
                currentIndex++;
                updateSlider();
            }
        });

        // Sự kiện cho nút "Prev"
        prev.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateSlider();
            }
        });

        // Ẩn nút nếu không đủ sản phẩm
        if (totalItems <= itemsPerPage) {
            prev.style.display = 'none';
            next.style.display = 'none';
        }

        // Khởi động slider
        updateSlider();
    });
});



cartIcon.addEventListener("click", function (event) {
    event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
    console.log("Giỏ hàng được nhấn");
    cartPopup.classList.remove("d-none"); // Hiển thị popup
    cartPopup.classList.add("show");
});
document.addEventListener("DOMContentLoaded", function () {
    const cartIcon = document.querySelector('#cart-icon');
    const cartPopup = document.querySelector('#cart-popup');
    const closeCartPopup = document.querySelector('#close-cart-popup');
    const cartContent = document.querySelector('.cart-popup-content');
    const cartItems = []; // Danh sách sản phẩm trong giỏ hàng (có thể thay thế bằng dữ liệu từ server).

    // Hàm để hiển thị popup
    function showCartPopup() {
        if (cartItems.length > 0) {
            cartContent.innerHTML = `
                <h3>Giỏ hàng của bạn</h3>
                <ul>
                    ${cartItems.map(item => `
                        <li>
                            <img src="${item.image}" alt="${item.name}" style="width:50px; height:50px; margin-right:10px;">
                            <span>${item.name}</span> - 
                            <span>${item.price.toLocaleString()}₫</span>
                        </li>
                    `).join('')}
                </ul>
                <button class="btn btn-dark">Xem giỏ hàng chi tiết</button>
            `;
        } else {
            cartContent.innerHTML = `
                <h3>Giỏ hàng của bạn</h3>
                <p>Hiện tại chưa có sản phẩm nào.</p>
                <button class="btn btn-secondary">Tiếp tục mua sắm</button>
            `;
        }
        cartPopup.classList.add('show');
    }

    // Đóng popup
    function closeCart() {
        cartPopup.classList.remove('show');
    }

    // Xử lý sự kiện khi nhấn vào icon giỏ hàng
    cartIcon.addEventListener('click', function (e) {
        e.preventDefault(); // Ngăn điều hướng mặc định
        showCartPopup();
    });

    // Xử lý sự kiện khi nhấn vào nút đóng popup
    closeCartPopup.addEventListener('click', closeCart);

    // Đóng popup khi nhấn bên ngoài
    document.addEventListener('click', function (e) {
        if (!cartPopup.contains(e.target) && !cartIcon.contains(e.target)) {
            closeCart();
        }
    });
});
$(document).ready(function() {
    $('#cart-icon').click(function() {
        $('#cart-popup').toggleClass('show'); // Toggle class để hiển thị/ẩn popup
    });

    $('#close-cart-popup').click(function() {
        $('#cart-popup').removeClass('show'); // Đóng popup khi nhấn nút đóng
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const searchButton = document.getElementById("search-button");
    const searchInput = document.getElementById("search-input");

    searchButton.addEventListener("click", function () {
        const query = searchInput.value.trim();
        console.log("Searching for:", query); // Thêm dòng này để kiểm tra
        if (query) {
            window.location.href = `/search?query=${encodeURIComponent(query)}`;
        }
    });
    searchInput.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            searchButton.click(); // Gọi sự kiện click của nút tìm kiếm
        }
    });
});