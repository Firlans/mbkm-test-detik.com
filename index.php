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
            $message = $result === 'sukses' ? 'registrasi berhasil, silakan login' : $result;
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
            $message = $_POST['action'];
            switch ($_POST['action']) {
                case 'add_book':
                    $result = $dashboard->addBook($_POST['book_title'], $_POST['book_category'], $_POST['book_description'], $_FILES['book_file'], $_FILES['book_cover'], $_SESSION['user_id']);
                    $message = $result === 'success' ? 'Buku berhasil ditambahkan' : $result;
                    $books = $dashboard->booksList();
                    break;

                case 'add_category':
                    $result = $dashboard->addCategory($_POST['category_name']);
                    $message = $result === 'success' ? 'category berhasil ditambahkan ' : $result;
                    $categories = $dashboard->categoriesList();
                    break;
                case 'add_user':
                    $result = $dashboard->addUser($_POST['email'], $_POST['username'], $_POST['password'], $_POST['role']);
                    $message = $result === 'success' ? 'user berhasil ditambahkan ' : $result;
                    $users = $dashboard->usersList();
                    break;

                case 'delete_category':
                    $result = $dashboard->deleteCategory($_POST['delete_item_id']);
                    $message = $result === 'success' ? 'category berhasil dihapus' : $result;
                    $categories = $dashboard->categoriesList();
                    break;

                case 'delete_book':
                    break;

                case 'delete_user':
                    break;

                case 'edit_book':
                    break;

                case 'edit_category':
                    break;

                case 'edit_user':
                    break;

                default:
                    # code...
                    break;
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
