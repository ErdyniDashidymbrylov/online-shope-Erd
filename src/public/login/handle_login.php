<?php

global $users;
require_once './users.php';
    function validateName($data){
        $errors = [];
        if (empty($data['username'])) {
            $errors['username'] = "Username обязательно для заполнения";
        }
        if (empty($data['password'])) {
            $errors['password'] = 'Поле password обязательно для заполнения';
        }
        return $errors;

    }


//$errors = $users->validateName($_POST);

$errors = validateName($_POST);

if (empty($errors)) {

    $username = $_POST['username'];
    $password = $_POST['password'];
   // $email = $_POST['email'];

  /* $pdo = new PDO(dsn: 'pgsql:host=postgres; port=5432;dbname=testdb', username: 'user', password: '123');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $username]);
    $user = $stmt->fetch();*/
  /*  public function selectUser(string $email) : array
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();
        return $data;
    }*/

   $user = $users->selectUser($username);
/*print_r($user);
die();*/
    if (!empty($user)) {
        $passwordDB = $user['password'];

        if (password_verify($password, $passwordDB)) {
            session_start();
            $_SESSION['userId'] = $user['id'];
             // exit();
            header("Location: /catalog");
            exit();
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
    require_once './login/login_form.php';
}



