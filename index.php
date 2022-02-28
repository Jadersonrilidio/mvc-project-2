<?php

require __DIR__ . '/includes/app.php';

use \App\Http\Router;

// INICIA O ROUTER
$router = new Router(URL);

// INCLUI AS ROTAS DE PAGINAS
include __DIR__ . '/routes/pages.php';

// INCLUI AS ROTAS DE ADMIN
include __DIR__ . '/routes/admin.php';

// INCLUI AS ROTAS DA API
include __DIR__ . '/routes/api.php';

// IMPRIME O RESPONSE DA ROTA
$router->run()->sendResponse();
