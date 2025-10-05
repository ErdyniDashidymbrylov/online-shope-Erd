<?php
namespace Core;

use Controllers\UserController;
use Controllers\Productcontroller;
use Controllers\OrderController;
use Controllers\UserProductcontroller;
use Model\Logs;
use Service\LoggerService;


class App
{

    private LoggerService $loggerService;
    public function __construct()
    {
       $this->loggerService = new LoggerService();
    }
    public Logs $logsModel;
   /* public function __construct()
    {
        $this->LogsModel = new Logs();
    }*/
    private array $routes = [];
        /*'/registration' => [
            'GET' => [
                'class' => '\Controllers\UserController',
                'method' => 'getRegistration',
            ],
            'POST' => [
                'class' => '\Controllers\UserController',
                'method' => 'postRegistration',
            ],
        ],
        '/login' => [
            'GET' => [
                'class' => '\Controllers\UserController',
                'method' => 'getLogin',
            ],
            'POST' => [
                'class' => '\Controllers\UserController',
                'method' => 'postLogin',
            ],
        ],
        '/logout' => [
            'GET' => [
                'class' => '\Controllers\UserController',
                'method' => 'getLogout',
            ],
        ],
        '/profile' => [
            'GET' => [
                'class' => '\Controllers\UserController',
                'method' => 'getProfile',
            ],
        ],
        '/changeprofile' => [
            'GET' => [
                'class' => '\Controllers\UserController',
                'method' => 'getChangeProfile',
            ],
            'POST' => [
                'class' => '\Controllers\UserController',
                'method' => 'postChangeProfile',
            ],
        ],
        '/catalog' => [
            'GET' => [
                'class' => '\Controllers\Productcontroller',
                'method' => 'getCatalog',
            ],
            'POST' => [
                'class' => '\Controllers\Productcontroller',
                'method' => 'postCatalog',
            ],
        ],
        '/catalog_page' => [
            'GET' => [
                'class' => '\Controllers\Productcontroller',
                'method' => 'getCatalogPage',
            ],

        ],
        '/Add_product' => [
            'GET' => [
                'class' => '\Controllers\UserProductcontroller',
                'method' => 'getAdd_product',
            ],
            'POST' => [
                'class' => '\Controllers\UserProductcontroller',
                'method' => 'postAdd_product',
            ],
        ],
        '/cart' => [
            'GET' => [
                'class' => '\Controllers\UserProductcontroller',
                'method' => 'getCart',
            ],
            /*'POST' => [
                'class' => '\Controllers\UserProductcontroller',
                'method' => 'postCart',
            ],*/
   /*     ],
        '/Order' => [
            'GET' => [
                'class' => '\Controllers\OrderController',
                'method' => 'getCheckoutForm',
            ],
            'POST' => [
                'class' => '\Controllers\OrderController',
                'method' => 'handleCheckoutForm',
            ],
        ],
        '/OrdersView' => [
            'GET' => [
                'class' => '\Controllers\OrderController',
                'method' => 'getOrdersView',
                ],
            ],*/
    //];

    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestUri])) {
            $routeMethods = $this->routes[$requestUri];
            if (isset($routeMethods[$requestMethod])) {
                $handler = $routeMethods[$requestMethod];

                $class = $handler['class'];
                $method = $handler['method'];
                $requestClass  = $handler['request'] ?? null;
                $controller = new $class();

               try {
                    if ($requestClass !== null) {
                        $request = new $requestClass($_POST);
                        $controller->$method($request);
                    }
                    else {
                        $controller->$method();
                    }


                } catch (\Throwable $exception)
                {
                    $this->loggerService->logException($exception);

                    //$this->LogsModel->insertLogs($message,$file,$line, date('Y-m-d H:i:s'));
                }



                //require_once "../Controllers/$class.php";

            } else {
                echo "$requestMethod для адреса $requestUri не поддерживается!";
            }
        } else {
            http_response_code(404);
            require_once '../Views/404.php';
        }

    }

    /*public function addRoute(string $route, string $routeMethod, string $className, string $method)
    {
        $this->routes[$route][$routeMethod] = [
               'class' => $className,
               'method' => $method,
        ];
    }*/

    public function get(string $route, string $className, string $method,string $requestClass = null)
    {
        $this->routes[$route]['GET'] = [
            'class' => $className,
            'method' => $method,
            'request' => $requestClass
        ];
    }
    public function post(string $route, string $className, string $method, string $requestClass  = null)
    {
        $this->routes[$route]['POST'] = [
            'class' => $className,
            'method' => $method,
            'request' => $requestClass,
        ];
    }
    /*    if ($requestUri === '/registration') {
            if ($requestMethod === 'GET') {
                require_once './registration/registrationform.php';
            } elseif ($requestMethod === 'POST') {
                require_once './registration/handleregistrationform.php';
            } else {
                echo "$requestMethod для адреса $requestUri не поддерживается!";
            }
        } elseif ($requestUri === '/login') {
            if ($requestMethod === 'GET') {
                require_once './login/login_form.php';
            } elseif ($requestMethod === 'POST') {
                require_once './login/handle_login.php';
            } else {
                echo "$requestMethod для адреса $requestUri не поддерживается!";
            }

        } elseif ($requestUri === '/logout') {
            if ($requestMethod === 'GET') {
                require_once './logout.php';
            } else {
                echo "$requestMethod для адреса $requestUri не поддерживается!";
            }
        } elseif ($requestUri === '/profile') {
            if ($requestMethod === 'GET') {
                require_once './profile/profile.php';
            } else {
                echo "$requestMethod для адреса $requestUri не поддерживается!";
            }
        } elseif ($requestUri === '/changeprofile') {
            if ($requestMethod === 'GET') {
                require_once './profile/changeprofile.php';
            } elseif ($requestMethod === 'POST') {
                require_once './profile/handlechangeprofile.php';
            } else {
                echo "$requestMethod для адреса $requestUri не поддерживается!";
            }
        }
        elseif ($requestUri === '/catalog') {
            if ($requestMethod === 'GET') {
                require_once './catalog/catalog.php';
            } elseif ($requestMethod === 'POST') {
                require_once './addProduct/handleadd_product_form.php';
            }
            else {
                echo "$requestMethod для адреса $requestUri не поддерживается!";
            }
        } elseif ($requestUri === '/catalog_page') {
            if ($requestMethod === 'GET') {
                require_once './catalog/catalog_page.php';
            } else {
                echo "$requestMethod для адреса $requestUri не поддерживается!";
            }
        }

        elseif ($requestUri === '/Add_product') {
            if ($requestMethod === 'GET') {
                require_once './addProduct/add_product_form.php';
            } elseif ($requestMethod === 'POST') {
                require_once './addProduct/handleadd_product_form.php';
            }
            else {
                echo "$requestMethod для адреса $requestUri не поддерживается!";
            }
        }
        elseif ($requestUri === '/cart') {
            if ($requestMethod === 'GET') {
                require_once './cart/cart.php';
            } else {
                echo "$requestMethod для адреса $requestUri не поддерживается!";
            }
        }



    }*/


}