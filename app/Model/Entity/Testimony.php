<?php

namespace App\Model\Entity;

use \App\Utils\Database;

/**
 * 
 */
class Testimony {

    /**
     * ID do depoimento
     * @var int
     */
    public $id;

    /**
     * Nome do usuario de depoimento
     * @var string
     */
    public $name;
    
    /**
     * Mensagem do depoimento
     * @var string
     */
    public $message;
    
    /**
     * Data de publicacao do depoimento
     * @var string
     */
    public $date;

    /**
     * Metodo reponsavel por cadastrar a instancia atual no banco de dados
     * @return boolean
     */
    public function cadastrar() {
        $this->date = date('Y-m-d H:i:s');

        $this->id = (new Database('testimonies'))->insert(array(
            'name' => $this->name,
            'date' => $this->date,
            'message' => $this->message
        ));

        // SUCESSO
        return true;
    }

    /**
     * Metodo responsavel por retornar depoimentos
     * @param string
     * @param string
     * @param string
     * @param string
     * @return PDOStatement
     */
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*') {
        return (new Database('testimonies'))->select($where, $order, $limit, $fields);
     }
    
}

?>