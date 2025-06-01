<?php

//require_once '../Core/App.php';

$autoload = function (string $classname) {
    $classnamearray = explode("\\", $classname);
    $classnamespace = $classnamearray[0];
    $classfile = $classnamearray[count($classnamearray) - 1];
    //print_r($classnamearray) ;die;

    $path = "../".$classnamespace."/".$classfile.".php";
    //print_r($path);die;
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    return false;
};
spl_autoload_register($autoload);

$app = new \Core\App();
$app->run();

