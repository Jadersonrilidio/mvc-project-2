<?php

require __DIR__.'/../vendor/autoload.php';

use \App\Utils;

//LOAD ENVIRONMENT VARS FROM FILE ON ROOT
Utils\Environment::load(__DIR__.'/../');

// DEFINE AS CONFIGURACOES DE BANCO DE DADOS
Utils\Database::config(
    getenv('DB_HOST'), 
    getenv('DB_NAME'), 
    getenv('DB_USER'), 
    getenv('DB_PASS'), 
    getenv('DB_PORT')
);

// DEFINE A CONSTANTE DE URL DO PROJETO
define('URL', getenv('URL'));

// DEFINE O VALOR PADRAO DAS VARIAVEIS
Utils\View::init(array(
    'URL' => URL
));

?>