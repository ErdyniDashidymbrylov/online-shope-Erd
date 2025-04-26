<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}
function validateRegistration(array $data) : array
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


$validationErrors = validateRegistration($_POST);

if (empty($validationErrors))
{

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['psw'];
    $passwordRepeat = $_POST['psw-repeat'];

    $user_id = $_SESSION['userId'];

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');

    $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, password = :password WHERE id = :user_id");
    $stmt->execute([':name' => $name, ':email' => $email, ':password' => $password, ':user_id' => $user_id]);
}


    header("Location: profile.php");





