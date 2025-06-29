<?php

namespace Service;

use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;

class OrderService
{
    private $orderProductModel;
    private $userProductModel;
    private $orderModel;

    public function __construct()
    {
        $this->orderProductModel = new OrderProduct();
        $this->orderModel = new Order();
        $this->userProductModel = new UserProduct();
    }
    public function createOrder(OrderCreateDTO $data)
    {
        $userProducts = $this->userProductModel->selectProductByID($data->getUser()->getId());
        $orderId = $this->orderModel->create(
            $data->getName(),
            $data->getPhone(),
            $data->getAddress(),
            $data->getComment(),
            $data->getUser()->getId());

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct->getProductId();
            $amount = $userProduct->getAmount();

            $this->orderProductModel->create($orderId, $productId, $amount);
        }

        $this->userProductModel->deleteByUserId($data->getUser()->getId());
    }


}