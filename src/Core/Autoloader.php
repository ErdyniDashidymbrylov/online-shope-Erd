<?php

namespace Core;

class Autoloader
{
    public static function register(string $dir)
    {
        $autoload = function (string $className,) use($dir){
            /*   $classnamearray = explode("\\", $classname);
               $classnamespace = $classnamearray[0];
               $classfile = $classnamearray[count($classnamearray) - 1];*/
            //print_r($classnamearray) ;die;
            $path = str_replace('\\', '/', $className);
//    $path = "../".$classnamespace."/".$classfile.".php";
            //print_r($path);die;
            $path = "$dir/$path.php";
            if (file_exists($path)) {
                require_once $path;
                return true;
            }
            return false;
        };
        spl_autoload_register($autoload);
    }
}