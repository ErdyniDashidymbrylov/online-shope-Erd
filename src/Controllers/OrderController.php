<?php

namespace Controllers;

use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;

class OrderController
{
    private UserProduct $userProductModel;
    private Order $orderModel;
    private Product $productModel;
    private OrderProduct $orderProductModel;

    public function __construct()
    {
       $this->orderModel = new Order();
        $this->orderProductModel = new OrderProduct();
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
    }

   public function getCheckoutForm()
   {
       require_once "../Views/Orderform.php";
   }
   public function handleCheckoutForm()
   {

      if (session_status() !== PHP_SESSION_ACTIVE) {
             session_start();
       }
       if (!isset($_SESSION['userId'])) {
           header("Location: /login");
           exit();
       }

       $errors = $this->validateForm($_POST);

           if (empty($errors)) {
              $contactName = $_POST['contact_name'];
              $contactPhone = $_POST['phone'];
              $address = $_POST['address'];
              $comment = $_POST['comment'];
              $userId = $_SESSION['userId'];

              $orderId = $this->orderModel->create($contactName, $contactPhone, $address, $comment,$userId);

              $userProducts = $this->userProductModel->selectProductByID($userId);

              foreach ($userProducts as $userProduct) {
                  $productId = $userProduct->getProductId();
                  $amount = $userProduct->getAmount();

                  $this->orderProductModel->create($orderId, $productId, $amount);
              }

               $this->userProductModel->deleteByUserId($userId);
           }
            else {
                require_once "../Views/Orderform.php";
            }
   }
private function validateForm($data)
   {
       $errors = [];
       if (isset($data['contact_name'])) {
           $name = $data['contact_name'];
           if (strlen($name) < 2) {
               $errors['contact_name'] = "Имя обязательно для заполнения.";
           }
       } else {
           $errors['contact_name'] = "Имя должно быть заполнено.";
       }

       if (isset($data['phone'])) {
           $phone = $data['phone'];
           if (strlen($phone) < 10) {
               $errors['phone'] = "телефон не может содержать меньше 11 символов.";
           }
       }
       if (isset($data['address'])) {
           $address = $data['address'];
           if (strlen($address) < 3) {
               $errors['address'] = "адрес не может содержать меньше 3 символов.";
           }
       }

           return $errors;

   }

public function getOrdersView()
{

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (!isset($_SESSION['userId'])) {
        header("Location: /login");
        exit();
    }

    $userId = $_SESSION['userId'];

    $userOrders = $this->orderModel->getAllByUserId($userId);
     /*  echo "<pre>";
       print_r($userOrders);
        echo "</pre>";*/


    $newUserOrders = [];
    foreach ($userOrders as $userOrder) {
        $orderProducts = $this->orderProductModel->getAllByOrderId($userOrder->getId());
      /*  echo "<pre>";
        print_r($orderProducts);
        echo "</pre>";*/

      $newOrderProducts = [];
        $sum = 0;
        foreach ($orderProducts as $orderProduct) {

            $product = $this->productModel->getProductById($orderProduct->getProductId());
            $orderProduct->setName($product->getName());
            $orderProduct->setPrice($product->getPrice());
            $orderProduct->setTotalsum($orderProduct->getAmount() * $orderProduct->getPrice());

            $newOrderProducts[] = $orderProduct;

            $sum = $sum +  $orderProduct->setTotalsum($orderProduct->getAmount() * $orderProduct->getPrice());;

        }
        $userOrder->setTotal($sum);
        $userOrder->setProducts($newOrderProducts);
        $newUserOrders[] = $userOrder;

    }
    require_once '../Views/OrdersView.php';
}

}