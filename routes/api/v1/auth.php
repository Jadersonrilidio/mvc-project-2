<?php

use App\Http\Response;
use App\Controller\Api;

# ROTA DE AUTORIZACAO DA API
$router->post('/api/v1/auth', array(
    'middlewares' => array(
        'api'
    ),
    function ($request) {
        return new Response(201, Api\Auth::generateToken($request), 'application/json');
    }
));
