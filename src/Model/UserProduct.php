<?php
namespace Model;
use \PDO;
//require_once '../Model/Model.php';
class UserProduct extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $amount;
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
    public function DeleteOneByUserIdProductId(int $productId,int $userId): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute([':product_id' => $productId, ':user_id' => $userId]);
    }

    public function selectProductByID(int $userId): array|null
    {
        //$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
        $stmtcart = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $stmtcart->execute(['user_id' => $userId]);
        $results = $stmtcart->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        if ($results === false) {
            return null;
        }
        foreach ($results as $result) {
            $product = new self();
            $product->id = $result['id'];
            $product->amount = $result['amount'];
            $product->productId = $result['product_id'];
            $product->userId = $result['user_id'];

            $products[] = $product;
        }

        return $products;
    }

    public function deleteByUserId(int $userId): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getId(): int
    {
        return $this->id;
    }



}


