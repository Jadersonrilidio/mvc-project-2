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
     * Metodo reponsavel por atualizar os dados do banco com a instancia atual
     * @return boolean
     */
    public function atualizar() {
        return (new Database('testimonies'))->update('id = '.$this->id, array(
            'name' => $this->name,
            'message' => $this->message
        )); 
    }

    /**
     * Metodo reponsavel excluir os dados do banco com a instancia atual
     * @return boolean
     */
    public function excluir() {
        return (new Database('testimonies'))->delete('id = '.$this->id); 
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

     /**
      * Metodo responsavel por retornar um depoimento com base no seu id
      * @param int $id
      * @return Testimony
      */
     public static function getTestimonyById($id) {
        return self::getTestimonies('id = '.$id)->fetchObject(self::class);
     }
    
}

?>