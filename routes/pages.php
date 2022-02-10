<?php

use \App\Http\Response;
use \App\Controller\Pages;

// ROTA HOME
$router->get('/', array(
    function () {
        return new Response(200,Pages\Home::getHome());
    }
)); 

// ROTA SOBRE
$router->get('/about', array(
    function () {
        return new Response(200,Pages\About::getAbout());
    }
));

// ROTA DINAMICA
$router->get('/pagina/{idPagina}/{acao}', array(
    function ($idPagina, $acao) {
        return new Response(200,'pagina '.$idPagina.' - '.$acao);
    }
));


?>