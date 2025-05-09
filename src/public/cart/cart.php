<?php
global $users, $products, $userProducts;
require_once './users.php';
require_once './products.php';
require_once './UserProducts.php';
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
$user = $users->selectUserID($userId);

$productsInCart =$userProducts->selectProductByID($userId);

$productsList = [];

foreach ($productsInCart as $cartItem) {
    $productId = $cartItem['product_id'];

    $product = $products->getProductById($productId);

    if ($product) {
        $productsList[] = $product;
    }
}


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
                foreach ($productsInCart as $cartItem) {
                    if ($cartItem['product_id'] == $productList['id']) {
                        $amountInCart = $cartItem['amount'];
                        break;
                    }
                }
                ?>
                <p class="card-text">  <?php echo "Товар ". $productList['name']. " в корзине: ". $amountInCart; ?></p>
               </div>

    </div>
</div>

<?php endforeach;?>


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
