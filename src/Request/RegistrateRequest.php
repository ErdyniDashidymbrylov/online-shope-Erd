<?php

namespace Request;


use Model\User;

class RegistrateRequest
{
    protected User $userModel;
    public function __construct(private array $data)
    {
        $this->userModel = new User();
    }

    public function getName()
    {
        return $this->data['name'];
    }
    public function getEmail()
    {
        return $this->data['email'];
    }
    public function getPassword()
    {
        return $this->data['psw'];
    }
    public function getPasswordRepeat()
    {
        return $this->data['psw-repeat'];
    }

    public function validateRegistration(): array
    {
        $errors = [];

        if (isset($this->data['name'])) {
            $name = $this->data['name'];
            if (strlen($name) < 2) {
                $errors['name'] = "Имя обязательно для заполнения.";
            }
        } else {
            $errors['name'] = "Имя должно быть заполнено.";
        }

        if (isset($this->data['email'])) {
            $email = $this->data['email'];
            if (strlen($email) < 3) {
                $errors['email'] = "Email не может содержать меньше 3 - х символов.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Некорректный формат email.";
            } else {

                $row = $this->userModel->selectUser($email);
                if ($row > 0) {
                    $errors['email'] = 'Этот Email уже зарегистрирован!';
                }
            }
        } else {
            $errors['email'] = "Емаил должен быть заполнен.";
        }

        if (isset($this->data['psw'])) {
            $password = $this->data['psw'];
            if (strlen($password) < 2) {
                $errors['psw'] = "Пароль не может содержать меньше 2 - х символов.";
            }
            $passwordRepeat = $this->data['psw-repeat'];
            if ($password !== $passwordRepeat) {
                $errors['psw-repeat'] = "Пароли не совпадают.";
            }
        } else {
            $errors['psw'] = "Пароль должен быть заполнен.";
        }

        return $errors;
    }




}