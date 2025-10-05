<?php

$productFeedbacks = $this->feedbackModel->getAllFeedbacks();

?>
<div class="feedbacks-list">
    <a href="/catalog"> В каталог</a>
    <br>
    <br>
    <?php
    $productId = $_POST['product_id'];
    $productinfeedbacks = $this->productModel->getProductById($productId);
    ?>
        <strong>Продукт:</strong> <?php echo $productinfeedbacks->getName(); ?><br>
        <strong>Цена продукта:</strong> <?php echo $productinfeedbacks->getPrice(); ?><br>
        <strong>Описание:</strong> <?php echo $productinfeedbacks->getDescription(); ?><br>
        <strong>Изображение:</strong> <?php echo $productinfeedbacks->getImageUrl(); ?><br>
        <strong>Id продукта:</strong> <?php echo $productinfeedbacks->getId(); ?>
    <h2>Отзывы:</h2>

    <?php
    if(!empty($productFeedbacks)){
        foreach($productFeedbacks as $feedback){
            echo "<p> Имя:" .  $feedback->getUserId(). "</p>";
            echo "<p> Дата:" . $feedback->getDate() . "</p>";
            echo "<p> Отзыв:" . $feedback->getComment() . "</p>";
            echo "<p> Оценка:" . $feedback->getScore(). "</p>";
            echo "<p> id продукта:" . $feedback->getProductId(). "</p>";
            echo "<hr>";

        }
    } else {
        echo "<p>Отзывов еще нет.</p>";
    }
    ?>
</div>

<div class='fb-form'>
    <form action='/Newfeedback' method="POST" class='form-group'>
        <h2>Напишите свой отзыв</h2>

        <input type="hidden" name="product_id" id="product_id" value="<?php echo $productId; ?>">
        <textarea class='form-control' name="comment" id="comment" placeholder='Ваш отзыв!' required></textarea>
        <div style="display: flex; align-items: center; margin-top: 15px;">
            <h5 style="margin: 0; margin-right: 10px;">Ваша оценка продукту</h5>
            <select name="score" id="score" class='form-control' style="width: auto;">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        <br>
        <input class='form-control btn btn-primary' type='submit' value='Отправить'>
    </form>
</div>


<style>
    .feedbacks-list {
        padding: 20px;
        background-color: #f9f9f9;
        margin-bottom: 30px;
    }

    .feedbacks-list a {
        text-decoration: none;
        color: #007bff;
        font-weight: bold;
    }

    .fb-form {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .fb-form h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 10px 15px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #007bff;
        outline: none;
    }

    div[style*="display: flex"] {
        display: flex;
        align-items: center;
        margin-top: 15px;
    }

    div[style*="display: flex"] h5 {
        margin: 0;
        margin-right: 10px;
        font-size: 16px;
        color: #555;
    }

    select.form-control {
        width: auto;
        min-width: 60px;
    }

    .btn {
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>
