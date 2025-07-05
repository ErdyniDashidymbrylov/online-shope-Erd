<?php

namespace Service\Auth;

use Model\User;

class AuthCookieService implements AuthInterface
{
    protected User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }
    public function auth(string $email, string $password): bool
    {

        $user = $this->userModel->selectUser($email);
        if (!$user) {
            return false;
        } else {
            $passwordDB = $user->getPassword();

            if (password_verify($password, $passwordDB)) {
                setcookie('user_id', $user->getId());
                return true;
            } else {
                return false;
            }
        }
    }

    public function getCurrentUser(): User|null
    {
        if ($this->check()){
            $user = $this->userModel->selectUserID($_COOKIE['userId']);
            return $user;
        } else {
            return null;
        }
    }

    public function check():bool
    {
        return isset($_COOKIE['userId']);

    }

    public function getCurrentUserId():int
    {
        return $_COOKIE['userId'];
    }

    public function logout()
    {
        setcookie('userId', '', time() - 3600, '/');
        unset($_COOKIE['userId']);
    }

}