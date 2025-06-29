<?php

namespace Request;

class ChangeProfileRequest
{
    public function __construct(private array $data)
    {
    }
    public function getName(): string
    {
        return $this->data['name'];
    }
    public function getEmail(): string
    {
        return $this->data['email'];
    }


    public function validateChangeProfile(): array
    {
        $errors = [];

        if (isset($this->data['name'])) {
            $name = $$this->data['name'];
            if (strlen($name) < 2) {
                $errors['name'] = "Имя обязательно для заполнения.";
            }
        } else {
            $errors['name'] = "Имя должно быть заполнено.";
        }

        if (isset($$this->data['email'])) {
            $email = $$this->data['email'];
            if (strlen($email) < 3) {
                $errors['email'] = "Email не может содержать меньше 3 - х символов.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Некорректный формат email.";
            } else {


                $user = $this->userModel->selectUser($email);

                $userId = $this->authService->getCurrentUserId();
                if ($user !== false) {
                    if ($user->getId() !== $userId) {
                        $errors['email'] = 'Этот Email уже зарегистрирован!';
                    }
                }
            }
        }
        return $errors;
    }


}