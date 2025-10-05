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

    public static function insertUser(string $name, string $email, string $password) : array
    {
        $tableName = static::getTableName();

        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = static::getPDO()->prepare("INSERT INTO $tableName (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(params: [':name' => $name, ':email' => $email, ':password' => $password]);

        return ['name' => $name, 'email' => $email, 'password' => $password];
    }

    public static function selectUser(string $email) : self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE email = :email");
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

    public static function selectUserID(int $userId) : self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE id = :user_id");
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

    public static function updateUser(string $name, int $userId ) : array
    {
        $tableName = static::getTableName();
        $stmtUpdateName = static::getPDO()->prepare("UPDATE $tableName SET name = :name WHERE id = $userId");
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

    protected static function getTableName(): string
    {
       return 'users';
    }
}

