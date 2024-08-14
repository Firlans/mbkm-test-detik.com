<?php
class Book{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getBooks(){
        $sql = 'SELECT * FROM books';
        $result = $this->conn->query($sql);
        $books = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        return $books;
    }

    public function createBook($title, $category_id, $description, $file_path, $cover_image, $user_id){
        $sql = 'INSERT INTO books (title, category_id, description, file_path, cover_image, user_id) VALUES (?,?,?,?,?,?)';
        $statement = $this->conn->prepare($sql);
        $statement->bind_param('ssssss', $title, $category_id, $description, $file_path, $cover_image, $user_id);
        $result = $statement->execute;
        $statement->close();
        return $result;
    }


}
