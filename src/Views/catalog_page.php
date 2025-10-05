<div class="container">
    <a href="/profile"> Мой профиль </a>
    <a href="Add_product"> Добавить в корзину</a>
    <a href="/cart"> Корзина </a>
    <h1>КАТАЛОГ ТОВАРОВ</h1>
    <div class="card-deck">

        <?php foreach ($productsInCatalog as $product):?>

            <br>
            <div class="card text-center">
                <a href="#">
                    <img class="card-img-top" src="<?php echo $product->getImageUrl(); ?>" alt="Card image">
                    <div class="card-body">
                        <p class="card-text text-muted"><h2 style="color:red"><?php echo $product->getName(); ?></h2></p>
                        <a href="#"><h5 class="card-title"><?php echo $product->getDescription(). " id продукта: ". $product->getId(); ?></h5></a>
                        <div class="card-footer">
                            <?php echo $product->getPrice(). " руб."; ?>
                        </div>
                    </div>
                </a>
            </div>

            <form action="/Add_product" method="POST" class="add-product-form" onsubmit="return false">
                <div class="container">
                  <input type="hidden" name="product_id" id="product_id" value="<?php echo $product->getId(); ?>">
                    <label for="amount"><b></b></label>
                    <button type="submit" class="registerbtn">+</button>
                </div>


            </form>
            <form action="/Decrease-product" method="POST">
                <div class="container">
                <input type="hidden" name="product_id" id="product_id" value="<?php echo $product->getId(); ?>">
                    <label for="amount"><b></b></label>
                    <button type="submit" class="registerbtn">-</button>
                </div>

                <hr>

            </form>

            <form action="/Feedback" method="POST">
                <div class="container">
                    <input type="hidden" name="product_id" id="product_id" value="<?php echo $product->getId(); ?>">
                    <button type="submit" class="registerbtn">о продукте</button>
                </div>

                <hr>

            </form>

        <?php endforeach;?>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                $('.add-product-form').submit(function(event) {
                    event.preventDefault();

                    var form = $(this);
                    $.ajax({
                        type: "POST",
                        url: "/Add_product",
                        data: form.serialize(),
                        success: function(response) {
                            console.log('Product added successfully.');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error adding product:', error);
                        }
                    });
                });
            });
        </script>

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