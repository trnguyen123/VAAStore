document.addEventListener("DOMContentLoaded", function() {
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
});
