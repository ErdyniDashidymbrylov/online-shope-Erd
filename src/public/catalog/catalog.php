<?php
global $products, $productModel;
session_start();
require_once "../Model/Product.php";

if (isset($_SESSION['userId'])) {

    $productsInCatalog = $productModel->getAllProducts();
    require_once './catalog/catalog_page.php';
}
/*echo "<pre>";
print_r($products);
echo "</pre>";*/
 else {
     header('Location: /login');
 }


