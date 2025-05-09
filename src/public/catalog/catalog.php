<?php
global $products;
session_start();
require_once "./products.php";

if (isset($_SESSION['userId'])) {

    $productsInCatalog = $products->getAllProducts();
    require_once './catalog/catalog_page.php';
}
/*echo "<pre>";
print_r($products);
echo "</pre>";*/
 else {
     header('Location: /login');
 }


