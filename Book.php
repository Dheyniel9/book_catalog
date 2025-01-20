<?php
class Book {
    private $conn;
    private $table_name = "books";

    public $id;
    public $title;
    public $isbn;
    public $author;
    public $publisher;
    public $year_published;
    public $category;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET title=:title, isbn=:isbn, author=:author, publisher=:publisher, year_published=:year_published, category=:category";
        $stmt = $this->conn->prepare($query);

        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->isbn=htmlspecialchars(strip_tags($this->isbn));
        $this->author=htmlspecialchars(strip_tags($this->author));
        $this->publisher=htmlspecialchars(strip_tags($this->publisher));
        $this->year_published=htmlspecialchars(strip_tags($this->year_published));
        $this->category=htmlspecialchars(strip_tags($this->category));

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":isbn", $this->isbn);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":publisher", $this->publisher);
        $stmt->bindParam(":year_published", $this->year_published);
        $stmt->bindParam(":category", $this->category);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET title=:title, isbn=:isbn, author=:author, publisher=:publisher, year_published=:year_published, category=:category WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->isbn=htmlspecialchars(strip_tags($this->isbn));
        $this->author=htmlspecialchars(strip_tags($this->author));
        $this->publisher=htmlspecialchars(strip_tags($this->publisher));
        $this->year_published=htmlspecialchars(strip_tags($this->year_published));
        $this->category=htmlspecialchars(strip_tags($this->category));
        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":isbn", $this->isbn);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":publisher", $this->publisher);
        $stmt->bindParam(":year_published", $this->year_published);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}