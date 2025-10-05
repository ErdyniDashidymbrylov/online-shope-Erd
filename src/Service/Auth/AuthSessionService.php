<?php

namespace Service\Auth;

use Model\User;

class AuthSessionService implements AuthInterface
{
    protected User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }
    private function startSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
    public function auth(string $email, string $password): bool
    {
       // throw new \AssertionError('asd');
        $user = User::selectUser($email);
        if (!$user) {
            return false;
        } else {
            $passwordDB = $user->getPassword();

            if (password_verify($password, $passwordDB)) {
                $this->startSession();
                $_SESSION['userId'] = $user->getId();
                return true;
            } else {
                return false;
            }
        }
    }

    public function getCurrentUser(): User|null
    {
        $this->startSession();
        if ($this->check()){
            $user = $this->userModel->selectUserID($_SESSION['userId']);
            return $user;
        } else {
            return null;
        }
    }

    public function check():bool
    {
        $this->startSession();
        return isset($_SESSION['userId']);

    }

    public function getCurrentUserId():int
    {
        $this->startSession();
        return $_SESSION['userId'];
    }

    public function logout()
    {
        $this->startSession();
        session_destroy();
    }



}