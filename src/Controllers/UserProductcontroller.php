<?php
namespace Controllers;

/*require_once '../Controllers/Productcontroller.php';
require_once '../Model/UserProduct.php';
require_once '../Model/Product.php';*/

class UserProductcontroller
{

    public function getAdd_product()
    {
        require_once '../Views/add_product_form.php';
    }

    public function postAdd_product()
    {

        $userProductModel = new \Model\UserProduct();

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

   /* public function postCart()
    {
        /*require_once '../Model/User.php';
            require_once '../Model/Product.php';
            require_once '../Model/UserProduct.php';*/
       /* $userModel = new \Model\User();
        $userProductModel = new \Model\UserProduct();
        $productModel = new \Model\Product();

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit();
        }

        $userId = $_SESSION['userId'];

//$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');

        $user = $userModel->selectUserID($userId);

        $productsInCart =$userProductModel->selectProductByID($userId);

        $productsList = [];
        /*if (!isset($productModel)) {
            $productModel = new \Model\Product();
        }*/

      /*  foreach ($productsInCart as $cartItem) {
            $productId = $cartItem['product_id'];

            $product = $productModel->getProductById($productId);

            if ($product) {
                $productsList[] = $product;
            }
        }

        $summa = 0;*/

}
