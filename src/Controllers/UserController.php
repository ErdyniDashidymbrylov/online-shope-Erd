<?php

class UserController
{
   public function validateRegistration(array $data) : array
    {
        $errors = [];

        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 2) {
                $errors['name'] = "Имя обязательно для заполнения.";
            }
        }
        else  { $errors['name'] = "Имя должно быть заполнено." ;
        }

        if (isset($data['email'])) {
            $email = $data['email'];
            if (strlen($email) < 3) {
                $errors['email'] = "Email не может содержать меньше 3 - х символов.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Некорректный формат email.";
            } else {
                $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
                $stmt = $pdo->prepare(query: "SELECT COUNT(*) FROM users WHERE email = :email");
                $stmt->execute([':email' => $email]);
                $row = $stmt->fetchColumn();
                if ($row > 0) {
                    $errors['email'] = 'Этот Email уже зарегистрирован!';
                }
            }
        }   else { $errors['email'] = "Емаил должен быть заполнен." ;
        }

        if (isset($data['psw']))
        {
            $password = $data['psw'];
            if (strlen($password)<2) {
                $errors['psw'] = "Пароль не может содержать меньше 2 - х символов.";
            }
            $passwordRepeat = $data['psw-repeat'];
            if ($password !== $passwordRepeat) {
                $errors['psw-repeat'] = "Пароли не совпадают.";
            }
        } else { $errors['psw'] = "Пароль должен быть заполнен." ;
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

   public function validateChangeProfile(array $data) : array
    {
        $errors = [];

        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 2) {
                $errors['name'] = "Имя обязательно для заполнения.";
            }
        }
        else  { $errors['name'] = "Имя должно быть заполнено." ;
        }

        if (isset($data['email'])) {
            $email = $data['email'];
            if (strlen($email) < 3) {
                $errors['email'] = "Email не может содержать меньше 3 - х символов.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Некорректный формат email.";
            } else {
                $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
                $stmt = $pdo->prepare(query: "SELECT * FROM users WHERE email = :email");
                $stmt->execute([':email' => $email]);
                $user = $stmt->fetch();

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
        require_once './registration/registrationform.php';
    }
   public function postRegistration()
   {
       require_once './registration/handleregistrationform.php';
   }
    public function getLogin()
    {
        require_once './login/login_form.php';
    }

    public function postLogin()
    {
        require_once './login/handle_login.php';
    }

    public function getLogout()
    {
        require_once './logout.php';
    }
    public function getProfile()
    {
        require_once './profile/profile.php';
    }
    public function getChangeProfile()
    {
        require_once './profile/changeprofile.php';
    }
    public function postChangeProfile()
    {
        require_once './profile/handlechangeprofile.php';
    }
    public function getCatalog()
    {
        require_once './catalog/catalog.php';
    }
    public function postCatalog()
    {
        require_once './addProduct/handleadd_product_form.php';
    }
    public function getCatalogPage()
    {
        require_once './catalog/catalog_page.php';
    }
    public function getAdd_product()
    {
        require_once './addProduct/add_product_form.php';
    }
    public function postAdd_product()
    {
        require_once './addProduct/handleadd_product_form.php';
    }
    public function getCart()
    {
        require_once './cart/cart.php';
    }


}

$users = new UserController();






