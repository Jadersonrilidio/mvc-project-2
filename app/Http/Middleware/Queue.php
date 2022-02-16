<?php

namespace App\Http\Middleware;

use \Closure;

class Queue {

    /**
     * Mapeamento de middlewares [apelido, alias, classe que corresponde]
     * @var array
     */
    private static $map = array();

    /**
     * Mapeamento de middlewares que serao carregados em todas as rotas
     * @var array
     */
    private static $default = array();

    /**
     * Fila de middlewaresa serem executados
     * @var array
     */
    private $middlewares = array();

    /**
     * Funcao de execucao do controlador
     * @var Closure
     */
    private $controller;

    /**
     * Argumentos da funcao do controlador
     * @var array
     */
    private $controllerArgs = array();

    /**
     * Metodo responsavel por contruir a classe de fila de Middlewares
     * @param array $middlewares
     * @param Closure $controller
     * @param array $controllerArgs
     */
    public function __construct($middlewares, $controller, $controllerArgs) {
        $this->middlewares = array_merge(self::$default, $middlewares);
        $this->controller = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    /**
     * Metodo responsavel por definir o mapeamento de middlewares
     * @param array $map
     */
    public static function setMap($map) {
        self::$map = $map;
    }

    /**
     * Metodo responsavel por definir o mapeamento de middlewares padroes
     * @param array $default
     */
    public static function setDefault($default) {
        self::$default = $default;
    }

    /** Metodo responsavel por executar o proximo nivel da fila de middlewares 
     * @param Request
     * @return Response
     */
    public function next($request) {
        // VERIFICA SE A FILA ESTA VAZIA
        if (empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);

        // PEGA NOME DO PROXIMO MIDDLEWARE E RETIRA DA FILA
        $middleware = array_shift($this->middlewares);

        // VERIFICA O MAPEAMENTO
        if (!isset(self::$map[$middleware])) {
            throw new \Exception("Problemas ao processar o middleware da requisicao ", 500);
        }

        // NEXT
        $queue = $this;
        $next = function($request) use($queue) {
            return $queue->next($request);
        };

        // EXECUTA O MIDDLEWARE
        return (new self::$map[$middleware])->handle($request, $next);
    }

}


?>