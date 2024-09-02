<?php
class Borrowed
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getBorrowedByBookId($borrowed_id)
    {
        $sql = "
            SELECT 
                b.id AS borrow_id,
                bk.id AS book_id,
                bk.title,
                bk.cover_image_path,
                b.due_date
            FROM 
                borrowed b
            JOIN 
                books bk ON b.book_id = bk.id
            WHERE 
                    bk.id = ? AND b.status = 'borrowed'
        ";
        $statement = $this->conn->prepare($sql);
        $statement->bind_param("s", $borrowed_id);
        $statement->execute();
        $result = $statement->get_result();
        $borrows = $result->fetch_all(MYSQLI_ASSOC);
        $statement->close();
        return $borrows;
    }

    public function getBorrowedById($borrowed_id)
    {
        $sql = "SELECT * FROM borrowed WHERE id=?";
        $statement = $this->conn->prepare($sql);
        $statement->bind_param("s", $borrowed_id);
        $result = $statement->execute();
        $statement->close();
        if(!$result){
            return false;
        }
        return $result;
    }

    public function getBorrows($id)
    {
        $sql = "
            SELECT 
                b.id AS borrow_id,
                bk.id AS book_id,
                bk.title,
                bk.cover_image_path,
                b.status,
                b.due_date,
                b.borrow_date,
                b.return_date
            FROM 
                borrowed b
            JOIN 
                books bk ON b.book_id = bk.id
            WHERE 
                b.user_id = ?
            ORDER BY 
                b.due_date ASC
        ";
        $statement = $this->conn->prepare($sql);
        if(!$statement){
            var_dump($this->conn->error);
            return false;
        }
        $statement->bind_param("s", $id);
        $result = $statement->execute();
        $result = $statement->get_result();
        $borrows = $result->fetch_all(MYSQLI_ASSOC);
        $statement->close();
        return $borrows;
    }

    public function updateStatus($borrowed_id, $return_date, $status)
    {
        $sql = "UPDATE borrowed
            SET
                status = ?,
                return_date = ?
            WHERE
                id = ? ";

        $statement = $this->conn->prepare($sql);
        $statement->bind_param("sss", $status, $return_date, $borrowed_id);
        $result = $statement->execute();
        if (!$result) {
            var_dump("========================".$this->conn->error.$return_date);
            return false;
        }
        return $result;
    }

    public function addBorrowed($user_id, $book_id, $due)
    {
        $sql = "INSERT INTO borrowed (user_id, book_id, due_date) VALUES(?,?,?)";
        $statement = $this->conn->prepare($sql);
        $statement->bind_param("sss", $user_id, $book_id, $due);
        $result = $statement->execute();
        $statement->close();
        if (!$result) {
            return false;
        }
        return true;
    }
}