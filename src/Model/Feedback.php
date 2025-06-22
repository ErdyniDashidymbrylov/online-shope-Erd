<?php

namespace Model;
use \PDO;
class Feedback extends Model
{
    private int $id;
    private int $user_id;
    private string $comment;
    private int $score;
    private string $date;
    private int $productId;
    protected function getTableName(): string
    {
        return "feedbacks";
    }
    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    public function getAllFeedbacks(): array|null
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->getTableName()}");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $feedbacks = [];
        if ($results === false) {
            return null;
        }
        foreach ($results as $result) {
            $feedback = new self();
            $feedback->id = $result['id'];
            $feedback->user_id = $result['user_id'];
            $feedback->comment = $result['comment'];
            $feedback->score = $result['score'];
            $feedback->date = $result['date'];
            $feedback->productId = $result['product_id'];

            $feedbacks[] = $feedback;
        }

        return $feedbacks;
    }

    public function insertFeedback(int $userId, string $comment, int $score, string $date, int $productId): void
    {
        $stmtInsert = $this->pdo->prepare("INSERT INTO {$this->getTablename()} (user_id, comment, score, date, product_id) VALUES (:user_id, :comment, :score, :date,:product_id)");
        $stmtInsert->execute([':user_id' => $userId, ':comment' => $comment, ':score' => $score, ':date' => $date, ':product_id' => $productId]);
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }



    public function getId(): int
    {
        return $this->id;
    }



}