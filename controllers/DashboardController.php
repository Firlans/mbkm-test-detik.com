<?php
require_once 'models/User.php';
require_once 'models/Category.php';
require_once 'models/Book.php';

class DashboardController
{
    private $conn;
    private $userModel;
    private $categoryModel;
    private $bookModel;
    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->userModel = new User($conn);
        $this->categoryModel = new Category($conn);
        $this->bookModel = new Book($conn);
    }

    public function is_admin($userId)
    {
        $user = $this->userModel->getUserById($userId);
        return $user['role'] === 'admin';
    }

    public function addCategory($category_name)
    {
        if (!$category_name) {
            return 'harap masukkan nama category';
        }

        if ($this->categoryModel->getCategoryByName($category_name)) {
            return 'category sudah pernah dibuat';
        }

        $result = $this->categoryModel->createCategory($category_name);
        if (!$result) {
            return 'terjadi kesalahan, silakan coba lagi';
        }

        return 'success';
    }

    public function addBook($title, $category_id, $description, $file, $cover_image, $user_id)
    {
        if (!$title || !$category_id || !$description || !$file || !$cover_image || !$user_id) {
            return 'semua field wajib di isi';
        }

        $target_dir_file = "uploads/file/";
        $target_dir_image = "uploads/images/";
        $target_file = $target_dir_file . basename($file["name"]);
        $target_image = $target_dir_image . basename($cover_image["name"]);
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $imageType = strtolower(pathinfo($target_image, PATHINFO_EXTENSION));

        // Cek apakah file sudah ada
        if (file_exists($target_file) || file_exists($target_image)) {
            return "Maaf, file sudah ada.";
        }

        // Batasi ukuran file (contoh: 5MB)
        if ($file["size"] > 5000000 || $cover_image['size'] > 10000000) {
            return "Maaf, file Anda terlalu besar.";
        }

        // Izinkan format file tertentu
        $allowed_types_file = array("pdf", "doc", "docx", "xls", "xlsx");
        $allowed_types_cover_image = array("jpg", "jpeg", "png");
        if (!in_array($fileType, $allowed_types_file)) {
            return "Maaf, hanya file PDF, DOC, DOCX, XLS, dan XLSX untuk file yang diizinkan.";
        }

        if (!in_array($imageType, $allowed_types_cover_image)) {
            return 'Maaf, hanya gambar JPG, JPEG, PNG untuk cover yang diizinkan.';
        }

        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            return "Maaf, terjadi error saat mengupload file Anda.";
        }
        
        if(!move_uploaded_file($cover_image["tmp_name"], $target_image)){
            return "Maaf, terjadi error saat mengupload cover Anda.";
        }

        $file_path = $target_file;
        $cover_image_path = $target_image;

        $created = $this->bookModel->createBook($title, $category_id, $description, $file_path, $cover_image_path, $user_id);
        if (!$created) {
            return $created;
        }
        return 'success';
    }

    public function addUser($username, $email, $password, $role)
    {
        if (!$username || !$email || !$password || !$role) {
            return 'semua field wajib di isi';
        }
        $user = $this->userModel->getUserByEmail($email);

        if ($user) {
            return 'email sudah terdaftar';
        }

        $created = $this->userModel->createUser($username, $email, $password, $role);

        if (!$created) {
            return 'terjadi kesalahan, silakan coba lagi';
        }

        return 'success';
    }

    public function deleteUser($id)
    {
        if (!$id) {
            return 'gagal menghapus, harap masukkan id';
        }

        $deleted = $this->userModel->deleteUser($id);
        if (!$deleted) {
            return 'terjadi kesalahan, silakan coba lagi';
        }

        return 'success';
    }
    public function deleteBook($id)
    {
        if (!$id) {
            return 'gagal menghapus, harap masukkan id';
        }
        $book = $this->bookModel->getBookByid($id);
        if(!$book){
            return 'buku tidak ditemukan';
        }
        if( !file_exists($book['file_path']) || !file_exists($book['cover_image'])){
            return 'file atau gambar tidak tersedia';
        }
        
        $file_deleted = unlink($book['file_path']);
        $cover_deleted = unlink($book['cover_image']);
        
        if(!$file_deleted){
            return 'file gagal di hapus, silakan coba lagi';
        }
        if(!$cover_deleted){
            return 'cover gagal di hapus, silakan coba lagi';
        }

        $deleted = $this->bookModel->deleteBook($id);
        if (!$deleted) {
            return 'terjadi kesalahan, silakan coba lagi';
        }

        return 'success';
    }

    public function deleteCategory($id)
    {
        if (!$id) {
            return 'gagal menghapus, harap masukkan id';
        }

        $deleted = $this->categoryModel->deleteCategory($id);
        if (!$deleted) {
            return 'terjadi kesalahan, silakan coba lagi';
        }

        return 'success';
    }

    public function usersList()
    {
        $users = $this->userModel->getUsers();
        return $users;
    }

    public function categoriesList()
    {
        $categories = $this->categoryModel->getCategories();
        return $categories;
    }

    public function booksList()
    {
        $books = $this->bookModel->getBooks();
        return $books;
    }
}
