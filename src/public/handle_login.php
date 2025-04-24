<?php

$username = $_POST["username"];
$password = $_POST["password"];

$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $username]);
$user = $stmt->fetch();

$errors = [];

if ($user === false) {
    $errors[] = "username or password is incorrect!";
}
else {
    $passwordDB = $user['password'];
    if (password_verify($password, $passwordDB)) {
        header('Location: catalog.php');
        //require_once './catalog.php';
    } else {

        $errors['username'] = 'username or password is incorrect!';
    }
}

//require_once './login_form.php';
