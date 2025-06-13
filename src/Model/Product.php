<?php

namespace Model;
use \PDO;
//require_once '../Model/Model.php';
class Product extends Model
{
    private int $id;
    private string $name;
    private string $description;
    private int $price;
    private string $image_url;

    public function getAllProducts(): array|null
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        if ($results === false) {
            return null;
        }
        foreach ($results as $result) {
            $product = new self();
            $product->id = $result['id'];
            $product->name = $result['name'];
            $product->description = $result['description'];
            $product->price = $result['price'];
            $product->image_url = $result['image_url'];
            $products[] = $product;
        }

        return $products;
    }

    public function getProductById(int $productId):self|null

    {


        $stmtprod = $this->pdo->prepare("SELECT * FROM products WHERE id = :product_id");
        $stmtprod->execute(['product_id' => $productId]);
        $result = $stmtprod->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        $obj = new self();
        $obj->id = $result['id'];
        $obj->name = $result['name'];
        $obj->description = $result['description'];
        $obj->price = $result['price'];
        $obj->image_url = $result['image_url'];

        return $obj;

    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }



}

