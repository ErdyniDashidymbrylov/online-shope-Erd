<h2>Недавние покупки пользователя</h2>
<?php if (empty($purchases)): ?>
    <p>Нет недавних покупок для этого пользователя.</p>
<?php else: ?>
    <table border='1' cellpadding='5' cellspacing='0'>
        <tr>
            <th>ID</th>
            <th>Название продукта</th>
            <th>Дата покупки</th>
            <th>Цена</th>
        </tr>
        <?php foreach ($purchases as $purchase): ?>
            <tr>
                <td><?= $purchase->id ?></td>
                <td><?= $purchase->product_name ?></td>
                <td><?= $purchase->date ?></td>
                <td><?= $purchase->price ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
