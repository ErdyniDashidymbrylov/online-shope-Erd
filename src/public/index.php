<?php
use Controllers\UserController;
use Controllers\Productcontroller;
use Controllers\OrderController;
use Controllers\UserProductcontroller;
use Core\App;
//require_once '../Core/App.php';

$autoload = function (string $className) {
 /*   $classnamearray = explode("\\", $classname);
    $classnamespace = $classnamearray[0];
    $classfile = $classnamearray[count($classnamearray) - 1];*/
    //print_r($classnamearray) ;die;
    $path = str_replace('\\', '/', $className);
//    $path = "../".$classnamespace."/".$classfile.".php";
    //print_r($path);die;
    $path = "./../".$path. ".php";
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    return false;
};
spl_autoload_register($autoload);

$app = new App();

$app->addRoute('/registration','GET',UserController::class, 'getRegistration');
$app->addRoute('/registration','POST',UserController::class, 'postRegistration');

$app->addRoute('/login','GET',UserController::class, 'getLogin');
$app->addRoute('/login','POST',UserController::class, 'postLogin');

$app->addRoute('/logout','GET',UserController::class, 'getLogout');

$app->addRoute('/profile','GET',UserController::class, 'getProfile');

$app->addRoute('/changeprofile','GET',UserController::class, 'getChangeprofile');
$app->addRoute('/changeprofile','POST',UserController::class, 'postChangeprofile');

$app->addRoute('/catalog','GET',Productcontroller::class, 'getCatalog');
$app->addRoute('/catalog','POST',Productcontroller::class, 'postCatalog');

$app->addRoute('/catalog_page','GET',Productcontroller::class, 'getCatalogPage');

$app->addRoute('/Add_product','GET',UserProductcontroller::class, 'getAdd_product');
$app->addRoute('/Add_product','POST',UserProductcontroller::class, 'postAdd_product');

$app->addRoute('/cart','GET',UserProductcontroller::class, 'getCart');
$app->addRoute('/cart','POST',UserProductcontroller::class, 'postCart');

$app->addRoute('/Order','GET',OrderController::class, 'getCheckoutForm');
$app->addRoute('/Order','POST',OrderController::class, 'handleCheckoutForm');

$app->addRoute('/OrdersView','GET',OrderController::class, 'getOrdersView');

$app->run();

