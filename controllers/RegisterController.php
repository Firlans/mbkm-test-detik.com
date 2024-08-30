<?php
require_once 'models/User.php';

class RegisterController
{
    private $conn;
    private $userModel;
    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->userModel = new User($conn);
    }

    public function register($username, $email, $password, $confirm_password)
    {
        if (!$username || !$email || !$password || !$confirm_password) {
            return "harap isi semua field";
        }
        if ($password !== $confirm_password) {
            return 'confirm password tidak sesuai';
        }
        if ($this->userModel->getUserByEmail($email)) {
            return "email sudak digunakan, silakan login ke email $email";
        }
        $role = 'user';
        $isRegister = $this->userModel->createUser($username, $email, $password, $role);
        if ($isRegister) {
            return 'sukses';
        }
        return "terjadi, silakan coba lagi";
    }
}
?>