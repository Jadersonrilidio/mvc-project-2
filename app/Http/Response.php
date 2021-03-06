<?php

namespace App\Http;

class Response
{

    /**
     * O codigo do status HTTP;
     * @var int
     */
    private $httpCode = 200;

    /**
     * Os headers (cabecalho) do response;
     * @var array
     */
    private $headers = array();

    /**
     * Tipo de conteudo que esta sendo retornado pela classe Response;
     * @var string
     */
    private $contentType;

    /**
     * Conteudo do Response;
     * @var mixed
     */
    private $content;

    /**
     * Metodo responsavel por iniciar a classe (instancia de classe) e definir os valores;
     * @param integer
     * @param mixed
     * @param string
     */
    public function __construct($httpCode, $content, $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content  = $content;
        $this->setContentType($contentType);
    }

    /**
     * Metodo responsavel por alterar o contentType do response;
     * @var string
     */
    private function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Metodo responsavel por adicionar um registro no header (cabecalho) de response;
     * @var string
     * @var string
     */
    private function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * Metodo responsavel por enviar os headers para o navegador;
     */
    private function sendHeaders()
    {
        # STATUS
        http_response_code($this->httpCode);

        # ENVIAR TODOS OS HEADERS
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
    }

    /**
     * Metodo responsavel por enviar a resposta ao usuario (na forma imprimindo em tela);
     * @return mixed
     */
    public function sendResponse()
    {
        # ENVIA OS HEADERS
        $this->sendHeaders();

        # IMPRIME O CONTEUDO
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
            case 'application/json':
                echo json_encode($this->content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                exit;
            default:
                echo 'Error: Content-Type not recognized. <br><br><pre>';
                print_r($this->content);
                echo '</pre>';
                exit;
        }
    }
}
