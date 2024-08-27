<?php
class Book
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getBookById($id)
    {
        $sql = "SELECT * FROM books WHERE id = ?";
        $statement = $this->conn->prepare($sql);
        $statement->bindParam("s", $id);
        $statement->execute();
        $result = $statement->fetch(MYSQLI_ASSOC);
        $statement->close();
        return $result;
    }

    public function getBooks()
    {
        $sql = 'SELECT * FROM books';
        $result = $this->conn->query($sql);

        if ($result === false) {
            if ($this->conn->error === "Table 'perpustakaan_digital.books' doesn't exist") {
                $this->conn->query("
                CREATE TABLE
                    books (
                        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        title VARCHAR(255) NOT NULL,
                        category_id INT NOT NULL,
                        description VARCHAR(255) NOT NULL,
                        file_path VARCHAR(255) NOT NULL,
                        cover_image_path VARCHAR(255) NOT NULL,
                        user_id INT,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        CONSTRAINT fk_categories FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE ON UPDATE CASCADE,
                        CONSTRAINT fk_users FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE,
                        INDEX idx_category (category_id),
                        INDEX idx_user (user_id)
                    );"
                );
                $result = $this->conn->query($sql);
            }
        }
        $books = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        return $books;
    }

    public function createBook($title, $category_id, $description, $file_path, $cover_image, $user_id)
    {
        $sql = 'INSERT INTO books (title, category_id, description, file_path, cover_image_path, user_id) VALUES (?,?,?,?,?,?)';
        $statement = $this->conn->prepare($sql);
        $statement->bind_param('ssssss', $title, $category_id, $description, $file_path, $cover_image, $user_id);
        $result = $statement->execute();
        $statement->close();
        return $result;
    }

    public function saveBook($book_file, $book_cover)
    {
        $targetDirPDF = 'uploads/files/';
        $targetDirCover = 'uploads/covers/';
        $targetFile = $targetDirPDF . basename($book_file["name"]);
        $targetCover = $targetDirCover . basename($book_cover["name"]);

        // Mendapatkan tipe file (opsional, jika ingin melakukan validasi)
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $coverType = strtolower(pathinfo($targetCover, PATHINFO_EXTENSION));

        if($fileType !== 'pdf'){
            return 'file harus berekstensi pdf';
        }

        if($coverType !== 'jpeg'){
            return 'cover harus berekstensi jpeg';
        }

        // Cek apakah file sudah ada
        if (file_exists($targetFile)) {
            return "Maaf, file sudah ada.";
        } else {
            // Pindahkan file dari temporary ke folder tujuan
            if (move_uploaded_file($book_file["tmp_name"], $targetFile) && move_uploaded_file($book_cover["tmp_name"], $targetCover)) {
                return 'success';
            } else {
                return "Maaf, terjadi kesalahan saat mengunggah file.";
            }
        }
    }
}
