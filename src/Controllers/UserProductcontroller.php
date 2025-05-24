<?php

class UserProductcontroller
{

    public function getAdd_product()
    {
        require_once '../Views/add_product_form.php';
    }

    public function postAdd_product()
    {
        require_once '../Controllers/Productcontroller.php';
        require_once '../Model/UserProduct.php';
        require_once '../Model/Product.php';
        $userProductModel = new UserProduct();

        session_start();

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit();
        }

        $productId = $_POST['product_id'];
        $amount = $_POST['amount'];
        $userId = $_SESSION['userId'];

        $productInAmount = $userProductModel->selectAmountProducts($userId, $productId);

        if (!empty($productInAmount)) {
            $newAmount = $productInAmount + $amount;
            $userProductModel->updateProduct($productId, $newAmount, $userId);
        } else {
            $userProductModel->insertProduct($productId, $amount, $userId);
        }
        $this->getCart();
    }

    public function getCart()
    {
        require_once '../Views/cart.php';
    }
}
