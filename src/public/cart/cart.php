<?php
global $users, $products, $userProducts, $userModel, $userProductModel, $productModel;
require_once '../Model/User.php';
require_once '../Model/Product.php';
require_once '../Model/UserProduct.php';
/*if (!isset($_SESSION['userId'])) {
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

   die;*/


if (!isset($_SESSION['userId'])) {
    header("Location: /login");
    exit();
}

$userId = $_SESSION['userId'];

$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');

/*$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);*/
$user = $userModel->selectUserID($userId);

$productsInCart =$userProductModel->selectProductByID($userId);

$productsList = [];
if (!isset($productModel)) {
    $productModel = new Product();
}

foreach ($productsInCart as $cartItem) {
    $productId = $cartItem['product_id'];

    $product = $productModel->getProductById($productId);

    if ($product) {
        $productsList[] = $product;
    }
}

$summa = 0;

?>
<a href="/catalog"> В каталог</a>
<a href="Add_product"> Добавить в корзину</a>
<h1><?php echo "Добро пожаловать, " . $user['name'] . "!". " здесь отображаются ваши товары в корзине"; ?></h1>


<?php foreach ($productsList as $productList):?>
<div class="row">
    <div class="col-sm-12 col-md-3">
        <div class="card">

            <img class="card-img-top" src="<?php echo $productList['image_url']; ?>" alt="Card image cap">
            <div class="card-body text-center">
                <h1 class="card-title "> <?php echo $productList['name']; ?></h1>
                 </div>
            <?php
                   $amountInCart = 0;
                   $resultSum = 1;
                foreach ($productsInCart as $cartItem) {
                    if ($cartItem['product_id'] == $productList['id']) {
                        $amountInCart = $cartItem['amount'];
                        $resultSum = $productList['price'] * $amountInCart;
                        break;
                    }
                }
                ?>
                <p class="card-text">  <?php echo "Товар ". $productList['name']. " в корзине: ". $amountInCart." кг"; ?></p>
            <p><?php echo "Товар на сумму: " . $resultSum. "!"; ?></p>
               </div>

    </div>
</div>
<?php $summa = $summa + $resultSum;?>
<?php endforeach;?>

<h1><?php echo "Товара в корзине на сумму: " . $summa. "!"; ?></h1>
<style>
    body {
        background-color: #ddeefc;
        color: #333;
        padding: 2em;
    }

    .text-center {
        text-align: center;
    }

   {
        display: flex;
        flex-direction: column; /* Вертикальное расположение */
        align-items: flex-start; /* Выравнивание по левому краю */
        gap: 20px; /* Отступ между товарами */
    }

    /* Карточка товара */
    .card {
        width: 400px; /* Фиксированная ширина для удобства */
        background-color: #55b1df;
        padding: 0.5em;
        border-radius: 2px;
    }

    /* Изображение товара */
    .card img {
        max-width: 100%;
        width: 100%;
        display: block;
        margin-bottom: 0.5em; /* Отступ снизу для текста */
    }

    /* Текст и описание под изображением */
    .card-body {
        color: #fff; /* Цвет текста внутри карточки */
    }

</style>
