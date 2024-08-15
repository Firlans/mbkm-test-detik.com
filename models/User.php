<?php
class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getUsers()
    {
        $sql = 'SELECT * FROM users';
        $result = $this->conn->query($sql);
        $users = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();

        return $users;
    }

    public function getUserByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = ?';
        $statement = $this->conn->prepare($sql);
        $statement->bind_param('s', $email);
        $statement->execute();
        $result = $statement->get_result();
        $user = $result->fetch_assoc();
        $statement->close();
        return $user;
    }

    public function getUserById($id)
    {
        $sql = 'SELECT * FROM users WHERE id = ?';
        $statement = $this->conn->prepare($sql);
        $statement->bind_param('s', $id);
        $statement->execute();
        $result = $statement->get_result();
        $user = $result->fetch_assoc();
        $statement->close();
        return $user;
    }

    public function deleteUser($id)
    {
        $sql = 'DELETE FROM users WHERE id = ?';
        $statement = $this->conn->prepare($sql);
        $statement->bind_param('s', $id);
        $result = $statement->execute();
        $statement->close();
        return $result;
    }

    public function createUser($username, $email, $password, $role)
    {
        $sql = 'INSERT INTO users (username, email, password, role) VALUES(?,?,?,?)';
        $statement = $this->conn->prepare($sql);
        $statement->bind_param('ssss', $username, $email, $password, $role);
        $result = $statement->execute();
        $statement->close();
        return $result;
    }
}
