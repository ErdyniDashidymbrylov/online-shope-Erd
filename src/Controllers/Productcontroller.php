<?php

class Productcontroller
{

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
        session_start();
        require_once "../Model/Product.php";
        $productModel = new Product();

        if (isset($_SESSION['userId'])) {

            $productsInCatalog = $productModel->getAllProducts();
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

