<?php
/*
/*
 * //print_r($GET);

$name = $_GET['name'];
$email = $_GET['email'];
$password = $_GET['psw'];
$repeatpassword = $_GET['psw-repeat'];

$flag = true;

if (empty($name)) {
    $flag = false;
    echo 'Поле Name пустое!';
}

$domain = strstr($email,"@");

if ((empty($email)) && (empty($domain)))
{
     $flag = false;
    echo 'Неправильно введен емаил!';
}

if (empty($password) && empty($repeatpassword) && ($password != $repeatpassword))
{
    $flag = false;
    echo 'Неправильно введен пароль!';
}


if ($flag == true)
{

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');

    $pdo->exec("INSERT INTO users(name, email, password) VALUES ('$name', '$email', '$password')") ;

$lastid = $pdo->lastInsertId();

$statement = $pdo->query("SELECT * FROM users WHERE id = $lastid");

$data = $statement->fetch();
}

echo "<pre>";

print_r($data);

echo "<pre>";*/


//global $password;
global $users, $pdo, $userModel;
require_once './Controllers/UsercController.php';
require_once './Model/User.php';

$validationErrors = $users->validateRegistration($_POST);
if (empty($validationErrors)) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['psw'];
    $passwordRepeat = $_POST['psw-repeat'];

    $insertUser = $userModel->insertUser($_POST);


   /* $lastid = $pdo->lastInsertId();

    $statement = $pdo->query("SELECT * FROM users WHERE id = $lastid");
    $data = $statement->fetch();
    echo "<pre>";
     print_r($data);
    echo "<pre>";*/


    $selectUser = $userModel->selectUser($email);

/*    echo "<pre>";
    print_r($data);
    echo "<pre>";*/

    require_once './login/login_form.php';

} else {

require_once './registration/registrationform.php';

}

?>


