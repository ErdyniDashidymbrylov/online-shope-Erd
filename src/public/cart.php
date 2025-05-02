<?php

if (!isset($_SESSION['userId'])) {
    header("Location: /login");
    exit();
}

$user_id = $_SESSION['userId'];

$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$stmtcart = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
$stmtcart->execute(['user_id' => $user_id]);
$productsCart = $stmtcart->fetchAll(PDO::FETCH_ASSOC);

   $product_id = $productsCart['product_id'];
    $stmtprod = $pdo->prepare("SELECT * FROM products WHERE id = :product_id");
    $stmtprod->execute(['product_id' => $product_id]);
    $products = $stmtprod->fetchAll(PDO::FETCH_ASSOC);
    //require_once './cart_page.php';

echo "<pre>";
   print_r($productsCart);
   echo "</pre>";

echo "<pre>";
print_r($products);
echo "</pre>";

   die;
?>
<?php foreach ($products as $product):?>
<div class="row">
    <div class="col-sm-12 col-md-3">
        <div class="card">
            <img class="card-img-top" src="<?php echo $product['image_url']; ?>" alt="Card image cap">
            <div class="card-body text-center">
                <h1 class="card-title "> <?php echo $product['name']; ?></h1>
                <p class="card-text"> Товара в корзине <?php echo $productsCart['amount']; ?></p>

                <a href="/catalog_page"> В каталог</a>
            </div>

        </div>
    </div>
</div>
<?php endforeach;?>
<style>
    body {
        background-color: #ddeefc;
        color: #dedede;
        padding: 2em;
    }

    .text-center {
        text-align: center;
    }

    .card img {
        max-width: 50%;
        width: 50%;
        padding: 0.5em;
        display: block;
        margin: 0 auto;
    }

    .card {
        margin-top: 30px;
    }

    .card-body {
        background-color: #55b1df;
        padding: 0.5em;
    }

    .btn {
        border: none;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        background-color: rgba(169,11,16,.9);
    }

</style>
