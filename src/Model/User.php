<?php


class User
{
    public function insertUser(array $data) : array
    {
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['psw'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(params: [':name' => $name, ':email' => $email, ':password' => $password]);

        return ['name' => $name, 'email' => $email, 'password' => $password];
    }

    public function selectUser(string $email) : array
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return $user;
    }

    public function selectUserID(int $userId) : array
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function updateUser(string $name, int $userId ) : array
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
        $stmtUpdateName = $pdo->prepare("UPDATE users SET name = :name WHERE id = $userId");
        $stmtUpdateName->execute([':name' => $name]);
        return ['name' => $name, 'userId' => $userId];
    }

}

$userModel = new User();