<?php
namespace Model;
use \PDO;
//require_once '../Model/Model.php';
class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public function insertUser(string $name, string $email, string $password) : array
    {

        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO {$this->getTableName()} (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(params: [':name' => $name, ':email' => $email, ':password' => $password]);

        return ['name' => $name, 'email' => $email, 'password' => $password];
    }

    public function selectUser(string $email) : self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user === false) {
            return null;
        }

        $obj = new self();
        $obj->id = $user['id'];
        $obj->name = $user['name'];
        $obj->email = $user['email'];
        $obj->password = $user['password'];

        return $obj;
    }

    public function selectUserID(int $userId) : self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $user = $stmt->fetch();

        if ($user === false) {
            return null;
        }

        $obj = new self();
        $obj->id = $user['id'];
        $obj->name = $user['name'];
        $obj->email = $user['email'];
        $obj->password = $user['password'];

        return $obj;
    }

    public function updateUser(string $name, int $userId ) : array
    {
        $stmtUpdateName = $this->pdo->prepare("UPDATE {$this->getTableName()} SET name = :name WHERE id = $userId");
        $stmtUpdateName->execute([':name' => $name]);
        return ['name' => $name, 'userId' => $userId];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    protected function getTableName(): string
    {
       return 'users';
    }
}

