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



}