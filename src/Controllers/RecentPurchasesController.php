<?php

namespace Controllers;

use Model\RecentPurchases;
use Service\Auth\AuthSessionService;

class RecentPurchasesController
{
    private $authService;
    public function __construct()
    {
        $this->authService = new AuthSessionService();
    }

    function getRecentPurchases()
    {
        if ($this->authService->check() === false) {
            header("Location: /login");
            exit();
        }

        $userId = $this->authService->getCurrentUserId();

        $purchases = RecentPurchases::getAllPurchasesByUserId($userId);



        require_once '../Views/Recent_purchases.php';
    }






}