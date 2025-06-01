<?php
namespace Controllers;

/*require_once '../Controllers/Productcontroller.php';
require_once '../Model/UserProduct.php';
require_once '../Model/Product.php';*/

use Model\Product;
use Model\User;
use Model\UserProduct;

class UserProductcontroller
{
    private Product $productModel;

    private User $userModel;
    private UserProduct $userProductModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->userModel = new User();
        $this->userProductModel = new UserProduct();
    }

    public function getAdd_product()
    {
        require_once '../Views/add_product_form.php';
    }

    public function postAdd_product()
    {


        session_start();

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit();
        }

        $productId = $_POST['product_id'];
        $amount = $_POST['amount'];
        $userId = $_SESSION['userId'];

        $productInAmount = $this->userProductModel->selectAmountProducts($userId, $productId);

        if (!empty($productInAmount)) {
            $newAmount = $productInAmount + $amount;
            $this->userProductModel->updateProduct($productId, $newAmount, $userId);
        } else {
            $this->userProductModel->insertProduct($productId, $amount, $userId);
        }
        $this->getCart();
    }

    public function getCart()
    {
        require_once '../Views/cart.php';
    }

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

      