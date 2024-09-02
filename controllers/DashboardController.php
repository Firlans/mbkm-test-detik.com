<?php
require_once 'models/User.php';
require_once 'models/Category.php';
require_once 'models/Book.php';
require_once 'models/Borrowed.php';

class DashboardController
{
    private $conn;
    private $userModel;
    private $categoryModel;
    private $bookModel;

    private $borrowedModel;
    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->userModel = new User($conn);
        $this->categoryModel = new Category($conn);
        $this->bookModel = new Book($conn);
        $this->borrowedModel = new Borrowed($conn);
    }

    public function is_admin($userId)
    {
        $user = $this->userModel->getUserById($userId);
        return $user['role'] === 'admin';
    }

    public function getUser($userId)
    {
        $user = $this->userModel->getUserById($userId);
        if(!$user){
            return "user tidak ditemukan";
        }
        return $user;
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
            return 'semua field wajib diisi';
        }

        $this->saveFile($file, "files");
        $this->saveFile($cover_image, "covers");

        $file_path = 'uploads/files/' . $file['name'];
        $cover_path = 'uploads/covers/' . $cover_image['name'];

        if (!$this->bookModel->createBook($title, $category_id, $description, $file_path, $cover_path, $user_id)) {
            return 'terjadi kesalahan, silahkan coba lagi nanti';
        }
        return 'success';
    }

    public function addUser($email, $username, $password, $role)
    {
        if (!$email || !$username || !$password || !$role) {
            return 'semua field wajib diisi';
        }

        $isDuplicate = $this->userModel->getUserByEmail($email);

        if ($isDuplicate) {
            return 'email sudah terdaftar, harap gunakan email yang lain';
        }

        $isSaved = $this->userModel->createUser($username, $email, $password, $role);
        if (!$isSaved) {
            return 'terjadi kesalahan, silakan coba lagi';
        }

        return 'success';
    }

    public function deleteCategory($id)
    {
        if (!$id) {
            return 'semua field wajib terisi';
        }

        $isAvailableCategory = $this->categoryModel->getCategoryById($id);
        if (!$isAvailableCategory) {
            return 'category tidak tersedia';
        }

        $isDeleted = $this->categoryModel->deleteCategory($id);
        if (!$isDeleted) {
            return 'terjadi kesalahan silakan coba lagi';
        }

        return 'success';
    }

    public function deleteBook($id)
    {
        if (!$id) {
            return 'semua field wajib terisi';
        }

        $isAvailableBook = $this->bookModel->getBookById($id);
        if (!$isAvailableBook) {
            return 'buku tidak tersedia';
        }

        $fileDeleted = $this->deleteFile($isAvailableBook['file_path']);
        $imageDeleted = $this->deleteFile($isAvailableBook['cover_image_path']);
        if ($fileDeleted !== 'success' || $imageDeleted !== 'success') {
            return "$fileDeleted dan $imageDeleted";
        }

        $isDeleted = $this->bookModel->deleteBook($id);
        if (!$isDeleted) {
            return 'gagal menghapus terjadi kesalahan harap coba lagi';
        }


        return 'success';
    }

    public function deleteUser($id)
    {
        if (!$id) {
            return 'semua field wajib terisi';
        }

        $isAvailableUser = $this->userModel->getUserById($id);
        if (!$isAvailableUser) {
            return 'category tidak tersedia';
        }
        $isDeleted = $this->userModel->deleteUser($id);
        if (!$isDeleted) {
            return 'terjadi kesalahn harap coba lagi';
        }

        return 'success';
    }

    public function editCategory($id, $category_name)
    {

        if (!$category_name || !$id) {
            return 'semua field wajib diisi';
        }

        $isValidCategory = $this->categoryModel->getCategoryById($id);
        if (!$isValidCategory) {
            return 'category tidak ditemukan';
        }

        if ($isValidCategory['name'] === $category_name) {
            return 'tidak ada perubahan';
        }

        if ($this->categoryModel->getCategoryByName($category_name)) {
            return 'category sudah pernah dibuat';
        }


        $isUpdated = $this->categoryModel->updateCategory($id, $category_name);
        if (!$isUpdated) {
            return 'gagal mengupdate silakan coba lagi';
        }

        return 'success';
    }

    public function editUser($id, $email, $username, $password, $role)
    {
        if (!$id || !$email || !$username || !$password || !$role) {
            return 'semua field wajib diisi';
        }

        $isValidUser = $this->userModel->getUserById($id);
        if (!$isValidUser) {
            return 'user tidak ditemukan';
        }

        if (
            $isValidUser['email'] === $email &&
            $isValidUser['username'] === $username &&
            $isValidUser['password'] === $password &&
            $isValidUser['role'] === $role
        ) {
            return 'tidak terdapat perubahan';
        }

        $isUpdated = $this->userModel->updateUser($id, $username, $email, $password, $role);
        if (!$isUpdated) {
            return 'gagal mengubah data coba lagi nanti';
        }

        return 'success';
    }

    public function editBook($id, $title, $category_id, $description, $file, $cover_image, $keep_file, $keep_cover, $user_id)
    {
        if (!$id || !$title || !$category_id || !$description || !$user_id) {
            return 'semua field wajib di isi';
        }
        $isValidBook = $this->bookModel->getBookById($id);
        if (!$isValidBook) {
            return 'buku tidak ditemukan';
        }

        $file_path = $isValidBook['file_path'];
        $cover_image_path = $isValidBook['cover_image_path'];

        $file_changed = false;
        $cover_changed = false;

        if (!$keep_file && $file && $file['error'] == 0) {
            $save_result = $this->saveFile($file, 'files');
            if ($save_result !== 'success') {
                return $save_result;
            }
            $file_path = 'uploads/files/' . $file['name'];
            $file_changed = true;
        }

        if (!$keep_cover && $cover_image && $cover_image['error'] == 0) {
            $save_result = $this->saveFile($cover_image, 'covers');
            if ($save_result !== 'success') {
                return $save_result;
            }
            $cover_image_path = 'uploads/covers/' . $cover_image['name'];
            $cover_changed = true;
        }

        if (
            $isValidBook['title'] === $title &&
            $isValidBook['category_id'] == $category_id &&
            $isValidBook['description'] === $description &&
            !$file_changed && !$cover_changed
        ) {
            return 'tidak ada perubahan';
        }

        $isUpdated = $this->bookModel->updateBook($id, $title, $category_id, $description, $file_path, $cover_image_path, $user_id);
        if (!$isUpdated) {
            return 'gagal mengubah, harap coba lagi nanti';
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

    public function borrowedList($user_id)
    {
        $borrowed = $this->borrowedModel->getBorrows($user_id);
        return $borrowed;
    }

    public function borrowBook($user_id, $book_id)
    {
        if (!$user_id || !$book_id) {
            return "semua field wajib di isi";
        }

        $due = $this->timestamp();

        $isAvailableBorrowed = $this->borrowedModel->getBorrowedByBookId($book_id);
        if ($isAvailableBorrowed) {
            return "buku telah ada di list pinjaman";
        }

        $isSaved = $this->borrowedModel->addBorrowed($user_id, $book_id, $due);
        if (!$isSaved) {
            return "gagal menambahkan buku";
        }
        return "success";
    }

    public function returnBook($borrowed_id)
    {
        if (!$borrowed_id) {
            return "id wajib disertakan";
        }

        $isAvailableBorrowed = $this->borrowedModel->getBorrowedById($borrowed_id);
        if (!$isAvailableBorrowed) {
            return "buku tidak tersedia di list pinjaman";
        }
        $returnTime = $this->timestamp();
        $isUpdated = $this->borrowedModel->updateStatus($borrowed_id, $returnTime, "returned");
        if (!$isUpdated) {
            return "gagal mengupdate data coba lagi nanti";
        }

        return "success";
    }

    public function saveFile($file, $type)
    {
        $targetDir = 'uploads/' . $type . '/';
        $targetFile = $targetDir . basename($file["name"]);
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if ($type === 'files' && $fileType !== 'pdf') {
            return 'file harus berekstensi pdf';
        }
        if ($type === 'covers' && !in_array($fileType, ['jpeg', 'jpg', 'png'])) {
            return 'cover harus berekstensi jpeg, jpg, atau png';
        }

        if (file_exists($targetFile)) {
            return "Maaf, file sudah ada.";
        }

        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return 'success';
        } else {
            return "Maaf, terjadi kesalahan saat mengunggah file.";
        }
    }

    private function deleteFile($filePath)
    {
        $fullPath = dirname(__DIR__) . '/' . $filePath;
        if (file_exists($fullPath)) {
            if (unlink($fullPath)) {
                return "success";
            } else {
                return "Gagal menghapus file.";
            }
        } else {
            return "File tidak ditemukan.";
        }
    }

    private function timestamp()
    {
        $currentDateTime = new DateTime();
        $currentDateTime->modify('+7 days');
        return $currentDateTime->format('Y-m-d H:i:s');
    }
}