<?php
class BookManager {

    private $conn;

    public function __construct($db_connection) {
        $this->conn = $db_connection;
    }

    // Retrieve books with optional filters
    public function getBooks($search = "", $category = "") {
        $conditions = [];

        if ($search) {
            $s = $this->conn->real_escape_string($search);
            $conditions[] = "(title LIKE '%$s%' OR author LIKE '%$s%' OR category LIKE '%$s%')";
        }

        if ($category) {
            $c = $this->conn->real_escape_string($category);
            $conditions[] = "category='$c'";
        }

        $where = count($conditions) ? "WHERE ".implode(" AND ", $conditions) : "";

        return $this->conn->query("SELECT * FROM books $where ORDER BY title ASC");
    }

    // Check if user has already borrowed this book and not returned it
    public function userBorrowed($user_id, $book_id) {
        $sql = "
            SELECT id FROM borrow
            WHERE user_id=$user_id AND book_id=$book_id AND status='Borrowed'
        ";
        return $this->conn->query($sql)->num_rows > 0;
    }
}
