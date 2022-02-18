<?php

require __DIR__.'/includes/app.php';

use \App\Http\Router;

// INICIA O ROUTER
$router = new Router(URL);

// INCLUI AS ROTAS DE PAGINAS
include __DIR__.'/routes/pages.php';
include __DIR__.'/routes/admin.php';

// IMPRIME O RESPONSE DA ROTA
$router->run()->sendResponse();

?>