<?php

namespace App\Controller\Api;

use App\Model\Entity\User as EntityUser;
use App\Utils\Pagination;
use \Exception;

class User extends Api
{

    /**
     * Metodo responsavel por trazer os usuarios do banco de dados
     * @param  Request
     * @param  Pagination
     * @return array
     */
    private static function getUserItens($request, &$pagination)
    {
        // USUARIO
        $itens = array();

        // QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = EntityUser::getUsers(null, null, null, 'COUNT(*) as  qtde')->fetchObject()->qtde;

        // PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $page = $queryParams['page'] ?? 1;

        // INSTANCIA DE PAGINACAO
        $pagination = new Pagination($quantidadeTotal, $page, 5);

        // INSTANCIA DE RESULTADOS DA PAGINA
        $result = EntityUser::getUsers(null, 'id DESC', $pagination->getLimit());

        // 
        while ($user = $result->fetchObject(EntityUser::class)) {
            $itens[] = array(
                'id'       => (int) $user->id,
                'username' => $user->username,
                'email'    => $user->email
            );
        }

        // RETORNA OS USUARIOS
        return $itens;
    }

    /**
     * Metodo responsavel por retornar os usuarios na API
     * @param  Request
     * @return array
     */
    public static function getUsers($request)
    {
        return array(
            'users'      => self::getUserItens($request, $pagination),
            'pagination' => parent::getPagination($request, $pagination)
        );
    }

    /**
     * Metodo responsavel por retornar os detalhes de um usuario
     * @param  Request
     * @param  int
     * @return array
     */
    public static function getUser($request, $id)
    {
        // VALIDA O ID DO USUARIO
        if (!is_numeric($id)) {
            throw new Exception("Id '" . $id . "' type is not valid ", 400);
        }

        // BUSCA O USUARIO DO BANCO DE DADOS
        $user = EntityUser::getUserById($id);

        // VALIDA SE O USUARIO EXISTE
        if (!$user instanceof EntityUser) {
            throw new Exception("user id '" . $id . "' not found.", 404);
        }

        // RETORNA OS DETALHES DO USUARIO
        return array(
            'id'       => (int) $user->id,
            'username' => $user->username,
            'email'    => $user->email
        );
    }

    /**
     * Metodo responsavel por cadastrar um novo usuario
     * @param  Request
     * @return array
     */
    public static function setNewUser($request)
    {
        // POST VARS
        $postVars = $request->getPostVars();

        // VALIDA CAMPOS OBRIGATORIOS
        if (
            empty($postVars['username']) or !isset($postVars['username']) or
            empty($postVars['email'])    or !isset($postVars['email']) or
            empty($postVars['password']) or !isset($postVars['password'])
        ) {
            throw new Exception("Username, email and password are mandatory", 400);
        }

        // VALIDA O EMAIL DE USUARIO
        $user = EntityUser::getUserByEmail($postVars['email']);
        if ($user instanceof EntityUser) {
            throw new Exception("Email already registered", 400);
        }

        // NOVA INSTANCIA DE USUARIO
        $user = new EntityUser;
        $user->username = $postVars['username'];
        $user->email    = $postVars['email'];
        $user->password = password_hash($postVars['password'], PASSWORD_DEFAULT);

        // EXECUTA O CADASTRO NO BANCO DE DADOS
        $user->cadastrar();

        // RETORNA USUARIO CADASTRADO
        return array(
            'id'       => (int) $user->id,
            'username' => $user->username,
            'email'    => $user->email
        );
    }

    /**
     * Metodo responsavel por atualizar um usuario
     * @param  Request
     * @param  int
     * @return array
     */
    public static function setEditUser($request, $id)
    {
        // POST VARS
        $postVars = $request->getPostVars();

        // VALIDA CAMPOS OBRIGATORIOS
        if (
            empty($postVars['username']) or !isset($postVars['username']) or
            empty($postVars['email'])    or !isset($postVars['email'])
        ) {
            throw new Exception("Username and email are mandatory", 400);
        }

        // BUSCA O USUARIO DO BANCO DE DADOS
        $user = EntityUser::getUserById($id);

        // VALIDA USUARIO
        if (!$user instanceof EntityUser) {
            throw new Exception("user not found. Invalid id", 403);
        }

        // VALIDA O EMAIL DE USUARIO
        $user2 = EntityUser::getUserByEmail($postVars['email']);
        if ($user2 instanceof EntityUser && $user2->id != $id) {
            throw new Exception("Email belongs to another user", 403);
        }

        // ATUALIZA O USUARIO
        $user->username = $postVars['username'];
        $user->email    = $postVars['email'];

        // EXECUTA A ATUALIZACAO NO BANCO DE DADOS
        $user->atualizar();

        // RETORNA USUARIO ATUALIZADO
        return array(
            'id'       => (int) $user->id,
            'username' => $user->username,
            'email'    => $user->email
        );
    }

    /**
     * Metodo responsavel por excluir um usuario
     * @param  Request
     * @param  int
     * @return array
     */
    public static function setDeleteUser($request, $id)
    {
        // BUSCA O USUARIO DO BANCO DE DADOS
        $user = EntityUser::getUserById($id);

        // VALIDA USUARIO
        if (!$user instanceof EntityUser) {
            throw new Exception("user not found. Invalid id", 403);
        }

        // IMPEDE EXCLUSAO DO PROPRIO CADASTRO
        if ($user->id == $request->user->id) {
            throw new Exception("not allowed exlude current user", 403);
        }

        // EXECUTA A EXCLUSAO NO BANCO DE DADOS
        $user->excluir();

        // RETORNA USUARIO EXCLUIDO
        return array(
            'id'       => (int) $user->id,
            'username' => $user->username,
            'email'    => $user->email
        );
    }
}
