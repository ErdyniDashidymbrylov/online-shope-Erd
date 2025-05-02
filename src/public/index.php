<?php


$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/registration') {
    if ($requestMethod === 'GET') {
        require_once './registrationform.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handleregistrationform.php';
    } else {
        echo "$requestMethod для адреса $requestUri не поддерживается!";
    }
} elseif ($requestUri === '/handleregistrationform') {
    if ($requestMethod === 'POST') {
        require_once './handleregistrationform.php';
    } else {
        echo "$requestMethod для адреса $requestUri не поддерживается!";
    }
} elseif ($requestUri === '/login_form') {
    if ($requestMethod === 'GET') {
        require_once './login_form.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_login.php';
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
        require_once './profile.php';
    } else {
        echo "$requestMethod для адреса $requestUri не поддерживается!";
    }
} elseif ($requestUri === '/changeprofile') {
    if ($requestMethod === 'GET') {
        require_once './changeprofile.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handlechangeprofile.php';
    } else {
        echo "$requestMethod для адреса $requestUri не поддерживается!";
    }
} elseif ($requestUri === '/handlechangeprofile') {
    if ($requestMethod === 'POST') {
        require_once './handlechangeprofile.php';
    }
    else {
        echo "$requestMethod для адреса $requestUri не поддерживается!";
    }
}
elseif ($requestUri === '/catalog') {
    if ($requestMethod === 'GET') {
        require_once './catalog.php';
    } else {
        echo "$requestMethod для адреса $requestUri не поддерживается!";
    }
} elseif ($requestUri === '/catalog_page') {
    if ($requestMethod === 'GET') {
        require_once './catalog_page.php';
    } else {
        echo "$requestMethod для адреса $requestUri не поддерживается!";
    }
}
elseif ($requestUri === '/handle_login') {
    if ($requestMethod === 'POST') {
        require_once './handle_login.php';
    } else {
        echo "$requestMethod для адреса $requestUri не поддерживается!";
    }
}
elseif ($requestUri === '/Add_product') {
    if ($requestMethod === 'GET') {
        require_once './add_product_form.php';
    }
        else {
        echo "$requestMethod для адреса $requestUri не поддерживается!";
    }
}
elseif ($requestUri === '/cart') {
    if ($requestMethod === 'GET') {
        require_once './cart.php';
    } else {
        echo "$requestMethod для адреса $requestUri не поддерживается!";
    }
}
elseif ($requestUri === '/handleadd_product_form') {
    require_once './handleadd_product_form.php';
}


else {
    http_response_code(404);
    require_once './404.php';
}


/*
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/registration') {
    if ($requestMethod === 'GET') {
        require_once './registrationform.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handleregistrationform.php';
    } else {
        echo "$requestMethod для адреса $requestUri не поддерживается!";
    }
}
elseif ($requestUri === '/handleregistrationform')
{
    require_once './handleregistrationform.php';
}
elseif ($requestUri === '/registrationform')
{
    require_once './registrationform.php';
}
elseif ($requestUri === '/handle_login')
{
    require_once './handle_login.php';
}
    elseif ($requestUri === '/login')
{
    require_once './login_form.php';

 }
elseif ($requestUri === '/login_form')
{
    require_once './login_form.php';

}
elseif ($requestUri === '/logout')
{
    require_once './logout.php';
    }
elseif ($requestUri === '/profile')
{
    require_once './profile.php';
}
elseif ($requestUri === '/changeprofile')
{
    require_once './changeprofile.php';
}
elseif ($requestUri === '/handlechangeprofile')
{
    require_once './handlechangeprofile.php';
}
    elseif ($requestUri === '/catalog')
{
    require_once './catalog.php';
    }
elseif ($requestUri === '/catalog_page')
{
    require_once './catalog_page.php';
}
    else {
        http_response_code(404);
        require_once './404.php';
}*/




