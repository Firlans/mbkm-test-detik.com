document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("search-books");
  const bookItems = document.querySelectorAll(".book-item");

  searchInput.addEventListener("input", function () {
    const searchTerm = this.value.toLowerCase().trim();
    bookItems.forEach(function (book) {
      const searchData = book.getAttribute("data-search");
      if (searchData.includes(searchTerm)) {
        book.style.display = "block";
      } else {
        book.style.display = "none";
      }
    });
  });
});
