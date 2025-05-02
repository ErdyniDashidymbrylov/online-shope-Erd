<?php

function validateName(array $data): array
{
    $errors = [];
    if (empty($data['username'])) {
        $errors['username'] = "Username обязательно для заполнения";
    }
    if (empty($data['password'])) {
        $errors['password'] = 'Поле password обязательно для заполнения';
    }
    return $errors;
}

$errors = validateName($_POST);

if (empty($errors)) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $pdo = new PDO(dsn: 'pgsql:host=postgres; port=5432;dbname=testdb', username: 'user', password: '123');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $username]);
    $user = $stmt->fetch();

    if (!empty($user)) {
        $passwordDB = $user['password'];

        if (password_verify($password, $passwordDB)) {
            session_start();
            $_SESSION['userId'] = $user['id'];
             // exit();
            header("Location: /catalog");
            //require_once './catalog.php';
        } else {

            $errors['username'] = 'username or password is incorrect!';
        }
    } else {
        $errors['username'] = 'Пользователь с таким логином не существует!';
    }
}
  else
{
    require_once './login_form';
}



