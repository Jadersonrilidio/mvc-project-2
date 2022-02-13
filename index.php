<?php

require __DIR__.'/vendor/autoload.php';

use \App\Http\Router;
use \App\Utils\View;
use \App\Utils\Environment;

//LOAD ENVIRONMENT VARS FROM FILE ON ROOT
Environment::load(__DIR__);

define('URL', getenv('URL'));

// DEFINE O VALOR PADRAO DAS VARIAVEIS
View::init(array(
    'URL' => URL
));

// INICIA O ROUTER
$router = new Router(URL);

// INCLUI AS ROTAS DE PAGINAS
include __DIR__.'/routes/pages.php';

// IMPRIME O RESPONSE DA ROTA
$router->run()->sendResponse();

?>