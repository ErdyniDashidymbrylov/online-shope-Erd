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
    private LoggerService $loggerService;


    public function __construct()
    {
        $this->orderProductModel = new OrderProduct();
        $this->orderModel = new Order();
        $this->userProductModel = new UserProduct();
        $this->loggerService = new LoggerService();
    }
    public function createOrder(OrderCreateDTO $data)
    {
       // try {
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
      //  }
    /*    catch (\Throwable $exception)
        {
            $message = $exception->getMessage();
            $file = $exception->getFile();
            $line = $exception->getLine();

            $logMessage = date('Y-m-d H:i:s') . " | Message: {$message} | File: {$file} | Line: {$line}\n";
            $this->loggerService->logger($logMessage);

        }*/
    }


}