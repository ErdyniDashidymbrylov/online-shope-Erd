<?php
session_start();

if (isset($_SESSION['userId'])) {
$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');

$stmt = $pdo->query("SELECT * FROM products");

$products = $stmt->fetchAll();
    require_once './catalog_page.php';
}
/*echo "<pre>";
print_r($products);
echo "</pre>";*/
 else {
     header('Location: /login_form');
 }


