<?php
require_once '../Model/GetData.php';
class UserProduct extends GetData
{
    public function insertProduct(int $productId,int $amount,int $userId): void
    {
        $stmtInsert = $this->pdo->prepare("INSERT INTO user_products (product_id, amount, user_id) VALUES (:product_id, :amount, :user_id)");
        $stmtInsert->execute([':product_id' => $productId, ':amount' => $amount, ':user_id' => $userId]);

    }


    public function selectAmountProducts(int $userId,int $productId): int
    {

        $stmt = $this->pdo->prepare("SELECT amount FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute([':product_id' => $productId, ':user_id' => $userId]);
        $productInAmount = $stmt->fetchColumn();
        return $productInAmount;
    }

    public function updateProduct(int $productId,int $amount,int $userId): void
    {
        $stmtUpdate = $this->pdo->prepare("UPDATE user_products SET amount = :amount WHERE product_id = :product_id AND user_id = :user_id");
        $stmtUpdate->execute([':amount' => $amount, ':product_id' => $productId, ':user_id' => $userId]);
    }

    public function selectProductByID(int $userId): array
    {
        //$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
        $stmtcart = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $stmtcart->execute(['user_id' => $userId]);
        $result = $stmtcart->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}


