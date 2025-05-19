<?php

class Productcontroller
{



    function validateAddProduct(array $data) : array
    {
        $errors = [];

        if (isset($data['amount'])) {
            $amount = $data['amount'];
            if (strlen($amount) < 0) {
                $errors['name'] = "количество должно быть положительным.";
            }
        }
        else  { $errors['amount'] = "количество должно быть заполнено." ;
        }

        if (isset($data['product_id']))
        {
            $product_id = $data['product_id'];
            if (strlen($product_id) < 0) {
                $errors['product_id'] = "id продукта должно быть положительным.";
            }
        } else { $errors['product_id'] = "id продукта должен быть заполнен." ;
        }

        return $errors;
    }


}

$products = new Productcontroller();