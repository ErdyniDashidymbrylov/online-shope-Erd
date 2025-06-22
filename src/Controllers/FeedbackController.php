<?php

namespace Controllers;

use Model\Feedback;
use Model\Product;
use Service\AuthService;

class FeedbackController extends BaseController
{

    private Feedback $feedbackModel;
    private Product $productModel;
    private AuthService $authService;

    public function __construct()
    {

        $this->feedbackModel = new Feedback();
        $this->productModel = new Product();
        $this->authService = new AuthService();
    }
    public function postFeedback()
    {

        $productId = $_POST['product_id'];

        $productFeedbacks = $this->feedbackModel->getAllFeedbacks();

        $this->feedbackModel->setProductId($productId);

        $productinfeedbacks = $this->productModel->getProductById($productId);

    /*  echo "<pre>";
        print_r($productinfeedback);
        echo "</pre>";
        die();*/

        $this->getFeedback();

    }

    public function handleFeedback()
    {
        if ($this->authService->check() === false) {
            header("Location: /login");
            exit();
        }
        $productId = $_POST['product_id'];
        $comment = $_POST['comment'];
        $score = $_POST['score'];
        $date = date("Y-m-d H:i:s");
        $userId = $this->authService->getCurrentUserId();

        $this->feedbackModel->insertFeedback($userId, $comment, $score, $date, $productId);

        $this->getFeedback();
    }

    public function getFeedback()
    {
        require_once "./../Views/Feedbackview.php";
    }


}