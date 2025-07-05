<?php
namespace Controllers;

/*require_once '../Controllers/Productcontroller.php';
require_once '../Model/UserProduct.php';
require_once '../Model/Product.php';*/

use Model\Product;
use Model\User;
use Model\UserProduct;
use Request\AddProductRequest;
use Service\Auth\AuthSessionService;
use Service\CartService;

class UserProductcontroller extends BaseController
{
    protected Product $productModel;

    protected User $userModel;
    protected UserProduct $userProductModel;
    private AuthSessionService $authService;
    private CartService $cartService;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->userModel = new User();
        $this->userProductModel = new UserProduct();
        $this->authService = new AuthSessionService();
        $this->cartService = new CartService();
    }

    public function getAdd_product()
    {
        require_once '../Views/add_product_form.php';
    }

    public function postAdd_product(AddProductRequest $request)
    {



        if ($this->authService->check() === false) {
            header("Location: /login");
            exit();
        }

        $productId = $request->getProductId();
        $userId = $this->authService->getCurrentUserId();
        $amount = 1;

        $this->cartService->addProduct($productId, $amount, $userId);

        $this->getCart();
    }

    public function postDecreaseProduct(AddProductRequest $request)
    {

        if ($this->authService->check() === false) {
            header("Location: /login");
            exit();
        }

        $productId = $request->getProductId();
        $userId = $this->authService->getCurrentUserId();
        $amount = 1;

        $this->cartService->decreaseProduct($productId, $amount, $userId);

        $this->getCart();
    }


    public function getCart()
    {

        /*$userModel = new \Model\User();
        $userProductModel = new \Model\UserProduct();
        $userId = $_SESSION['userId'];
        $user = $userModel->selectUserID($userId);
        $productsInCart =$userProductModel->selectProductByID($userId);*/
        /*$UserProductcontroller = new \Controllers\UserProductcontroller();
        $UserProductcontroller->postCart();
        */
   /*     $userModel = new \Model\User();
        $userProductModel = new \Model\UserProduct();
        $productModel = new \Model\Product();*/


        $this->authService->check();

        $userId = $this->authService->getCurrentUserId();

        /*if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit();
        }

        $userId = $_SESSION['userId'];*/

//$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');

        $user = $this->userModel->selectUserID($userId);

        $productsInCart = $this->userProductModel->selectProductByID($userId);

        $productsList = [];
        /*if (!isset($productModel)) {
            $productModel = new \Model\Product();
        }*/

        foreach ($productsInCart as $cartItem) {
            $productId = $cartItem->getProductId();

            $product = $this->productModel->getProductById($productId);

            if ($product) {
                $productsList[] = $product;
            }
        }

        $summa = 0;


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

      