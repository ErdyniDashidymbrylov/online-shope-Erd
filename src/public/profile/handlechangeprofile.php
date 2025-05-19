<?php
global $pdo, $users, $userModel;
require_once '../Controllers/UserController.php';
require_once '../Model/User.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['userId'])) {
    header("Location: /login");
    exit();
}

$userId = $_SESSION['userId'];
/*$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->execute([':user_id' => $userId]);
$user = $stmt->fetch();*/

$user = $userModel->selectUserID($userId);



$validationErrors = $users->validateChangeProfile($_POST);

if (empty($validationErrors)) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    /* $password = $_POST['psw'];
     $passwordRepeat = $_POST['psw-repeat'];*/


    if ($user['name'] !== $name) {
        $userModel->updateUser($name, $userId);
    }

    if ($user['email'] !== $email)
    {
        $userModel->updateUser($email, $userId);
        }

   /* if (!empty($_POST['psw']) && $_POST['psw'] === $_POST['psw-repeat']) {
            $hashedPassword = password_hash($_POST['psw'], PASSWORD_DEFAULT);
            $stmtUpdatePassword = $pdo->prepare("UPDATE users SET password = :password WHERE id = $userId");
            $stmtUpdatePassword->execute([':password' => $hashedPassword, ':user_id' => $userId]);
        }*/
    header("Location: /profile");
    exit;
}
        require_once './profile/profile.php';





