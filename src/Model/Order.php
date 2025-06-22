<?php

namespace Model;
use \PDO;
class Order extends Model
{
    private int $id;
    private string $contact_name;
    private string $address;
    private string $phone;
    private string $comment;
    private int $userId;
    private int $total;
    private array $products;

    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
    public function create(string $name, string $phone, string $address, string $comment, int $userId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->getTableName()} (
                    contact_name, phone, address, comment, user_id) VALUES (:contact_name, :phone, :address, :comment, :user_id) RETURNING id");
        $stmt->execute(['contact_name' => $name, 'phone' => $phone, 'address' => $address, 'comment' => $comment, 'user_id' => $userId]);

        $data = $stmt->fetch();

        return $data['id'];
    }
    public function getAllByUserId(int $userId): array|null
    {

        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $orderProducts = [];
        if ($results === false) {
            return null;
        }
        foreach ($results as $result) {
            $product = new self();
            $product->id = $result['id'];
            $product->userId = $result['user_id'];
            $product->contact_name = $result['contact_name'];
            $product->address = $result['address'];
            $product->phone = $result['phone'];
            $product->comment = $result['comment'];
            //$product->total = $result['total'];
           // $product->products = $result['products'];


            $orderProducts[] = $product;
        }

        return $orderProducts;


    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getContactName(): string
    {
        return $this->contact_name;
    }

    public function getId(): int
    {
        return $this->id;
    }


    protected function getTableName(): string
    {
       return 'orders';
    }
}