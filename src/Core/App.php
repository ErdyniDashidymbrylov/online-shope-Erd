<?php
namespace Core;
class App
{
    private array $routes = [
        '/registration' => [
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
        ],
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
            ],
    ];

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

                //require_once "../Controllers/$class.php";

                $controller = new $class();
                $controller->$method();
            } else {
                echo "$requestMethod для адреса $requestUri не поддерживается!";
            }
        } else {
            http_response_code(404);
            require_once './404.php';
        }

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