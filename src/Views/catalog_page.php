<div class="container">
    <a href="/profile"> Мой профиль </a>
    <a href="Add_product"> Добавить в корзину</a>
    <h1>КАТАЛОГ ТОВАРОВ</h1>
    <div class="card-deck">

        <?php foreach ($productsInCatalog as $product):?>

            <br>
            <div class="card text-center">
                <a href="#">
                    <img class="card-img-top" src="<?php echo $product['image_url']; ?>" alt="Card image">
                    <div class="card-body">
                        <p class="card-text text-muted"><h2 style="color:red"><?php echo $product['name']; ?></h2></p>
                        <a href="#"><h5 class="card-title"><?php echo $product['description']. " id продукта: ". $product['id']; ?></h5></a>
                        <div class="card-footer">
                            <?php echo $product['price']. " руб."; ?>
                        </div>
                    </div>
                </a>
            </div>

            <form action="/Add_product" method="POST">
                <div class="container">
                    <h3>Добавить в корзину</h3>

                    <input type="hidden" placeholder="Enter Product-id" name="product_id" id="product_id" value="<?php echo $product['id']; ?>">

                    <label for="amount"><b></b></label>
                    <?php if(isset($errors['email'])): ?>
                        <label style="color:red"><?php echo $errors['amount']; ?></label>
                    <?php endif; ?>
                    <input type="text" placeholder="Введите количество" name="amount" id="amount" required>
                    <button type="submit" class="registerbtn">Добавить</button>
                </div>

              <hr>

            </form>

        <?php endforeach;?>

        <style>
            body {
                font-style: sans-serif;
                background-color: #ddeefc;
            }

            a {
                text-decoration: none;
            }

            a:hover {
                text-decoration: none;
            }

            h3 {
                line-height: 3em;
            }

            .card {
                max-width: 16rem;
                background-color: white;
            }

            .card:hover {
                box-shadow: 1px 2px 10px lightgray;
                transition: 0.2s;
            }

            .card-header {
                font-size: 13px;
                color: gray;
                background-color: white;
            }

            .text-muted {
                font-size: 11px;
            }

            .card-footer{
                font-weight: bold;
                font-size: 18px;
                background-color: #f8f067;
            }


            .card-img-top {
                width: 100%;
                height: 200px;
                object-fit: cover;
            }
        </style>