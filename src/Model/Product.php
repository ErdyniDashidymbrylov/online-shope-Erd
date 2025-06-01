<?php

namespace Model;
use \PDO;
//require_once '../Model/Model.php';
class Product extends Model
{
    public function getAllProducts():array
    {

        $stmt = $this->pdo->query("SELECT * FROM products");

        return $stmt->fetchAll();

    }

    public function getProductById(int $productId):array
    {


        $stmtprod = $this->pdo->prepare("SELECT * FROM products WHERE id = :product_id");
        $stmtprod->execute(['product_id' => $productId]);

        return $stmtprod->fetch(PDO::FETCH_ASSOC);
    }
}

