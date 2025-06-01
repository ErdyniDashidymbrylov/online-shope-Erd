<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <title>Мои заказы</title>
    <style>
        /* Ваши стили */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        .order {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 30px;
            border-radius: 8px;
        }
        .order-header {
            font-weight: bold;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        .total {
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h1>Мои заказы</h1>

    <?php foreach ($newUserOrders as $newUserOrder): ?>
        <div class="order">
            <h2>Заказ №<?php echo $newUserOrder['id']?> </h2>
            <p> Имя заказчика:  <?php echo $newUserOrder['contact_name'] ?></p>
            <p> Контактный телефон: <?php echo $newUserOrder['phone'] ?></p>
            <p> Комментарий к заказу: <?php echo $newUserOrder['comment'] ?></p>
            <p> Адрес заказа: <?php echo $newUserOrder['address'] ?></p>

                   <table>
                    <thead>
                    <tr>
                        <th>Название продукта</th>
                        <th>Изображение</th>
                        <th>Количество</th>
                        <th>Стоимость</th>
                        <th>Общая сумма</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($newUserOrder['products'] as $newOrderProduct): ?>
                        <tr>
                            <td><?php echo $newOrderProduct['name']?></td>
                            <td><?php echo $newOrderProduct['amount']?></td>
                            <td><?php echo $newOrderProduct['price']?></td>
                            <td><?php echo $newOrderProduct['totalsum']?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="total">Общая сумма заказа: <?php echo $newUserOrder['total']?> ₽</div>
        </div>
    <?php endforeach; ?>

</body>
</html>