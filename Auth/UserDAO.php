<?php
require_once 'User.php';

class UserDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function findByUsername($username) {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE Username = ?;');
        $stmt->execute([$username]);
        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }
        return new User($row['Id'], $row['Username'], $row['Password'], $row['Role']);
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE Id = ?;');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }
        return new User($row['Id'], $row['Username'], $row['Password'], $row['Role']);
    }

    public function findAllUsers()
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users;');
        $stmt->execute();
        $users = [];
        while($row = $stmt->fetch())
        {
            $users[] = new User($row['Id'], $row['Username'], $row['Password'], $row['Role']);
        }
        return $users;
    }

    public function saveUser($username, $password, $role) {
        $sql = "INSERT INTO users (Username, Password, Role) VALUES(?, ?, ?);";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username, $password, $role]);
    }

    public function updateRole($user, $newRole)
    {
        $sql = "UPDATE users SET Role = ? where id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$newRole, $user->getId()]);
    }
}
?>