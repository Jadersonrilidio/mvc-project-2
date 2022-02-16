<?php

namespace App\Model\Entity;

use App\Utils\Database;

class User {

    /**
     * Id do usuario
     * @var int
     */
    public $id;
    
    /**
     * Nome do usuario
     * @var string
     */
    public $username;
    
    /**
     * Email do usuario
     * @var string
     */
    public $email;

    /**
     * Senha do usuario
     * @var string
     */
    public $password;

    /**
     * Metodo responsavel por retornar um usuario com base em seu email
     * @param string $email
     * @return User
     */
    public static function getUserByEmail($email) {
        return (new Database('users'))->select('email = "'.$email.'"')->fetchObject(self::class);
    }

}

?>