<?php

namespace Request;

class LoginRequest
{
    public function __construct(private array $data) //добавить род класс
    {
    }
    public function getUserName(): string
    {
        return $this->data['username'];
    }
    public function getPassword(): string
    {
        return $this->data['password'];
    }

    public function validate()
    {
        $errors = [];
        if (empty($this->data['username'])) {
            $errors['username'] = "Username обязательно для заполнения";
        }
        if (empty($this->data['password'])) {
            $errors['password'] = 'Поле password обязательно для заполнения';
        }
        return $errors;
    }

}