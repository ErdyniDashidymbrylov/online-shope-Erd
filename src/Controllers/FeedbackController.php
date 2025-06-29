<?php

namespace Controllers;

use Model\Feedback;
use Model\Product;
use Request\FeedbackRequest;
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
    public function postFeedback(FeedbackRequest $request)
    {

        $productId = $request->getProductId();

        $productFeedbacks = $this->feedbackModel->getAllFeedbacks();

        $this->feedbackModel->setProductId($productId);

        $productinfeedbacks = $this->productModel->getProductById($productId);

    /*  echo "<pre>";
        print_r($productinfeedback);
        echo "</pre>";
        die();*/

        $this->getFeedback();

    }

    public function handleFeedback(FeedbackRequest $request)
    {
        if ($this->authService->check() === false) {
            header("Location: /login");
            exit();
        }
        $productId =$request->getProductId();
        $comment = $request->getComment();
        $score = $request->getScore();
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