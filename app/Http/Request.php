<?php
namespace App\Http;

class Request {

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

    public function __construct() {
        $this->queryParams = $_GET ?? array();
        $this->postVars = $_POST ?? array();
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
    }

    /**
     * Metodo responsavel por retornar o metodo HTTP da requisicao
     * @return string
     */
    public function getHttpMethod() {
        return $this->httpMethod;
    }

    /**
     * Metodo responsavel por retornar a URI da nossa requisicao
     * @return string
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * Metodo responsavel por retornar os parametros (variaveis, GET) da URL
     * @return array
     */
    public function getQueryParams() {
        return $this->queryParams;
    }

    /**
     * Metodo responsavel por retornar as variavies do POST
     * @return array
     */
    public function getPostVars() {
        return $this->postVars;
    }

    /**
     * Metodo responsavel por retornar os headers da requisicao
     * @return array
     */
    public function getHeaders() {
        return $this->headers;
    }

}