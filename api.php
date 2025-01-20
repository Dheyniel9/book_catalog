<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config.php';
include_once 'Book.php';

$database = new Database();
$db = $database->getConnection();

$book = new Book($db);

$data = json_decode(file_get_contents("php://input"));

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'read':
                $stmt = $book->read();
                $num = $stmt->rowCount();
                if ($num > 0) {
                    $books_arr = array();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        $book_item = array(
                            "id" => $id,
                            "title" => $title,
                            "isbn" => $isbn,
                            "author" => $author,
                            "publisher" => $publisher,
                            "year_published" => $year_published,
                            "category" => $category
                        );
                        array_push($books_arr, $book_item);
                    }
                    $response['status'] = 'success';
                    $response['data'] = $books_arr;
                } else {
                    $response['status'] = 'error';
                    $response['message'] = "No books found.";
                }
                break;

            case 'create':
                $book->title = $_POST['title'];
                $book->isbn = $_POST['isbn'];
                $book->author = $_POST['author'];
                $book->publisher = $_POST['publisher'];
                $book->year_published = $_POST['year_published'];
                $book->category = $_POST['category'];
                if ($book->create()) {
                    $response['status'] = 'success';
                    $response['message'] = "Book was created.";
                } else {
                    $response['status'] = 'error';
                    $response['message'] = "Unable to create book.";
                }
                break;

            case 'update':
                $book->id = $_POST['id'];
                $book->title = $_POST['title'];
                $book->isbn = $_POST['isbn'];
                $book->author = $_POST['author'];
                $book->publisher = $_POST['publisher'];
                $book->year_published = $_POST['year_published'];
                $book->category = $_POST['category'];
                if ($book->update()) {
                    $response['status'] = 'success';
                    $response['message'] = "Book was updated.";
                } else {
                    $response['status'] = 'error';
                    $response['message'] = "Unable to update book.";
                }
                break;

            case 'delete':
                $book->id = $_POST['id'];
                if ($book->delete()) {
                    $response['status'] = 'success';
                    $response['message'] = "Book was deleted.";
                } else {
                    $response['status'] = 'error';
                    $response['message'] = "Unable to delete book.";
                }
                break;

            default:
                $response['status'] = 'error';
                $response['message'] = "Invalid action.";
                break;
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = "No action specified.";
    }
} else {
    $response['status'] = 'error';
    $response['message'] = "Invalid request method.";
}

echo json_encode($response);