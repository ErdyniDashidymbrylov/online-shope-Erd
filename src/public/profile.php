<?php

session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['userId'];

$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<h1>Добро пожаловать, " . $user['name'] . "!</h1>";

echo "<h3>ваша электронная почта: " . $user['email'] . "!</h3>";

echo "<p><a href='changeprofile.php'>Редактировать профиль</a></p>";

echo "<p><a href='logout.php'>Выйти</a></p>";


?>

