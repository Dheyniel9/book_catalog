$(document).ready(function () {
  loadBooks();
});

function loadBooks() {
  $.ajax({
    url: "api.php",
    type: "POST",
    data: { action: "read" },
    dataType: "json",
    success: function (response) {
      if (response.status === "success") {
        let books = response.data;
        let bookList = "";
        books.forEach(function (book) {
          bookList += `
                      <tr>
                          <td>${book.title}</td>
                          <td>${book.isbn}</td>
                          <td>${book.author}</td>
                          <td>${book.publisher}</td>
                          <td>${book.year_published}</td>
                          <td>${book.category}</td>
                          <td>
                              <button class="btn btn-sm btn-primary" onclick="editBook(${book.id})">Edit</button>
                              <button class="btn btn-sm btn-danger" onclick="deleteBook(${book.id})">Delete</button>
                          </td>
                      </tr>
                  `;
        });
        $("#bookList").html(bookList);
      } else {
        alert(response.message);
      }
    },
    error: function () {
      alert("Error loading books");
    },
  });
}

function saveBook() {
  let id = $("#bookId").val();
  let action = id ? "update" : "create";
  let data = {
    action: action,
    id: id,
    title: $("#title").val(),
    isbn: $("#isbn").val(),
    author: $("#author").val(),
    publisher: $("#publisher").val(),
    year_published: $("#year").val(),
    category: $("#category").val(),
  };

  $.ajax({
    url: "api.php",
    type: "POST",
    data: data,
    dataType: "json",
    success: function (response) {
      if (response.status === "success") {
        $("#bookModal").modal("hide");
        loadBooks();
        resetForm();
      } else {
        alert(response.message);
      }
    },
    error: function () {
      alert("Error saving book");
    },
  });
}

function editBook(id) {
  $.ajax({
    url: "api.php",
    type: "POST",
    data: { action: "read", id: id },
    dataType: "json",
    success: function (response) {
      if (response.status === "success") {
        let book = response.data[0];
        $("#bookId").val(book.id);
        $("#title").val(book.title);
        $("#isbn").val(book.isbn);
        $("#author").val(book.author);
        $("#publisher").val(book.publisher);
        $("#year").val(book.year_published);
        $("#category").val(book.category);
        $("#bookModal").modal("show");
      } else {
        alert(response.message);
      }
    },
    error: function () {
      alert("Error loading book details");
    },
  });
}

function deleteBook(id) {
  if (confirm("Are you sure you want to delete this book?")) {
    $.ajax({
      url: "api.php",
      type: "POST",
      data: { action: "delete", id: id },
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          loadBooks();
        } else {
          alert(response.message);
        }
      },
      error: function () {
        alert("Error deleting book");
      },
    });
  }
}

function resetForm() {
  $("#bookId").val("");
  $("#bookForm")[0].reset();
}
