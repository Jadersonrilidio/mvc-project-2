<?php

use \App\Http\Response;
use \App\Controller\Admin;

// ROTA ADMIN   
$router->get('/admin', array(
    'middlewares' => array(
        'require-admin-login'
    ),
    function ($request) {
        return new Response(200,Admin\Home::getHome($request));
    }
)); 

?>