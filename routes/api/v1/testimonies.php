<?php

use App\Http\Response;
use App\Controller\Api;

// ROTA DE LISTAGEM DE DEPOIMENTOS
$router->get('/api/v1/testimonies', array(
    'middlewares' => array(
        'api',
        'cache'
    ),
    function ($request) {
        return new Response(200, Api\Testimony::getTestimonies($request), 'application/json');
    }
));

// ROTA DE CONSULTA INDIVIDUAL DE DEPOIMENTOS
$router->get('/api/v1/testimonies/{id}', array(
    'middlewares' => array(
        'api',
        'cache'
    ),
    function ($request, $id) {
        return new Response(200, Api\Testimony::getTestimony($request, $id), 'application/json');
    }
));

// ROTA DE CADASTRO DE DEPOIMENTOS
$router->post('/api/v1/testimonies', array(
    'middlewares' => array(
        'api',
        'user-basic-auth'
    ),
    function ($request) {
        return new Response(201, Api\Testimony::setNewTestimony($request), 'application/json');
    }
));

// ROTA DE ATUALIZACAO DE DEPOIMENTOS
$router->put('/api/v1/testimonies/{id}', array(
    'middlewares' => array(
        'api',
        'user-basic-auth'
    ),
    function ($request, $id) {
        return new Response(200, Api\Testimony::setEditTestimony($request, $id), 'application/json');
    }
));

// ROTA DE EXCLUSAO DE DEPOIMENTOS
$router->delete('/api/v1/testimonies/{id}', array(
    'middlewares' => array(
        'api',
        'user-basic-auth'
    ),
    function ($request, $id) {
        return new Response(200, Api\Testimony::setDeleteTestimony($request, $id), 'application/json');
    }
));