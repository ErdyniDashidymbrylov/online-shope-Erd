<?php

namespace Controllers;

use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;
use Request\OrderRequest;
use Service\Auth\AuthSessionService;
use Service\OrderService;

class OrderController extends BaseController
{
    private UserProduct $userProductModel;
    private Order $orderModel;
    private Product $productModel;
    private OrderProduct $orderProductModel;
    private AuthSessionService $authService;
    private OrderService $orderService;

    public function __construct()
    {
       $this->orderModel = new Order();
        $this->orderProductModel = new OrderProduct();
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
        $this->authService = new AuthSessionService();
        $this->orderService = new OrderService();
    }

   public function getCheckoutForm()
   {
       require_once "../Views/Orderform.php";
   }
   public function handleCheckoutForm(OrderRequest $request) // перенести в сервис
   {

       if ($this->authService->check() === false) {
           header("Location: /login");
           exit();
       }

       $errors = $request->validateForm();

       if (empty($errors)) {
           $contactName = $request->getContactName();
           $contactPhone = $request->getPhone();
           $address = $request->getAddress();
           $comment = $request->getComment();
           $userId = $this->authService->getCurrentUserId();

           $dto = new OrderCreateDTO($contactName, $contactPhone, $address, $comment, $userId);

           $this->orderService->createOrder($dto);

           /*        $orderId = $this->orderModel->create($contactName, $contactPhone, $address, $comment,$userId);

                   $userProducts = $this->userProductModel->selectProductByID($userId);

                   foreach ($userProducts as $userProduct) {
                       $productId = $userProduct->getProductId();
                       $amount = $userProduct->getAmount();

                       $this->orderProductModel->create($orderId, $productId, $amount);
                   }

                    $this->userProductModel->deleteByUserId($userId);*/
                }
       else {
               $this->getCheckoutForm();
           }
       }


public function getOrdersView()
    {


        if ($this->authService->check() === false) {
            header("Location: /login");
            exit();
        }

        $userId = $this->authService->getCurrentUserId();

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
                $totalSumForProduct = $orderProduct->getAmount() * $orderProduct->getPrice();
                $orderProduct->setTotalsum($totalSumForProduct);

                $newOrderProducts[] = $orderProduct;
                $sum += $totalSumForProduct;
            }
                $userOrder->setTotal($sum);
                $userOrder->setProducts($newOrderProducts);

                $newUserOrders[] = $userOrder;


        } require_once '../Views/OrdersView.php';
    }
}












