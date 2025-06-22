<?php

namespace Model;
use \PDO;
class OrderProduct extends Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $price;
    private int $amount;
    private string $name;
    private int $totalsum;
    public function getName(): string
    {
        return $this->name;
    }
    public function getTotalsum(): int
    {
        return $this->totalsum;
    }
    public function setTotalsum(int $totalsum): void
    {
        $this->totalsum = $totalsum;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }


   // private string $userId;


    public function create(int $orderId, int $productId, int $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->getTableName()} (order_id, product_id, amount) VALUES (:orderId, :productId, :amount)");

        $stmt->execute(['orderId' => $orderId, 'productId' => $productId, 'amount' => $amount]);
    }
    public function getAllByOrderId(int $orderId): array|null

    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE order_id = :orderId");
        $stmt->execute(['orderId' => $orderId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $orderProducts = [];
        if ($results === false) {
            return null;
        }
        foreach ($results as $result) {
            $product = new self();
            $product->id = $result['id'];
            $product->amount = $result['amount'];
            $product->productId = $result['product_id'];
            $product->orderId = $result['order_id'];


            $orderProducts[] = $product;
        }

        return $orderProducts;

        }

  /*  public function getUserId(): string
    {
        return $this->userId;
    }*/

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

   public function getProductId(): int
    {
        return $this->productId;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getId(): int
    {
        return $this->id;
    }


    protected function getTableName(): string
    {
        return 'order_products';
    }
}