<?php

namespace App\Model\Entity;

use App\Utils\Database;

class User
{

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
     * Metodo responsavel por retornar usuarios
     * @param  string
     * @param  string
     * @param  string
     * @param  string
     * @return PDOStatement
     */
    public static function getUsers($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('users'))->select($where, $order, $limit, $fields);
    }

    /**
     * Metodo responsavel por retornar um usuario com base em seu email
     * @param  string $email
     * @return User
     */
    public static function getUserByEmail($email)
    {
        return self::getUsers('email = "' . $email . '"')->fetchObject(self::class);
    }

    /**
     * Metodo responsavel por retornar um usuario com base no seu id
     * @param  int $id
     * @return User
     */
    public static function getUserById($id)
    {
        return self::getUsers('id = ' . $id)->fetchObject(self::class);
    }

    /**
     * Metodo responsavel por cadastrar um usuario no banco de dados
     * @return bool
     */
    public function cadastrar()
    {
        $this->id = (new Database('users'))->insert(array(
            'username'  => $this->username,
            'email'     => $this->email,
            'password'  => $this->password
        ));

        return true;
    }

    /**
     * Metodo responsavel por atualizar um usuario no banco de dados
     * @return bool
     */
    public function atualizar()
    {
        return (new Database('users'))->update('id = ' . $this->id, array(
            'username'  => $this->username,
            'email'     => $this->email
            /*'password'  =>$this->password */
        ));
    }

    /**
     * Metodo responsavel por excluir um usuario do banco de dados
     * @return bool
     */
    public function excluir()
    {
        return (new Database('users'))->delete('id = ' . $this->id);
    }
}
