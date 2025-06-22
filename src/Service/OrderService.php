<?php

namespace Service;

use Model\Order;
use Model\OrderProduct;
use Model\Product;

class OrderService
{
    private $orderProductModel;
    private $productModel;
    private $orderModel;

    public function __construct()
    {
        $this->orderProductModel = new OrderProduct();
        $this->productModel = new Product();
        $this->orderModel = new Order();
    }
    public function addOrder(int $userId): ?array
    {
        $userOrders = $this->orderModel->getAllByUserId($userId);
        $newUserOrders = [];
        foreach ($userOrders as $userOrder) {
            $orderProducts = $this->orderProductModel->getAllByOrderId($userOrder->getId());

            $newOrderProducts = [];
            $sum = 0;
            foreach ($orderProducts as $orderProduct) {

                $product = $this->productModel->getProductById($orderProduct->getProductId());
                $orderProduct->setName($product->getName());
                $orderProduct->setPrice($product->getPrice());
                $orderProduct->setTotalsum($orderProduct->getAmount() * $orderProduct->getPrice());

                $newOrderProducts[] = $orderProduct;

                $sum += $orderProduct->getAmount() * $orderProduct->getPrice();

            }
            $userOrder->setTotal($sum);
            $userOrder->setProducts($newOrderProducts);
            $newUserOrders[] = $userOrder;
        }
        return $newUserOrders;

    }
}