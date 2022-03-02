<?php

namespace App\Http;

use App\Utils\Debugger;

class Request
{

    /**
     * Instancia de Router
     * @var Router
     */
    private $router;

    /**
     * nome do metodo HTTP utilizado para criar a requisicao (GET, POST, PUT, PATCH, DELETE...)
     * @var string
     */
    private $httpMethod;

    /**
     * URI da pagina, basicamente nossa rota
     * @var string
     */
    private $uri;

    /**
     * Os parametros da URL ($_GET)
     * @var array
     */
    private $queryParams = array();

    /**
     * variaveis recebidas no post da pagina ($_POST)
     * @var array
     */
    private $postVars = array();

    /**
     * cabecalho da requisicao
     * @var array
     */
    private $headers = array();

    /**
     * Metodo reponsavel por construir uma instancia de Request
     * @param Router
     */
    public function __construct($router)
    {
        $this->router = $router;
        $this->queryParams = $_GET ?? array();
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'];
        $this->setPostVars();
        $this->setUri();
    }

    /**
     * Metodo responsavel por definir as variaveis do POST
     */
    private function setPostVars()
    {
        // VERIFICA O METODO DA REQUISICAO
        if ($this->httpMethod == 'GET') return false;

        // POST PADRAO
        $this->postVars = $_POST ?? array();

        // POST JSON
        $inputRaw = file_get_contents('php://input');
        $this->postVars = (strlen($inputRaw) and empty($_POST)) ? json_decode($inputRaw, true) : $this->postVars;
    }

    /**
     * Metodo responsavel por definir a URI
     */
    private function setUri()
    {
        // URI COMPLETA COM GETS
        $this->uri = $_SERVER['REQUEST_URI'];

        // REMOVE GETS DA URI
        $xUri = explode('?', $this->uri);

        // RETORNA A URI SEM OS GETS
        $this->uri = $xUri[0];
    }

    /**
     * Metodo responsavel por retornar a instancia de Router
     * @return string
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * Metodo responsavel por retornar o metodo HTTP da requisicao
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * Metodo responsavel por retornar a URI da nossa requisicao
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Metodo responsavel por retornar os parametros (variaveis, GET) da URL
     * @return array
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * Metodo responsavel por retornar as variavies do POST
     * @return array
     */
    public function getPostVars()
    {
        return $this->postVars;
    }

    /**
     * Metodo responsavel por retornar os headers da requisicao
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
