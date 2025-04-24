<?php

$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');

$stmt = $pdo->query("SELECT * FROM products");

$products = $stmt->fetchAll();

echo "<pre>";
print_r($products);
echo "</pre>";

require_once './catalog_page.php';

