<?php

class UserController
{
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

                $userModel = new User();

                $row = $userModel->selectUser($email);
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


                $userModel = new User();

                $user = $userModel->selectUser($email);

                $userId = $_SESSION['userId'];
                if ($user !== false) {
                    if ($user['id'] !== $userId) {
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

        require_once '../Model/User.php';

        $validationErrors = $this->validateRegistration($_POST);
        if (empty($validationErrors)) {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['psw'];
            $passwordRepeat = $_POST['psw-repeat'];

            $userModel = new User();
            $insertUser = $userModel->insertUser($_POST);

            $selectUser = $userModel->selectUser($email);


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
        global $users, $userModel;
        require_once '../Model/User.php';
        $userModel = new User();

        $errors = $this->validateName($_POST);

        if (empty($errors)) {

            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $userModel->selectUser($username);

            if (!empty($user)) {
                $passwordDB = $user['password'];

                if (password_verify($password, $passwordDB)) {
                    session_start();
                    $_SESSION['userId'] = $user['id'];
                    // exit();
                    header("Location: /catalog");
                    exit();
                    //require_once './catalog.php';
                } else {

                    $errors['username'] = 'username or password is incorrect!';
                }
            } else {
                $errors['username'] = 'Пользователь с таким логином не существует!';
            }
        }
        else
        {
            $this->getLogin();
        }

    }

    public function getLogout()
    {
        require_once './logout.php';
    }

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
        global $pdo, $users, $userModel;
        require_once '../Model/User.php';
        $userModel = new User();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit();
        }

        $userId = $_SESSION['userId'];

        $user = $userModel->selectUserID($userId);

        $validationErrors = $this->validateChangeProfile($_POST);

        if (empty($validationErrors)) {

            $name = $_POST['name'];
            $email = $_POST['email'];


            if ($user['name'] !== $name) {
                $userModel->updateUser($name, $userId);
            }

            if ($user['email'] !== $email) {
                $userModel->updateUser($email, $userId);
            }

            header("Location: /profile");
            exit;
        }
         $this->getProfile();
    }




}







