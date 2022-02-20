<?php

namespace App\Controller\Admin;

use App\Utils\View;
use App\Utils\Pagination;
use App\Model\Entity;
use App\Utils\Debugger;

class User extends Page {

    /**
     * Metodo responsavel por renderizar a view de users do painel admin
     * @param Request $request
     * @return string
     */
    public static function getUsers($request) {
        // CONTEUDO DA USERS
        $content = View::render('admin/modules/users/index', array(
            'rows' => self::getUserRows($request, $pagination),
            'pagination' => parent::getPagination($request, $pagination),
            'status' => self::getStatus($request)
        ));
        // RETORNA A PAGINA COMPLETA
        return parent::getPanel('JayDev - Admin Users', $content, 'users');
    }

     /**
     * Metodo responsavel por obter a renderizacao das linhas de users para a pagina
     * @param Request
     * @param Pagination
     * @return string
     */
    private static function getUserRows($request, &$pagination) {
        // USERS
        $rows = '';

        // QUANTIDADE TOTAL DE USUARIOS
        $quantidadeTotal = Entity\User::getUsers(null, null, null, 'COUNT(*) as  qtde')->fetchObject()->qtde;
        
        // PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $page = $queryParams['page'] ?? 1;
        
        // INSTANCIA DE PAGINACAO
        $pagination = new Pagination($quantidadeTotal, $page, 5);
        
        // INSTANCIA DE RESULTADOS DA PAGINA
        $result = Entity\User::getUsers(null, 'id DESC', $pagination->getLimit());

        // RENDERIZA O ITEM
        while ($user = $result->fetchObject(Entity\User::class)) {
            $rows .= View::render('admin/modules/users/row', array(
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'status' => self::getStatus($request)
            ));
        }

        // RETORNA OS USUARIOS
        return $rows;
    }

    /**
     * Metodo responsavel por retornar e renderizar a pagina/formulario de cadastro de usuarios
     * @param Request $request
     * @return string
     */
    public static function getNewUser($request) {
        // CONTEUDO DO FORMULARIO
        $content = View::render('admin/modules/users/form', array(
            'title' => 'Cadastrar Usuario',
            'username' => '',
            'email' => '',
            'password' => '',
            'status' => self::getStatus($request)
        ));
        // RETORNA A PAGINA COMPLETA
        return parent::getPanel('JayDev - Admin Add User', $content, 'users');
    }

    /**
     * Metodo responsavel por cadastrar novo usuario no db
     * @param Request $request
     * @return string
     */
    public static function insertNewUser($request) {
        // POST VARS
        $postVars = $request->getPostVars();
        $email = $postVars['email'];
        
        // VALIDA O EMAIL DE USUARIO
        $user = Entity\User::getUserByEmail($email);
        if ($user instanceof Entity\User) {
            $request->getRouter()->redirect('/admin/users/new?status=invalid');
        }

        // NOVA INSTANCIA DE USUARIO
        $user = new Entity\User;
        $user->username = $postVars['username'];
        $user->email = $postVars['email'];
        $user->password = password_hash($postVars['password'], PASSWORD_DEFAULT);

        // EXECUTA O CADASTRO NO BANCO DE DADOS
        $user->cadastrar();
        
        // REDIRECIONA PARA A PAGINA DE EDICAO
        $request->getRouter()->redirect('/admin/users/' . $user->id . '/edit?status=created');
    }

    /**
     * Metodo responsavel por retornar e renderizar a pagina/formulario de edicao de usuarios
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function getEditUser($request, $id) {
        // OBTEM O USUARIO DO BANCO DE DADOS
        $user = Entity\User::getUserById($id);

        //VALIDA A INSTANCIA
        if (!$user instanceof Entity\User) {
            $request->getRouter()->redirect('/admin/users');
        }

        // CONTEUDO DO FORMULARIO
        $content = View::render('admin/modules/users/form', array(
            'title' => 'Editar Usuario',
            'username' => $user->username,
            'email' => $user->email,
            'password' => '',
            'status' => self::getStatus($request)
        ));

        // RETORNA A PAGINA COMPLETA
        return parent::getPanel('JayDev - Admin Edit user', $content, 'users');
    }

    /**
     * Metodo responsavel ...
     * @param Request $request
     * @return string
     */
    private static function getStatus($request) {
        // QUERY PARAMS
        $queryParams = $request->getQueryParams();

        // VALIDAR SATUS
        if (!isset($queryParams['status'])) return '';

        // MENSAGEMS DE STATUS
        switch ($queryParams['status']) {
            case 'created':
                return Alert::getSuccess('user successfuly created!');
                break;
            case 'updated':
                return Alert::getSuccess('user successfuly updated!');
                break;
            case 'deleted':
                return Alert::getSuccess('user was successfuly deleted!');
                break;
            case 'invalid':
                return Alert::getDanger('email is already registered!');
                break;
            default: 
                return '';
        }
    }

    /**
     * Metodo responsavel por atualizar usuarios no banco de dados
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function setEditUser($request, $id) {
        // OBTEM O USUARIO DO BANCO DE DADOS
        $user = Entity\User::getUserById($id);

        //VALIDA A INSTANCIA
        if (!$user instanceof Entity\User) {
            $request->getRouter()->redirect('/admin/users');
        }

        // POST VARS
        $postVars = $request->getPostVars();
        
        // VALIDA O EMAIL DE USUARIO
        $email = $postVars['email'];
        $user2 = Entity\User::getUserByEmail($email);

        Debugger::debug([$user, $email, $user2]);

        if ($user2 instanceof Entity\User && $user2->id != $id) {
           return $request->getRouter()->redirect('/admin/users/' . $id . '/edit?status=invalid');
        }

        // ATUALIZA A INSTANCIA DE USER
        $user->username = $postVars['username'] ?? $user->username;
        $user->email = $postVars['email'] ?? $user->email;

        // GRAVAR A ATUALIZACAO DENTRO DO BANCO DE DADOS
        $user->atualizar();

        // REDIRECIONA PARA A PAGINA DE EDICAO
        $request->getRouter()->redirect('/admin/users/' . $user->id . '/edit?status=updated');
    }


    /**
     * Metodo responsavel por retornar e renderizar o formulario de exclusao de usuarios
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function getDeleteUser($request, $id) {
        // OBTEM O USUARIO DO BANCO DE DADOS
        $user = Entity\User::getUserById($id);

        // VALIDA A INSTANCIA
        if (!$user instanceof Entity\User) {
            $request->getRouter()->redirect('/admin/users');
        }

        // CONTEUDO DO FORMULARIO
        $content = View::render('/admin/modules/users/delete', array(
            'title' => 'Deletar Usuario',
            'username' => $user->username,
            'email' => $user->email,
            'password' => password_hash($user->password, PASSWORD_DEFAULT)
        ));

        // 
        return parent::getPanel('JayDev - Delete user', $content, 'users');
    }

    /**
     * Metodo responsavel por atualizar usuarios no banco de dados
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function setDeleteUser($request, $id) {
        // OBTEM O USUARIO DO BANCO DE DADOS
        $user = Entity\User::getUserById($id);

        //VALIDA A INSTANCIA
        if (!$user instanceof Entity\User) {
            $request->getRouter()->redirect('/admin/users');
        }

        // REALIZA A EXCLUSAO DENTRO DO BANCO DE DADOS
        $user->excluir();

        // REDIRECIONA PARA A PAGINA PRINCIPAL
        $request->getRouter()->redirect('/admin/users?status=deleted');
    }

}
