// Slider logic
document.addEventListener("DOMContentLoaded", function () {
    const productWrapper = document.querySelector('.product-wrapper');
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');
    const totalItems = document.querySelectorAll('.product-wrapper .col-md-3').length;
    const itemsPerPage = 4; // Hiển thị 4 sản phẩm mỗi lần
    let currentIndex = 0;

    // Chỉ hiện nút nếu có nhiều hơn 5 sản phẩm
    if (totalItems <= itemsPerPage) {
        prevButton.style.display = "none";
        nextButton.style.display = "none";
    } else {
        prevButton.style.display = "block";
        nextButton.style.display = "block";
    }

    // Cập nhật slider
    function updateSlider() {
        const offset = -currentIndex * (100 / itemsPerPage);
        productWrapper.style.transform = `translateX(${offset}%)`;
    }

    // Xử lý sự kiện nhấn nút Next
    nextButton.addEventListener('click', () => {
        if (currentIndex < Math.ceil(totalItems / itemsPerPage) - 1) {
            currentIndex++;
            updateSlider();
        }
    });

    // Xử lý sự kiện nhấn nút Prev
    prevButton.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateSlider();
        }
    });

    // Popup cart logic
    const cartPopup = document.getElementById("cart-popup");
    const cartIcon = document.querySelector(".fa-shopping-bag");
    const closeCartPopup = document.getElementById("close-cart-popup");

    // Hiển thị popup khi nhấn vào biểu tượng giỏ hàng
    cartIcon.addEventListener("click", function (event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
        cartPopup.classList.remove("d-none"); // Hiển thị popup
        cartPopup.classList.add("show");
    });

    // Đóng popup khi nhấn vào nút "X"
    closeCartPopup.addEventListener("click", function () {
        cartPopup.classList.remove("show");
        setTimeout(() => {
            cartPopup.classList.add("d-none"); // Ẩn hẳn sau khi hiệu ứng kết thúc
        }, 300); // Thời gian khớp với transition trong CSS
    });

    // Đóng popup khi nhấn ra ngoài
    window.addEventListener("click", function (event) {
        if (event.target === cartPopup) {
            cartPopup.classList.remove("show");
            setTimeout(() => {
                cartPopup.classList.add("d-none");
            }, 300);
        }
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
let currentIndex = 0;
const totalItems = $('.product-card').length;
const itemsPerPage = 4; // Số lượng sản phẩm hiển thị trong một lần

$('#next').click(function() {
    if (currentIndex < totalItems - itemsPerPage) {
        currentIndex++;
        $('.product-wrapper').css('transform', 'translateX(' + (-currentIndex * 100 / itemsPerPage) + '%)');
    }
});

$('#prev').click(function() {
    if (currentIndex > 0) {
        currentIndex--;
        $('.product-wrapper').css('transform', 'translateX(' + (-currentIndex * 100 / itemsPerPage) + '%)');
    }
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