<?php

namespace Request;

class OrderRequest
{
    public function __construct(private array $data)
    {
    }
    public function getContactName(): string
    {
        return $this->data['contact_name'];
    }
    public function getPhone(): string
    {
        return $this->data['phone'];
    }
    public function getAddress(): string
    {
        return $this->data['address'];
    }
    public function getComment(): string
    {
        return $this->data['comment'];
    }
    public function validateForm()
    {
        $errors = [];
        if (isset($this->data['contact_name'])) {
            $name = $this->data['contact_name'];
            if (strlen($name) < 2) {
                $errors['contact_name'] = "Имя обязательно для заполнения.";
            }
        } else {
            $errors['contact_name'] = "Имя должно быть заполнено.";
        }

        if (isset($this->data['phone'])) {
            $phone = $this->data['phone'];
            if (strlen($phone) < 10) {
                $errors['phone'] = "телефон не может содержать меньше 11 символов.";
            }
        }
        if (isset($this->data['address'])) {
            $address = $this->data['address'];
            if (strlen($address) < 3) {
                $errors['address'] = "адрес не может содержать меньше 3 символов.";
            }
        }

        return $errors;

    }

}

