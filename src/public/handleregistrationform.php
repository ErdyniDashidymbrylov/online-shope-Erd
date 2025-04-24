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

function validateRegistration() {
    $errors = [];

    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        if (empty($name) || strlen($name) < 2) {
            $errors['name'] = "Имя обязательно для заполнения.";
        }
    }

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        if (empty($email)) {
            $errors['email'] = "Email обязателен для заполнения.";
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = "Некорректный формат email.";
        }
    }

    if (isset($_POST['psw']))
    {
        $password = $_POST['psw'];
        if (empty($password) || strlen($password)<2) {
            $errors['password'] = "Пароль обязателен для заполнения.";
        }
        }

    if (isset($_POST['psw-repeat'])) {
        $passwordRepeat = $_POST['psw-repeat'];
        if ($password !== $passwordRepeat) {
            $errors['psw-repeat'] = "Пароли не совпадают.";
        }
    }

  return $errors;
}


$validationErrors = validateRegistration();

if (empty($validationErrors)) {

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');

    $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $data = $stmt->fetch();

    echo "<pre>";

    print_r($data);

    echo "<pre>";

} else {

require_once './registrationform.php';

}

?>


