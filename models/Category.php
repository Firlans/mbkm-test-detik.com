<?php
class Category{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getCategories(){
        $sql = 'SELECT * FROM categories';
        $result = $this->conn->query($sql);
        $categories = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        return $categories;
    }
    public function getCategoryByName($category_name){
        $sql = 'SELECT * FROM categories WHERE name = ?';
        $statement = $this->conn->prepare($sql);
        if(!$statement){
            echo $this->conn->error;
            return false;
        }
        $statement->bind_param('s', $category_name);
        $statement->execute();
        $result = $statement->get_result();
        $category = $result->fetch_assoc();
        $statement->close();
        return $category;
    }

    public function createCategory($category_name){
        $sql = 'INSERT INTO categories (name) values (?)';
        $statement = $this->conn->prepare($sql);
        $statement->bind_param('s', $category_name);
        $result = $statement->execute();
        $statement->close();
        return $result;
    }
}