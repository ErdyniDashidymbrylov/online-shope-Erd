<?php

require_once '../Model/GetData.php';
class User extends GetData
{
    public function insertUser(array $data) : array
    {
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['psw'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(params: [':name' => $name, ':email' => $email, ':password' => $password]);

        return ['name' => $name, 'email' => $email, 'password' => $password];
    }

    public function selectUser(string $email) : array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return $user;
    }

    public function selectUserID(int $userId) : array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function updateUser(string $name, int $userId ) : array
    {
        $stmtUpdateName = $this->pdo->prepare("UPDATE users SET name = :name WHERE id = $userId");
        $stmtUpdateName->execute([':name' => $name]);
        return ['name' => $name, 'userId' => $userId];
    }

}

