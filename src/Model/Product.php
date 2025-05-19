<?php

class Product
{
    public function getAllProducts():array
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');

        $stmt = $pdo->query("SELECT * FROM products");

        return $stmt->fetchAll();

    }

    public function getProductById(int $productId):array
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
        $stmtprod = $pdo->prepare("SELECT * FROM products WHERE id = :product_id");
        $stmtprod->execute(['product_id' => $productId]);

        return $stmtprod->fetch(PDO::FETCH_ASSOC);
    }
}

$productModel = new Product();