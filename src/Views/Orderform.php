<?php
    $userModel = new \Model\User();
    $userProductModel = new \Model\UserProduct();
    $productModel = new \Model\Product();

     if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (!isset($_SESSION['userId'])) {
        header("Location: /login");
        exit();
    }

    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];}

    $user = $userModel->selectUserID($userId);

    $productsInCart =$userProductModel->selectProductByID($userId);

    $productsList = [];

    foreach ($productsInCart as $cartItem) {
        $productId = $cartItem['product_id'];

        $product = $productModel->getProductById($productId);

        if ($product) {
            $productsList[] = $product;
        }
    }

    $summa = 0;

?>


<form action="/Order" method="POST">
    <div class="container">
        <h1>Оформление Заказа</h1>

        <a href="/catalog"> В каталог</a>

        <h1><?php echo "Добро пожаловать, " . $user['name'] . "!". " здесь отображаются ваши товары в корзине"; ?></h1>


        <?php foreach ($productsList as $productList):?>
            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <div class="card">

                        <img class="product-image" src="<?php echo $productList['image_url']; ?>" alt="Card image cap">
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
                        <p><?php echo "Товар ". $productList['name']. " на сумму: " . $resultSum. "!"; ?></p>
                    </div>

                </div>
            </div>
            <?php $summa = $summa + $resultSum;?>
        <?php endforeach;?>

        <h1><?php echo "Товара в корзине на сумму: " . $summa. "!"; ?></h1>

        <hr>
        <label for="contact_name"><b>Имя</b></label>
        <?php if(isset($errors['contact_name'])): ?>
            <label style="color:red"><?php echo $errors['contact_name']; ?></label>
        <?php endif; ?>
        <input type="text" placeholder="Введите Имя" name="contact_name" id="contact_name" required>

        <label for="adress"><b>Адрес</b></label>
        <?php if(isset($errors['address'])): ?>
            <label style="color:red"><?php echo $errors['address']; ?></label>
        <?php endif; ?>
        <input type="text" placeholder="Введите Адрес" name="address" id="address" required>

        <label for="phone"><b>Телефон</b></label>
        <?php if(isset($errors['phone'])): ?>
            <label style="color:red"><?php echo $errors['phone']; ?></label>
        <?php endif; ?>
        <input type="text" placeholder="Введите телефон" name="phone" id="phone" required>

        <label for="comment"><b>Комментарий к заказу</b></label>
        <?php if(isset($errors['comment'])): ?>
            <label style="color:red"><?php echo $errors['comment']; ?></label>
        <?php endif; ?>
        <input type="text" placeholder="Введите Комментарий" name="comment" id="comment" required>


        <hr>

        <button type="submit" class="registerbtn">Оформить заказ</button>
    </div>

</form>



<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: #ddeefc;
    }

    * {
        box-sizing: border-box;
    }

    /* Add padding to containers */
    .container {
        padding: 16px;
        background-color: white;
    }

    /* Full-width input fields */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for the submit button */
    .registerbtn {
        background-color: #55b1df;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .registerbtn:hover {
        opacity: 1;
    }

    a {
        color: dodgerblue;
    }

  {
        background-color: #f1f1f1;
        text-align: center;
    }
    .product-image {
        width: 150px;
        height: auto;
        object-fit: cover;
        margin-bottom: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        display: block;

    }
</style>