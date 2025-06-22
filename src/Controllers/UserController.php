<?php
namespace Controllers;

//require_once '../Model/User.php';

use Model\Order;
use Model\Product;
use Model\User;
use Model\UserProduct;
use Service\AuthService;

class UserController extends BaseController

{
    protected Product $productModel;

    protected User $userModel;
    private AuthService $authService;


    public function __construct()
    {
        $this->productModel = new Product();
        $this->userModel = new User();
        $this->authService = new AuthService();
    }

    private function validateRegistration(array $data): array
    {
        $errors = [];

        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 2) {
                $errors['name'] = "Имя обязательно для заполнения.";
            }
        } else {
            $errors['name'] = "Имя должно быть заполнено.";
        }

        if (isset($data['email'])) {
            $email = $data['email'];
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

        if (isset($data['psw'])) {
            $password = $data['psw'];
            if (strlen($password) < 2) {
                $errors['psw'] = "Пароль не может содержать меньше 2 - х символов.";
            }
            $passwordRepeat = $data['psw-repeat'];
            if ($password !== $passwordRepeat) {
                $errors['psw-repeat'] = "Пароли не совпадают.";
            }
        } else {
            $errors['psw'] = "Пароль должен быть заполнен.";
        }

        return $errors;
    }


    /*    public function validateName(array $data): array
        {
            $errors = [];
            if (empty($data['username'])) {
                $errors['username'] = "Username обязательно для заполнения";
            }
            if (empty($data['password'])) {
                $errors['password'] = 'Поле password обязательно для заполнения';
            }
            return $errors;
        }*/

    public function validateChangeProfile(array $data): array
    {
        $errors = [];

        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 2) {
                $errors['name'] = "Имя обязательно для заполнения.";
            }
        } else {
            $errors['name'] = "Имя должно быть заполнено.";
        }

        if (isset($data['email'])) {
            $email = $data['email'];
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

    public function getRegistration()
    {
        require_once '../Views/registrationform.php';
    }

    public function postRegistration()
    {


        $validationErrors = $this->validateRegistration($_POST);
        if (empty($validationErrors)) {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['psw'];
            $passwordRepeat = $_POST['psw-repeat'];

            $insertUser = $this->userModel->insertUser($_POST);

            $selectUser = $this->userModel->selectUser($email);


            $this->getLogin();

        } else {

            $this->getRegistration();

        }
    }

    public function getLogin()
    {
        require_once '../Views/login_form.php';
    }

    private function validateName($data)
    {
        $errors = [];
        if (empty($data['username'])) {
            $errors['username'] = "Username обязательно для заполнения";
        }
        if (empty($data['password'])) {
            $errors['password'] = 'Поле password обязательно для заполнения';
        }
        return $errors;
    }

    public function postLogin()
    {

        $data = $_POST;
        $errors = $this->validateName($_POST);


        if (empty($errors)) {

            $result = $this->authService->auth($_POST['username'], $_POST['password']);

            if ($result === true) {
                header("Location: /catalog");
                exit();
            } else {
                $errors['autorization'] ='email или пароль неверный' ;
            }
        }
        $this->getLogin();

    }

 /*   public function getLogout()
    {
        require_once './logout.php';
    }*/

    public function getProfile()
    {
        require_once '../Views/profile.php';
    }

    public function getChangeProfile()
    {
        require_once '../Views/changeprofile.php';

    }

    public function postChangeProfile()
    {


        if ($this->authService->check() === false) {
            header("Location: /login");
            exit();
        }

        $userId = $this->authService->getCurrentUserId();

        $user = $this->userModel->selectUserID($userId);

        $validationErrors = $this->validateChangeProfile($_POST);

        if (empty($validationErrors)) {

            $name = $_POST['name'];
            $email = $_POST['email'];


            if ($user->getName() !== $name) {
                $this->userModel->updateUser($name, $userId);
            }

            if ($user->getEmail() !== $email) {
                $this->userModel->updateUser($email, $userId);
            }

            header("Location: /profile");
            exit;
        }
    }
    public function logout()
    {
        $this->authService->logout();
        header("Location: /login");
        exit;
    }
}
 