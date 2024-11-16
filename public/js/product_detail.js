document.addEventListener('DOMContentLoaded', function() {
    const contentSections = document.querySelectorAll('.content-section');
    
    contentSections.forEach(section => {
      const contentText = section.querySelector('.content-text');
      const toggleBtn = section.querySelector('.toggle-btn');
      
      // Kiểm tra chiều cao thực tế của nội dung
      if (contentText.scrollHeight > section.offsetHeight) {
        section.classList.add('show-toggle'); // Hiển thị nút nếu nội dung vượt quá chiều cao giới hạn
      }
      
      // Sự kiện nhấn nút để ẩn/hiện nội dung
      toggleBtn.addEventListener('click', function() {
        section.classList.toggle('expanded');
        toggleBtn.innerHTML = section.classList.contains('expanded') 
          ? '<i class="fa-solid fa-sort-up"></i>' 
          : '<i class="fa-solid fa-sort-down"></i>';
      });
    });
  });