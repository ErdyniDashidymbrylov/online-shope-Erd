<?php

namespace Request;

class FeedbackRequest
{
    public function __construct(private array $data)
    {
    }
    public function getProductId(): string
    {
        return $this->data['product_id'];
    }
    public function getComment(): string
    {
        return $this->data['comment'];
    }
    public function getScore(): string
    {
        return $this->data['score'];
    }

}

