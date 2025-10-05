
<a href="/catalog"> В каталог</a>
<a href="Add_product"> Добавить в корзину</a>

<h1><?php echo "Добро пожаловать, " . $user->getName() . "!". " здесь отображаются ваши товары в корзине"; ?></h1>


<?php foreach ($productsList as $productList):?>
<div class="row">
    <div class="col-sm-12 col-md-3">
        <div class="card">

            <img class="card-img-top" src="<?php echo $productList->getImageUrl(); ?>" alt="Card image cap">
            <div class="card-body text-center">
                <h1 class="card-title "> <?php echo $productList->getName(); ?></h1>
                 </div>
            <?php
                   $amountInCart = 0;
                   $resultSum = 1;
                foreach ($productsInCart as $cartItem) {
                    if ($cartItem->getProductId() == $productList->getId()) {
                        $amountInCart = $cartItem->getAmount();
                        $resultSum = $productList->getPrice() * $amountInCart;
                        break;
                    }
                }
                ?>
                <p class="card-text">  <?php echo "Товар ". $productList->getName(). " в корзине: ". $amountInCart." шт"; ?></p>
            <p><?php echo "Товар на сумму: " . $resultSum. "!"; ?></p>
               </div>

    </div>
</div>
<?php $summa = $summa + $resultSum;?>
<?php endforeach;?>

<h1><?php echo "Товара в корзине на сумму: " . $summa. "!"; ?></h1>
<a href="/Order"> Оформить заказ</a>
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
