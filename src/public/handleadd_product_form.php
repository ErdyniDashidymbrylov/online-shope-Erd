<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
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

$validationErrors = validateAddProduct($_POST);

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
    $product_id = $_POST['product_id'];
    $amount = $_POST['amount'];
    $user_id = $_SESSION['userId'];
    // Проверяем, существует ли продукт для пользователя

    $stmt = $pdo->prepare("SELECT amount FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
    $stmt->execute([':product_id' => $product_id, ':user_id' => $user_id]);
    $existingAmount = $stmt->fetchColumn();

    if ($existingAmount !== false) {
        // Продукт существует, обновляем количество
        $newAmount = $existingAmount + $amount;
        $stmtUpdate = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE product_id = :product_id AND user_id = :user_id");
        $stmtUpdate->execute([':amount' => $newAmount, ':product_id' => $product_id, ':user_id' => $user_id]);
    } else {
        // Продукт не существует, вставляем новую запись
        $stmtInsert = $pdo->prepare("INSERT INTO user_products (product_id, amount, user_id) VALUES (:product_id, :amount, :user_id)");
        $stmtInsert->execute([':product_id' => $product_id, ':amount' => $amount, ':user_id' => $user_id]);
    }
    require_once './cart.php';
}