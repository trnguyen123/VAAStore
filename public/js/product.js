$(document).ready(function(){
    // Lấy tiêu đề đã lưu từ sessionStorage nếu có
    var savedCategoryName = sessionStorage.getItem("categoryName");

    if (savedCategoryName && window.location.search.indexOf('category') === -1) {
        $("h2.mb-4").text(savedCategoryName);  // Cập nhật tiêu đề từ sessionStorage
    }

    // Lắng nghe sự kiện khi nhấn vào một mục trong menu
    $(".nav-link").on("click", function(e) {
        e.preventDefault();  // Ngăn chặn việc làm mới trang khi nhấn vào menu

        // Lấy tên danh mục từ thuộc tính data-category-name
        var categoryName = $(this).data("category-name");

        // Lưu tiêu đề vào sessionStorage
        sessionStorage.setItem("categoryName", categoryName);

        // Điều hướng đến trang sản phẩm của danh mục đã chọn với tên danh mục trong query string
        window.location.href = $(this).attr('href') + '?category=' + encodeURIComponent(categoryName);
    });

    // Kiểm tra query string để cập nhật tiêu đề danh mục
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('category')) {
        const categoryNameFromURL = urlParams.get('category');
        $("h2.mb-4").text(categoryNameFromURL);  // Cập nhật tiêu đề từ query string
        sessionStorage.setItem("categoryName", categoryNameFromURL);  // Cập nhật lại trong sessionStorage
    }
});

$(document).ready(function(){
    // Xóa dữ liệu tiêu đề đã lưu trong sessionStorage khi tải lại trang danh sách sản phẩm
    sessionStorage.removeItem("categoryName");
});

//Lưu tên danh mục vào sessionStorage: Khi người dùng nhấn vào một mục trong menu, tên danh mục (categoryName) sẽ được lưu vào sessionStorage.
//Kiểm tra sessionStorage khi trang tải lại: Mỗi khi trang tải lại, kiểm tra xem có tên danh mục nào đã được lưu trong sessionStorage. Nếu có, tiêu đề sẽ được cập nhật với giá trị đó.

$(document).ready(function() {
    $('.favorite-btn').click(function() {
        const productId = $(this).data('product-id');
        const icon = $(this).find('i');

        $.ajax({
            url: "{{ route('products.toggleFavorite') }}",
            type: "POST",
            data: {
                product_id: productId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.is_favorited) {
                    icon.addClass('favorited');
                } else {
                    icon.removeClass('favorited');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert("Failed to toggle favorite. Please try again.");
            }
        });
    });
});