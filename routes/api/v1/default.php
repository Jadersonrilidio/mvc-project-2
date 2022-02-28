<?php

use App\Http\Response;
use App\Controller\Api;

// ROTA RAIZ DA API
$router->get('/api/v1', array(
    'middlewares' => array(
        'api'
    ),
    function ($request) {
        return new Response(200, Api\Api::getDetails($request), 'application/json');
    }
));
