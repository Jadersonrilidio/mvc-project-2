<?php

require __DIR__ . '/../vendor/autoload.php';

use \App\Utils;
use \App\Http\Middleware\Queue as MiddlewareQueue;

#LOAD ENVIRONMENT VARS FROM FILE ON ROOT
Utils\Environment::load(__DIR__ . '/../');

# DEFINE AS CONFIGURACOES DE BANCO DE DADOS
Utils\Database::config(
    getenv('DB_DRIVE'),
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT')
);

# DEFINE A CONSTANTE DE URL DO PROJETO
define('URL', getenv('URL'));

# DEFINE O VALOR PADRAO DAS VARIAVEIS
Utils\View::init(array(
    'URL' => URL
));

# DEFINE O MAPEAMENTO DE MIDDLEWARES
MiddlewareQueue::setMap(array(
    'maintenance'          => \App\Http\Middleware\Maintenance::class,
    'require-admin-logout' => \App\Http\Middleware\RequireAdminLogout::class,
    'require-admin-login'  => \App\Http\Middleware\RequireAdminLogin::class,
    'api'                  => \App\Http\Middleware\Api::class,
    'user-basic-auth'      => \App\Http\Middleware\UserBasicAuth::class,
    'jwt-auth'             => \App\Http\Middleware\JWTAuth::class,
    'cache'                => \App\Http\Middleware\Cache::class
));

# DEFINE O MAPEAMENTO DE MIDDLEWARES PADROES, EXECUTADOS EM TODAS AS ROTAS
MiddlewareQueue::setDefault(array(
    'maintenance'
));
