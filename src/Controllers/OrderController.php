<?php

namespace Controllers;

use Model\Order;

class OrderController
{
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

              $orderModel = new \Model\Order();
              $orderId = $orderModel->create($contactName, $contactPhone, $address, $comment,$userId);


              $userProductModel = new \Model\UserProduct();
              $userProducts = $userProductModel->selectProductByID($userId);

              $orderProductModel = new \Model\OrderProduct();
              foreach ($userProducts as $userProduct) {
                  $productId = $userProduct['product_id'];
                  $amount = $userProduct['amount'];

                  $orderProductModel->create($orderId, $productId, $amount);
              }

              $userProductModel->deleteByUserId($userId);
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
    $orderModel = new \Model\Order();
    $orderProductModel = new \Model\OrderProduct();
    $productModel = new \Model\Product();


    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (!isset($_SESSION['userId'])) {
        header("Location: /login");
        exit();
    }

    $userId = $_SESSION['userId'];

    $userOrders = $orderModel->getAllByUserId($userId);

    $newUserOrders = [];
    foreach ($userOrders as $userOrder) {
        $orderProducts = $orderProductModel->getAllByOrderId($userOrder['id']);

        $newOrderProducts = [];
        $sum = 0;
        foreach ($orderProducts as $orderProduct) {

            $product = $productModel->getProductById($orderProduct['product_id']);
            $orderProduct['name'] = $product['name'];
            $orderProduct['price'] = $product['price'];
            $orderProduct['totalsum'] = $orderProduct['amount'] * $orderProduct['price'];

            $newOrderProducts[] = $orderProduct;

            $sum = $sum + $orderProduct['totalsum'];

        }
        $userOrder['total'] = $sum;
        $userOrder['products'] = $newOrderProducts;
        $newUserOrders[] = $userOrder;

    }
    require_once '../Views/OrdersView.php';
}

}