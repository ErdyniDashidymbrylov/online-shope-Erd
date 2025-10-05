<?php
namespace Controllers;

//require_once "../Model/Product.php";


use Model\Product;
use Service\Auth\AuthSessionService;

class Productcontroller extends BaseController
{
    protected Product $productModel;
    private AuthSessionService $authService;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->authService = new AuthSessionService();
    }
    function validateAddProduct(array $data) : array
    {
        $errors = [];

        if (isset($data['amount'])) {
            $amount = $data['amount'];
            if (strlen($amount) < 0) {
                $errors['name'] = "количество должно быть положительным.";
            }
        }
        else  { $errors['amount'] = "количество должно быть заполнено." ;
        }

        if (isset($data['product_id']))
        {
            $product_id = $data['product_id'];
            if (strlen($product_id) < 0) {
                $errors['product_id'] = "id продукта должно быть положительным.";
            }
        } else { $errors['product_id'] = "id продукта должен быть заполнен." ;
        }

        return $errors;
    }

    public function getCatalog()
    {
        global $products, $productModel;


        if ($this->authService->check()) {

            $productsInCatalog = product::getAllProducts();
            require_once '../Views/catalog_page.php';
        } else {
            header('Location: /login');
        }
    }




    public function getCatalogPage()
    {
        require_once '../Views/catalog_page.php';
    }
}

