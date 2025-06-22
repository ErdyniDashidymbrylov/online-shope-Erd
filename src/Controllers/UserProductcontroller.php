<?php
namespace Controllers;

/*require_once '../Controllers/Productcontroller.php';
require_once '../Model/UserProduct.php';
require_once '../Model/Product.php';*/

use Model\Product;
use Model\User;
use Model\UserProduct;
use Service\AuthService;
use Service\CartService;

class UserProductcontroller extends BaseController
{
    protected Product $productModel;

    protected User $userModel;
    protected UserProduct $userProductModel;
    private AuthService $authService;
    private CartService $cartService;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->userModel = new User();
        $this->userProductModel = new UserProduct();
        $this->authService = new AuthService();
        $this->cartService = new CartService();
    }

    public function getAdd_product()
    {
        require_once '../Views/add_product_form.php';
    }

    public function postAdd_product()
    {



        if ($this->authService->check() === false) {
            header("Location: /login");
            exit();
        }

        $productId = $_POST['product_id'];
        $userId = $this->authService->getCurrentUserId();
        $amount = 1;

        $this->cartService->addProduct($productId, $amount, $userId);

        $this->getCart();
    }

    public function postDecreaseProduct()
    {

        if ($this->authService->check() === false) {
            header("Location: /login");
            exit();
        }

        $productId = $_POST['product_id'];
        $userId = $this->authService->getCurrentUserId();
        $amount = 1;

        $this->cartService->decreaseProduct($productId, $amount, $userId);

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

      