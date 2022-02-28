<?php

use App\Http\Response;
use App\Controller\Api;

// ROTA DE LISTAGEM DE DEPOIMENTOS
$router->get('/api/v1/testimonies', array(
    'middlewares' => array(
        'api'
    ),
    function ($request) {
        return new Response(200, Api\Testimony::getTestimonies($request), 'application/json');
    }
));

// ROTA DE CONSULTA INDIVIDUAL DE DEPOIMENTOS
$router->get('/api/v1/testimonies/{id}', array(
    'middlewares' => array(
        'api'
    ),
    function ($request, $id) {
        return new Response(200, Api\Testimony::getTestimony($request, $id), 'application/json');
    }
));
