$(document).ready(function () {
    // Xử lý sự kiện khi nhấn nút thêm vào giỏ hàng
    $('.add-to-cart-btn').on('click', function (e) {
        e.preventDefault();

        var product_id = $(this).data('product-id'); // Lấy ID sản phẩm từ thuộc tính data

        $.ajax({
            url: routes.addToCart, // Sử dụng route được truyền từ Blade
            method: 'POST',
            data: {
                _token: csrfToken, // Sử dụng token CSRF được truyền từ Blade
                product_id: product_id
            },
            success: function (response) {
                if (response.status === 'success') {
                    $('#cart-count').text(response.cart_count);
                    updateCartPopup(response.cart_items);
                    var toast = new bootstrap.Toast(document.getElementById('add-to-cart-toast'));
                    toast.show();
                } else {
                    alert('Lỗi khi thêm sản phẩm vào giỏ hàng.');
                }
            },
            error: function () {
                alert('Đã xảy ra lỗi. Vui lòng thử lại.');
            }
        });
    });

    // Hàm để cập nhật nội dung của popup giỏ hàng
    function updateCartPopup(cartItems) {
        var cartContent = '<h3>Chúc bạn có một ngày tốt lành!!!</h3><ul>';
        let totalQuantity = 0;  // Biến này dùng để tính tổng số lượng
        let totalPrice = 0;
    
        if (cartItems.length > 0) {
            cartItems.forEach(function (item) {
                const quantity = parseInt(item.quantity);
                const price = parseFloat(item.price);
    
                // Kiểm tra số lượng và giá trị hợp lệ
                if (isNaN(quantity) || quantity <= 0) {
                    console.warn('Số lượng không hợp lệ:', item);
                    return; // Bỏ qua nếu số lượng không hợp lệ
                }
    
                if (isNaN(price) || price <= 0) {
                    console.warn('Giá không hợp lệ:', item);
                    return; // Bỏ qua nếu giá không hợp lệ
                }
    
                // Cập nhật nội dung giỏ hàng
                cartContent += `
                    <li>
                        <img src="${item.image}" alt="${item.name}" style="width:50px; height:50px; margin-right:10px;">
                        <span>${item.name}</span> - 
                        <span>${price.toLocaleString()}₫</span> x 
                        <input type="number" value="${quantity}" min="1" 
                               data-product-id="${item.product_id}" 
                               class="quantity-input" 
                               style="width: 50px; margin-right: 10px;">
                        <button class="btn btn-danger remove-item" 
                                data-product-id="${item.product_id}">Xóa</button>
                    </li>
                `;
                totalQuantity += quantity;  // Cộng số lượng vào tổng số lượng
                totalPrice += price * quantity;  // Tính tổng giá
            });
            cartContent += '</ul>';
        } else {
            cartContent += '<p>Hiện tại chưa có sản phẩm nào.</p>';
        }
    
        // Cập nhật nội dung popup giỏ hàng
        $('.cart-popup-body').html(cartContent);
    
        // Cập nhật tổng số lượng và tổng giá
        $('#total-quantity').text(totalQuantity);  // Tổng số lượng
        $('#total-price').text(totalPrice.toLocaleString() + '₫');  // Tổng giá
    }
    

    // Xử lý sự kiện xóa sản phẩm khỏi giỏ hàng
    $(document).on('click', '.remove-item', function () {
        const productId = $(this).data('product-id');

        $.ajax({
            url: routes.removeFromCart,
            method: 'POST',
            data: {
                _token: csrfToken,
                product_id: productId
            },
            success: function (response) {
                if (response.status === 'success') {
                    $('#cart-count').text(response.cart_count);
                    updateCartPopup(response.cart_items);
                } else {
                    alert('Lỗi khi xóa sản phẩm khỏi giỏ hàng.');
                }
            },
            error: function () {
                alert('Đã xảy ra lỗi. Vui lòng thử lại.');
            }
        });
    });

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    $(document).on('change', '.quantity-input', function () {
        const productId = $(this).data('product-id');
        const quantity = $(this).val();

        if (quantity <= 0 || isNaN(quantity)) {
            alert('Số lượng không hợp lệ!');
            $(this).val(1);  // Đặt lại giá trị mặc định nếu số lượng không hợp lệ
            return;
        }

        $.ajax({
            url: routes.updateCartQuantity, // Đường dẫn API đã được truyền từ Blade
            method: 'POST',
            data: {
                _token: csrfToken,
                product_id: productId,
                quantity: quantity
            },
            success: function (response) {
                if (response.status === 'success') {
                    $('#cart-count').text(response.cart_count);
                    updateCartPopup(response.cart_items);
                } else {
                    alert('Lỗi khi cập nhật số lượng sản phẩm.');
                }
            },
            error: function () {
                alert('Đã xảy ra lỗi. Vui lòng thử lại.');
            }
        });
    });

    // Hiển thị popup giỏ hàng khi nhấn vào icon giỏ hàng
    $('#cart-icon').on('click', function () {
        const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
        cartModal.show();
    });
});
