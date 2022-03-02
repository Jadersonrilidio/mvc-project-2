<?php

use App\Http\Response;
use App\Controller\Api;

// ROTA DE LISTAGEM DE USUARIOS
$router->get('/api/v1/users', array(
    'middlewares' => array(
        'api',
        'user-basic-auth'
    ),
    function ($request) {
        return new Response(200, Api\User::getUsers($request), 'application/json');
    }
));

// ROTA DE CONSULTA INDIVIDUAL DE USUARIOS
$router->get('/api/v1/users/{id}', array(
    'middlewares' => array(
        'api',
        'user-basic-auth'
    ),
    function ($request, $id) {
        return new Response(200, Api\User::getUser($request, $id), 'application/json');
    }
));

// ROTA DE CADASTRO DE USUARIOS
$router->post('/api/v1/users', array(
    'middlewares' => array(
        'api',
        'user-basic-auth'
    ),
    function ($request) {
        return new Response(201, Api\User::setNewUser($request), 'application/json');
    }
));

// ROTA DE ATUALIZACAO DE USUARIOS
$router->put('/api/v1/users/{id}', array(
    'middlewares' => array(
        'api',
        'user-basic-auth'
    ),
    function ($request, $id) {
        return new Response(200, Api\User::setEditUser($request, $id), 'application/json');
    }
));

// ROTA DE EXCLUSAO DE USUARIOS
$router->delete('/api/v1/users/{id}', array(
    'middlewares' => array(
        'api',
        'user-basic-auth'
    ),
    function ($request, $id) {
        return new Response(200, Api\User::setDeleteUser($request, $id), 'application/json');
    }
));
