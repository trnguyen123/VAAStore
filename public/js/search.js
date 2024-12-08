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