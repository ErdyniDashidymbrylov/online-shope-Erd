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
    public static function insertProduct(int $productId,int $amount,int $userId): void
    {
        $tableName = static::getTableName();
        $stmtInsert = static::getPDO()->prepare("INSERT INTO $tableName(product_id, amount, user_id) VALUES (:product_id, :amount, :user_id)");
        $stmtInsert->execute([':product_id' => $productId, ':amount' => $amount, ':user_id' => $userId]);

    }

    public static function selectAmountProducts(int $userId,int $productId): int
    {
        $tableName = static::getTableName();

        $stmt =static::getPDO()->prepare("SELECT amount FROM $tableName WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute([':product_id' => $productId, ':user_id' => $userId]);
        $productInAmount = $stmt->fetchColumn();
        return $productInAmount;
    }

    public static function updateProduct(int $productId,int $amount,int $userId): void
    {
        $tableName = static::getTableName();
        $stmtUpdate = static::getPDO()->prepare("UPDATE $tableName SET amount = :amount WHERE product_id = :product_id AND user_id = :user_id");
        $stmtUpdate->execute([':amount' => $amount, ':product_id' => $productId, ':user_id' => $userId]);
    }
    public static function DeleteOneByUserIdProductId(int $productId,int $userId): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("DELETE FROM $tableName WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute([':product_id' => $productId, ':user_id' => $userId]);
    }

    public static function selectProductByID(int $userId): array|null
    {
        $tableName = static::getTableName();
        //$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
        $stmtcart = static::getPDO()->prepare("SELECT * FROM $tableName  up INNER JOIN products p ON up.product_id = p.id WHERE user_id = :user_id");
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

    public static function deleteByUserId(int $userId): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("DELETE FROM $tableName WHERE user_id = :user_id");
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


    protected static function getTableName(): string
    {
        return 'user_products';
    }
}


