<?php
session_start();
require_once 'config/database.php';

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = explode('/', trim($request, '/'));

switch ($parts[0]) {
    case '':
        require __DIR__ . '/views/home.php';
        break;
    case 'login':
        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
        }
        require __DIR__ . '/controllers/LoginController.php';
        $login = new LoginController($conn);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $is_login = $login->login($_POST['email'], $_POST['password']);
            if ($is_login !== 'success') {
                $message = $is_login;
            } else {
                header(('Location: /dashboard'));
            }
        }
        require __DIR__ . '/views/login.php';
        break;
    case 'register':
        require __DIR__ . '/controllers/RegisterController.php';
        $register = new RegisterController($conn);
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $result = $register->register($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm_password']);
            $message = $result === 'sukses' ?  'registrasi berhasil, silakan login' : $result;
        }
        require __DIR__ . '/views/register.php';
        break;
    case 'dashboard':
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        require __DIR__ . '/controllers/DashboardController.php';
        $dashboard = new DashboardController($conn);
        $is_admin = $dashboard->is_admin($_SESSION['user_id']);
        $dashboard_page = $is_admin ? 'admin_dashboard.php' : 'user_dashboard.php';
        $users = $dashboard->usersList();
        $categories = $dashboard->categoriesList();
        $books = $dashboard->booksList();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['book_title'])) {
                $result = $dashboard->addBook($_POST['book_title'], $_POST['book_category'], $_POST['book_description'], $_FILES['book_file'], $_FILES['book_cover'], $_SESSION['user_id']);
                if ($result === 'success') {
                    $message = 'berhasil di tambahkan';
                    $books = $dashboard->booksList();
                } else {
                    $error = $result;
                }
            }
            if (isset($_POST['category_name'])) {
                $result = $dashboard->addCategory($_POST['category_name']);
                if ($result === 'success') {
                    $message = 'category berhasil ditambahkan ';
                    $categories = $dashboard->categoriesList();
                } else {
                    $error = $result;
                }
            }
            if (isset($_POST['user_name'])) {
                $result = $dashboard->addUser($_POST['user_name'], $_POST['user_email'], $_POST['user_password'], $_POST['user_role']);
                if ($result === 'success') {
                    $message = 'user berhasil ditambahkan ';
                    $users = $dashboard->usersList();
                } else {
                    $error = $result;
                }
            }

            if (isset($_POST['delete_user_id'])){
                $result = $dashboard->deleteUser($_POST['delete_user_id']);
                if ($result === 'success') {
                    $message = 'user berhasil terhapus ';
                    $users = $dashboard->usersList();
                } else {
                    $error = $result;
                }
            }
            if (isset($_POST['delete_book_id'])){
                $result = $dashboard->deleteBook($_POST['delete_book_id']);
                if ($result === 'success') {
                    $message = 'user berhasil terhapus ';
                    $books = $dashboard->booksList();
                } else {
                    $error = $result;
                }
            }
            if (isset($_POST['delete_category_id'])){
                $result = $dashboard->deleteCategory($_POST['delete_category_id']);
                if ($result === 'success') {
                    $message = 'user berhasil terhapus ';
                    $categories = $dashboard->categoriesList();
                } else {
                    $error = $result;
                }
            }
        }

        require __DIR__ . "/views/$dashboard_page";
        break;

    case 'logout':
        require __DIR__ . '/controllers/LoginController.php';
        $logout = new LoginController($conn);
        $logout->logout();
        header('Location: /login');
        break;

    default:
        require __DIR__ . '/views/404.php';
        # code...
        break;
}
