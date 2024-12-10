document.addEventListener("DOMContentLoaded", function () {
  // Xử lý nút tăng số lượng ngoài sản phẩm
  const increaseButtons = document.querySelectorAll('.increase-btn');
  increaseButtons.forEach(button => {
    button.addEventListener('click', function () {
      const quantityInput = this.closest('.quantity').querySelector('.quantity-main');
      let currentQuantity = parseInt(quantityInput.value) || 1;
      quantityInput.value = currentQuantity + 1;
    });
  });

  // Xử lý nút giảm số lượng ngoài sản phẩm
  const decreaseButtons = document.querySelectorAll('.decrease-btn');
  decreaseButtons.forEach(button => {
    button.addEventListener('click', function () {
      const quantityInput = this.closest('.quantity').querySelector('.quantity-main');
      let currentQuantity = parseInt(quantityInput.value) || 1;
      if (currentQuantity > 1) {
        quantityInput.value = currentQuantity - 1;
      }
    });
  });

  // Xử lý đánh giá sao và bình luận
  const stars = document.querySelectorAll(".star");
  const commentInput = document.getElementById("comment-input");
  const submitComment = document.getElementById("submit-comment");
  const commentsSection = document.getElementById("comments-section");
  let selectedRating = 0;

  // Xử lý chọn sao
  stars.forEach(star => {
    star.addEventListener("click", function () {
      selectedRating = this.getAttribute("data-value");
      stars.forEach(s => s.style.color = "#ccc"); // Reset màu sao
      for (let i = 0; i < selectedRating; i++) {
        stars[i].style.color = "#f39c12";
      }
    });
  });

  submitComment.addEventListener("click", async function () {
    const commentText = commentInput.value.trim();

    if (commentText === "") {
        console.error("Lỗi: Nội dung bình luận trống.");
        alert("Vui lòng nhập bình luận!");
        return;
    }

    const productId = window.location.pathname.split("/").pop();
    const customerId = localStorage.getItem("customer_id");

    if (!customerId) {
        console.error("Lỗi: Không tìm thấy customer_id trong localStorage.");
        alert("Bạn cần đăng nhập để bình luận!");
        return;
    }

    // Kiểm tra selectedRating (đặt mặc định nếu không có)
    const rating = selectedRating || 0;
    if (rating <= 0) {
        alert("Vui lòng chọn sao đánh giá!");
        return;
    }

    try {
      console.log("Dữ liệu chuẩn bị gửi:", {
        product_id: productId,
        customer_id: customerId,
        comment_rating: rating,
        comment_content: commentText,
    });
        const response = await fetch('/vaastore/comments', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            
            body: JSON.stringify({
                product_id: productId,
                customer_id: customerId,
                comment_rating: rating,
                comment_content: commentText,
            }),
            
        });

        if (!response.ok) {
            const errorDetails = await response.text();
            console.error(`Lỗi HTTP: ${response.status}`, errorDetails);
            alert("Đã xảy ra lỗi khi gửi bình luận!");
            return;
        }

        const result = await response.json();
        if (result.success) {
            // Hiển thị bình luận mới
            const comment = result.comment; // Lấy comment từ response
            const customerName = comment.full_name || "Người dùng ẩn danh"; 
            const commentHTML = `
                <div class="comment">
                    <div class="comment-author">${customerName}</div>
                    <div class="comment-text">${comment.comment_content}</div>
                    <div class="comment-rating">Đánh giá: ${"&#9733;".repeat(comment.comment_rating)}</div>
                </div>
            `;
            commentsSection.insertAdjacentHTML('afterbegin', commentHTML);

            // Reset form
            commentInput.value = "";
            selectedRating = 0;
            stars.forEach(star => (star.style.color = "#ccc"));
        } else {
            console.error("Lỗi từ server:", result);
            alert(result.message || "Đã có lỗi xảy ra. Vui lòng thử lại!");
        }
    } catch (error) {
        console.error("Lỗi khi gửi request:", error);
        alert("Đã có lỗi khi kết nối với server. Vui lòng thử lại sau!");
    }
});

async function loadComments(productId) {
  try {
      const response = await fetch(`/vaastore/comments/${productId}`);
      if (!response.ok) {
          console.error(`Lỗi khi tải bình luận: HTTP ${response.status}`);
          return;
      }

      const data = await response.json();

      // Kiểm tra dữ liệu trả về
      if (!data || !Array.isArray(data.comments)) {
          console.error("Dữ liệu bình luận không hợp lệ.");
          commentsSection.innerHTML = `<p>Không thể tải bình luận. Vui lòng thử lại sau.</p>`;
          return;
      }

      // Xóa nội dung mặc định
      commentsSection.innerHTML = "";

      if (data.comments.length === 0) {
          commentsSection.innerHTML = `<p>Chưa có bình luận nào. Hãy là người đầu tiên!</p>`;
          return;
      }

      // Hiển thị bình luận
      data.comments.forEach(comment => {
          const commentHTML = `
              <div class="comment">
                  <div class="comment-author">Người dùng: ${comment.customer?.full_name}</div>
                  <div class="comment-text">${comment.comment_content}</div>
                  <div class="comment-rating">Đánh giá: ${"&#9733;".repeat(comment.comment_rating)}</div>
              </div>
          `;
          commentsSection.insertAdjacentHTML('beforeend', commentHTML);
      });
  } catch (error) {
      console.error("Lỗi khi tải bình luận:", error);
      commentsSection.innerHTML = `<p>Không thể tải bình luận. Vui lòng thử lại sau.</p>`;
  }
}

// Gọi hàm khi trang được tải
const productId = window.location.pathname.split("/").pop();
loadComments(productId);

});
