<?php

use \App\Http\Response;
use \App\Controller\Admin;

// ROTA ADMIN   
$router->get('/admin', array(
    'middlewares' => array(
        'require-admin-login'
    ),
    function () {
        return new Response(200,"Pagina de admin ainda nao existe!");
    }
)); 

// ROTA LOGIN
$router->get('/admin/login', array(
    'middlewares' => array(
        'require-admin-logout'
    ),
    function ($request) {
        return new Response(200,Admin\Login::getLogin($request));
    }
));

// ROTA LOGIN (POST)   
$router->post('/admin/login', array(
    'middlewares' => array(
        'require-admin-logout'
    ),
    function ($request) {
        return new Response(200,Admin\Login::setLogin($request));
    }
));

// ROTA LOGOUT
$router->get('/admin/logout', array(
    'middlewares' => array(
        'require-admin-login'
    ),
    function ($request) {
        return new Response(200,Admin\Login::setLogout($request));
    }
));

?>