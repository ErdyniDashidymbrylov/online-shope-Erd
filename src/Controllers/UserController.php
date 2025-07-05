<?php
namespace Controllers;

//require_once '../Model/User.php';

use Model\Product;
use Model\User;
use Request\ChangeProfileRequest;
use Request\LoginRequest;
use Request\RegistrateRequest;
use Service\Auth\AuthSessionService;

class UserController extends BaseController

{
    protected Product $productModel;

    protected User $userModel;
    private AuthSessionService $authService;


    public function __construct()
    {
        $this->productModel = new Product();
        $this->userModel = new User();
        $this->authService = new AuthSessionService();
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



    public function getRegistration()
    {
        require_once '../Views/registrationform.php';
    }

    public function postRegistration(RegistrateRequest $request)
    {


        $validationErrors = $request->validateRegistration();
        if (empty($validationErrors)) {

            $insertUser = $this->userModel->insertUser($request->getName(),$request->getEmail(),$request->getPassword());

            $selectUser = $this->userModel->selectUser($request->getEmail());


            $this->getLogin();

        } else {

            $this->getRegistration();

        }
    }

    public function getLogin()
    {
        require_once '../Views/login_form.php';
    }



    public function postLogin(LoginRequest $request)
    {

        $errors = $request->validateName();


        if (empty($errors)) {

            $result = $this->authService->auth($request->getUserName(), $request->getPassword());

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

    public function postChangeProfile(ChangeProfileRequest $request)
    {


        if ($this->authService->check() === false) {
            header("Location: /login");
            exit();
        }

        $userId = $this->authService->getCurrentUserId();

        $user = $this->userModel->selectUserID($userId);

        $validationErrors = $request->validateChangeProfile();

        if (empty($validationErrors)) {

            $name = $request->getName();
            $email = $request->getEmail();


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
 