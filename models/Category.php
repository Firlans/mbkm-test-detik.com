<?php
class Category
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getCategories()
    {
        $sql = 'SELECT * FROM categories';
        $result = $this->conn->query($sql);
        if (!$result) {
            if ($this->conn->error === "Table 'perpustakaan_digital.categories' doesn't exist") {
                $this->conn->query("
                    CREATE TABLE
                        categories (
                            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(255) NOT NULL,
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                        );"
                );
            }
            $result = $this->conn->query($sql);
        }
        $categories = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        return $categories;
    }
    public function getCategoryByName($category_name)
    {
        $sql = 'SELECT * FROM categories WHERE category_name = ?';
        $statement = $this->conn->prepare($sql);
        $statement->bind_param('s', $category_name);
        $statement->execute();
        $result = $statement->get_result();
        $category = $result->fetch_assoc();
        $statement->close();
        return $category;
    }

    public function createCategory($category_name)
    {
        $sql = 'INSERT INTO categories (category_name) values (?)';
        $statement = $this->conn->prepare($sql);
        $statement->bind_param('s', $category_name);
        $result = $statement->execute();
        $statement->close();
        return $result;
    }

    public function deleteCategory($id)
    {
        $sql = 'DELETE FROM categories WHERE id = ?';
        $statement = $this->conn->prepare($sql);
        $statement->bind_param('s', $id);
        $result = $statement->execute();
        $statement->close();
        return $result;
    }
}
