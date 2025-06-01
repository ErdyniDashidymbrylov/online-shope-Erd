<?php

namespace Model;
use \PDO;
class Order extends Model
{
    public function create(string $name, string $phone, string $address, string $comment, int $userId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders (
                    contact_name, phone, address, comment, user_id) VALUES (:contact_name, :phone, :address, :comment, :user_id) RETURNING id");
        $stmt->execute(['contact_name' => $name, 'phone' => $phone, 'address' => $address, 'comment' => $comment, 'user_id' => $userId]);

        $data = $stmt->fetch();

        return $data['id'];
    }
    public function getAllByUserId(int $userId): array|null
    {

        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

}