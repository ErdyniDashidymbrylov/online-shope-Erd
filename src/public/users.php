<?php

class users
{
   public function validateRegistration(array $data) : array
    {
        $errors = [];

        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 2) {
                $errors['name'] = "Имя обязательно для заполнения.";
            }
        }
        else  { $errors['name'] = "Имя должно быть заполнено." ;
        }

        if (isset($data['email'])) {
            $email = $data['email'];
            if (strlen($email) < 3) {
                $errors['email'] = "Email не может содержать меньше 3 - х символов.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Некорректный формат email.";
            } else {
                $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
                $stmt = $pdo->prepare(query: "SELECT COUNT(*) FROM users WHERE email = :email");
                $stmt->execute([':email' => $email]);
                $row = $stmt->fetchColumn();
                if ($row > 0) {
                    $errors['email'] = 'Этот Email уже зарегистрирован!';
                }
            }
        }   else { $errors['email'] = "Емаил должен быть заполнен." ;
        }

        if (isset($data['psw']))
        {
            $password = $data['psw'];
            if (strlen($password)<2) {
                $errors['psw'] = "Пароль не может содержать меньше 2 - х символов.";
            }
            $passwordRepeat = $data['psw-repeat'];
            if ($password !== $passwordRepeat) {
                $errors['psw-repeat'] = "Пароли не совпадают.";
            }
        } else { $errors['psw'] = "Пароль должен быть заполнен." ;
        }

        return $errors;
    }
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


/*    public function validateName(array $data): array
    {
        $errors = [];
        if (empty($data['username'])) {
            $errors['username'] = "Username обязательно для заполнения";
        }
        if (empty($data['password'])) {
            $errors['password'] = 'Поле password обязательно для заполнения';
        }
        return $errors;
    }*/

   public function validateChangeProfile(array $data) : array
    {
        $errors = [];

        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 2) {
                $errors['name'] = "Имя обязательно для заполнения.";
            }
        }
        else  { $errors['name'] = "Имя должно быть заполнено." ;
        }

        if (isset($data['email'])) {
            $email = $data['email'];
            if (strlen($email) < 3) {
                $errors['email'] = "Email не может содержать меньше 3 - х символов.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Некорректный формат email.";
            } else {
                $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
                $stmt = $pdo->prepare(query: "SELECT * FROM users WHERE email = :email");
                $stmt->execute([':email' => $email]);
                $user = $stmt->fetch();

                $userId = $_SESSION['userId'];
                if ($user !== false) {
                    if ($user['id'] !== $userId) {
                        $errors['email'] = 'Этот Email уже зарегистрирован!';
                    }
                }
            }
        }
            return $errors;
    }

    public function updateUser(string $name, int $userId ) : array
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
        $stmtUpdateName = $pdo->prepare("UPDATE users SET name = :name WHERE id = $userId");
        $stmtUpdateName->execute([':name' => $name]);
        return ['name' => $name, 'userId' => $userId];
    }


}

$users = new users();


