<?php


$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/registration') {
    if ($requestMethod === 'GET') {
        require_once './registration/registrationform.php';
    } elseif ($requestMethod === 'POST') {
        require_once './registration/handleregistrationform.php';
    } else {
        echo "$requestMethod для адреса $requestUri не поддерживается!";
    }
}/*/elseif ($requestUri === '/handleregistrationform') {
    if ($requestMethod === 'POST') {
        require_once './handleregistrationform.php';
    } else {
        echo "$requestMethod для адреса $requestUri не поддерживается!";
    }
}*/ elseif ($requestUri === '/login') {
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
} /*elseif ($requestUri === '/changeprofile') {
    if ($requestMethod === 'POST') {
        require_once './handlechangeprofile.php';
    }
    else {
        echo "$requestMethod для адреса $requestUri не поддерживается!";
    }
}*/
elseif ($requestUri === '/catalog') {
    if ($requestMethod === 'GET') {
        require_once './catalog/catalog.php';
    } else {
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
/*elseif ($requestUri === '/handleadd_product_form') {
    require_once './handleadd_product_form.php';
}*/


else {
    http_response_code(404);
    require_once './404.php';
}


