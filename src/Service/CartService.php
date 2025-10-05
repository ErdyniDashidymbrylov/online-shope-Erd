<?php

namespace Service;

use Model\UserProduct;

class CartService
{

    private $userProductModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
    }

    public function addProduct(int $productId, int $amount, int $userId )
    {


        $productInAmount = $this->userProductModel->selectAmountProducts($userId, $productId);

        if (!empty($productInAmount)) {
            $newAmount = $productInAmount + $amount;
            $this->userProductModel->updateProduct($productId, $newAmount, $userId);
        } else {
            $this->userProductModel->insertProduct($productId, $amount, $userId);
        }
    }

    public function decreaseProduct(int $productId, int $amount, int $userId)
    {

        $productInAmount = $this->userProductModel->selectAmountProducts($userId, $productId);

        if (!empty($productInAmount) && $productInAmount > 1) {
            $newAmount = $productInAmount - $amount;
            $this->userProductModel->updateProduct($productId, $newAmount, $userId);
        } else {
            if ($productInAmount == 1){
                $this->userProductModel->DeleteOneByUserIdProductId($productId, $userId);
            }

        }
    }



}