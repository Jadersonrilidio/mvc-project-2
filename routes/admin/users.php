<?php

use \App\Http\Response;
use \App\Controller\Admin;

// ROTA USERS   
$router->get('/admin/users', array(
    'middlewares' => array(
        'require-admin-login'
    ),
    function ($request) {
        return new Response(200,Admin\User::getUsers($request));
    }
)); 

// ROTA DE CADASTRO DE NOVO USUARIO
$router->get('/admin/users/new', array(
    'middlewares' => array(
        'require-admin-login'
    ),
    function ($request) {
        return new Response(200,Admin\User::getNewUser($request));
    }
)); 

// ROTA DE CADASTRO DE NOVO USUARIO (POST)
$router->post('/admin/users/new', array(
    'middlewares' => array(
        'require-admin-login'
    ),
    function ($request) {
        return new Response(200,Admin\User::insertNewUser($request));
    }
));

// ROTA DE EDICAO DE USUARIO
$router->get('/admin/users/{id}/edit', array(
    'middlewares' => array(
        'require-admin-login'
    ),
    function ($request, $id) {
        return new Response(200,Admin\User::getEditUser($request, $id));
    }
));

// ROTA DE EDICAO USUARIO (POST)
$router->post('/admin/users/{id}/edit', array(
    'middlewares' => array(
        'require-admin-login'
    ),
    function ($request, $id) {
        return new Response(200,Admin\User::setEditUser($request, $id));
    }
)); 

// ROTA DE EXCLUSAO DE USUARIO
$router->get('/admin/users/{id}/delete', array(
    'middlewares' => array(
        'require-admin-login'
    ),
    function ($request, $id) {
        return new Response(200,Admin\User::getDeleteUser($request, $id));
    }
));

// ROTA DE EXCLUSAO DE USUARIO (POST)
$router->post('/admin/users/{id}/delete', array(
    'middlewares' => array(
        'require-admin-login'
    ),
    function ($request, $id) {
        return new Response(200,Admin\User::setDeleteUser($request, $id));
    }
));

?>