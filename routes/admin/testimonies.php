<?php

use \App\Http\Response;
use \App\Controller\Admin;

// ROTA TESTIMONIES   
$router->get('/admin/testimonies', array(
    'middlewares' => array(
        'require-admin-login'
    ),
    function ($request) {
        return new Response(200,Admin\Testimony::getTestimonies($request));
    }
)); 

// ROTA DE CADASTRO DE NOVO DEPOIMENTO
$router->get('/admin/testimonies/new', array(
    'middlewares' => array(
        'require-admin-login'
    ),
    function ($request) {
        return new Response(200,Admin\Testimony::getNewTestimony($request));
    }
)); 

// ROTA DE CADASTRO DE NOVO DEPOIMENTO (POST)
$router->post('/admin/testimonies/new', array(
    'middlewares' => array(
        'require-admin-login'
    ),
    function ($request) {
        return new Response(200,Admin\Testimony::setNewTestimony($request));
    }
));

// ROTA DE EDICAO DE DEPOIMENTO
$router->get('/admin/testimonies/{id}/edit', array(
    'middlewares' => array(
        'require-admin-login'
    ),
    function ($request, $id) {
        return new Response(200,Admin\Testimony::getEditTestimony($request, $id));
    }
));

// ROTA DE EDICAO DEPOIMENTO (POST)
$router->post('/admin/testimonies/{id}/edit', array(
    'middlewares' => array(
        'require-admin-login'
    ),
    function ($request, $id) {
        return new Response(200,Admin\Testimony::setEditTestimony($request, $id));
    }
)); 

// ROTA DE EXCLUSAO DE DEPOIMENTO
$router->get('/admin/testimonies/{id}/delete', array(
    'middlewares' => array(
        'require-admin-login'
    ),
    function ($request, $id) {
        return new Response(200,Admin\Testimony::getDeleteTestimony($request, $id));
    }
));

// ROTA DE EXCLUSAO DE DEPOIMENTO (POST)
$router->post('/admin/testimonies/{id}/delete', array(
    'middlewares' => array(
        'require-admin-login'
    ),
    function ($request, $id) {
        return new Response(200,Admin\Testimony::setDeleteTestimony($request, $id));
    }
));

?>