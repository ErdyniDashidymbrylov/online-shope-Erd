<?php

class App
{
    private array $routes = [
        '/registration' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getRegistration',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'postRegistration',
            ],
        ],
        '/login' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getLogin',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'postLogin',
            ],
        ],
        '/logout' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getLogout',
            ],
        ],
        '/profile' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getProfile',
            ],
        ],
        '/changeprofile' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getChangeProfile',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'postChangeProfile',
            ],
        ],
        '/catalog' => [
            'GET' => [
                'class' => 'Productcontroller',
                'method' => 'getCatalog',
            ],
            'POST' => [
                'class' => 'Productcontroller',
                'method' => 'postCatalog',
            ],
        ],
        '/catalog_page' => [
            'GET' => [
                'class' => 'Productcontroller',
                'method' => 'getCatalogPage',
            ],

        ],
        '/Add_product' => [
            'GET' => [
                'class' => 'UserProductcontroller',
                'method' => 'getAdd_product',
            ],
            'POST' => [
                'class' => 'UserProductcontroller',
                'method' => 'postAdd_product',
            ],
        ],
        '/cart' => [
            'GET' => [
                'class' => 'UserProductcontroller',
                'method' => 'getCart',
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

                require_once "../Controllers/$class.php";
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