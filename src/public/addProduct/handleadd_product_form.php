<?php
global $products, $userProducts;
require_once './products.php';
require_once './UserProducts.php';
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: /login");
    exit();
}


$validationErrors = $products->validateAddProduct($_POST);

/*if (empty($validationErrors)) {

    $product_id = $_POST['product_id'];
    $amount = $_POST['amount'];

    $stmt = $pdo->prepare("INSERT INTO user_products (product_id, amount, user_id) VALUES (:product_id, :amount, :user_id)");
    $stmt->execute(params: [':product_id' => $product_id, ':amount' => $amount, ':user_id' => $user_id]);
    $productCart = $stmt->fetch();


    $stmtselect = $pdo->prepare(query: "SELECT COUNT(*) FROM user_products WHERE id = :product_id");
    $stmtselect->execute([':product_id' => $product_id]);
    $row = $stmtselect->fetchColumn();
    if ($row > 0) {
        $amountAdd = $row + $amount;
        $stmtUpdate = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE product_id = :product_id AND user_id = :user_id");
        $stmtUpdate->execute([':amount' => $amountAdd, ':product_id' => $product_id, ':user_id' => $user_id]);
    }
   /* $stmtUpdate = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE product_id = :product_id AND user_id = :user_id");
    $stmtUpdate->execute([':amount' => $newAmount, ':product_id' => $product_id, ':user_id' => $user_id]);*/
 /*   echo "<pre>";
    var_dump($productCart);
    echo "</pre>";*/
/*    require_once './cart.php';
}*/

if (empty($validationErrors)) {
    $productId = $_POST['product_id'];
    $amount = $_POST['amount'];
    $userId = $_SESSION['userId'];
    //$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');

    $productInAmount = $userProducts->selectAmountProducts($userId,$productId);

    if ($productInAmount !== false) {
        $newAmount = $productInAmount + $amount;
        $userProducts->updateProduct($productId, $newAmount, $userId);
    } else {
              $userProducts->insertProduct($productId, $amount, $userId);
    }
    require_once './cart/cart.php';
}