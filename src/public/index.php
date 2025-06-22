<?php
use Controllers\UserController;
use Controllers\Productcontroller;
use Controllers\OrderController;
use Controllers\UserProductcontroller;
use Controllers\FeedbackController;
use Core\App;
use Core\Autoloader;

//require_once '../Core/App.php';
require_once './../Core/Autoloader.php';

/*$autoloader = new Autoloader;
$autoloader->register();*/
$path = dirname(__DIR__);
    \Core\Autoloader::register($path);

$app = new App();

$app->get('/registration',UserController::class, 'getRegistration');
$app->post('/registration',UserController::class, 'postRegistration');

$app->get('/login',UserController::class, 'getLogin');
$app->post('/login',UserController::class, 'postLogin');

$app->get('/logout',UserController::class, 'logout');

$app->get('/profile',UserController::class, 'getProfile');

$app->get('/changeprofile',UserController::class, 'getChangeprofile');
$app->post('/changeprofile',UserController::class, 'postChangeprofile');

$app->get('/catalog',Productcontroller::class, 'getCatalog');
$app->post('/catalog',Productcontroller::class, 'postCatalog');

$app->get('/catalog_page',Productcontroller::class, 'getCatalogPage');

$app->get('/Add_product',UserProductcontroller::class, 'getAdd_product');
$app->post('/Add_product',UserProductcontroller::class, 'postAdd_product');
$app->post('/Decrease-product',UserProductcontroller::class, 'postDecreaseProduct');
$app->post('/Feedback',FeedbackController::class, 'postFeedback');
$app->post('/Newfeedback',FeedbackController::class, 'handleFeedback');

$app->get('/cart',UserProductcontroller::class, 'getCart');
$app->post('/cart',UserProductcontroller::class, 'postCart');

$app->get('/Order',OrderController::class, 'getCheckoutForm');
$app->post('/Order',OrderController::class, 'handleCheckoutForm');

$app->get('/OrdersView',OrderController::class, 'getOrdersView');

$app->run();

