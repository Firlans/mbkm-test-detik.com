<?php
require_once 'models/User.php';

class LoginController
{
    private $conn;
    private $userModel;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->userModel = new User($conn);
    }

    public function login($email, $password,)
    {
        if (!$email || !$password) {
            return "semua field wajib di isi";
        }
        $user = $this->userModel->getUserByEmail($email);
        if (!$user) {
            return 'email tidak ditemukan';
        }
        if ($user['password'] !== $password) {
            return 'password salah, harap masukkan password yang sesuai';
        }
        $_SESSION['user_id'] = $user['id'];

        return 'success';
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }



    public function logout(){
        session_destroy();
    }
}
