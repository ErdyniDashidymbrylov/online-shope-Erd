<?php

namespace Model;

use Model\Model;
use \PDO;

class RecentPurchases extends Model
{
    private int $id;

    public function getPurchase(): array
    {
        return $this->purchase;
    }

    public function setPurchase(array $purchase): void
    {
        $this->purchase = $purchase;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): void
    {
        $this->productName = $productName;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    private int $userId;
    private int $productId;
    private string $productName;
    private int $price;
    private string $date;
    private array $purchase;


    static protected function getTableName(): string
    {
        return 'purchases';
    }

    public static function getAllPurchasesByUserId(int $userId): array|null
    {
        $tableName = static::getTableName();

        $sql = "SELECT p.*, pr.name AS product_name
            FROM $tableName p
            JOIN products pr ON p.product_id = pr.id
            WHERE p.user_id = :user_id";

        $stmt = static::getPDO()->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $results = $stmt->fetchall(\PDO::FETCH_ASSOC);
        $purchases = [];

        if ($results === false || empty($results)) {
            return null;
        }

        foreach ($results as $result) {
            $purchase = new self();
            $purchase->id = $result['id'];
            $purchase->product_id = $result['product_id'];
            $purchase->date = $result['date'];
            $purchase->price = $result['price'];
            $purchase->user_id = $result['user_id'];
            $purchase->product_name = $result['name'];

            $purchases[] = $purchase;
        }

        return $purchases;
    }


}