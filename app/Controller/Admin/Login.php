<?php

namespace App\Controller\Admin;

use App\Utils\View;
use App\Model\Entity\User;
use App\Session\Admin\Login as SessionAdminLogin;

class Login extends Page {
    
    /**
     * Metodo responsavel retornar a renderizacao da pagina de login
     * @param Request $request
     * @param string|null $errorMsg
     * @return string
     */
    public static function getLogin($request, $errorMsg = null) {
        // VIEW DE STATUS
        $status = !is_null($errorMsg) ? Alert::getDanger($errorMsg) : '';

        // CONTEUDO DA PAGINA DE LOGIN
        $content = View::render('admin/login', array(
            'status' => $status
        ));

        // RETORNA A PAGINA COMPLETA
        return parent::getPage('JayDev - Login', $content);
    }

    /**
     * Metodo responsavel por definir o login do usuario
     * @param Request $request
     * @return
     */
    public static function setLogin($request) {
        // VARIAVEIS DA POST
        $postVars = $request->getPostVars();
        $email = $postVars['email'] ?? '';
        $password = $postVars['password'] ?? '';

        // BUSCA USUARIO NO DB POR EMAIL
        $user = User::getUserByEmail($email);
        if (!$user instanceof User) {
            return self::getLogin($request, 'Invalid password or email!');
        }

        // VERIFICA A SENHA DO USUARIO
        if (!password_verify($password, $user->password)) {
            return self::getLogin($request, 'Invalid password or email!');
        }

        // CRIA A SESSAO DE LOGIN
        SessionAdminLogin::login($user);
        
        // REDIRECIONA O USUARIO PARA A HOME DO ADMIN
        $request->getRouter()->redirect('/admin');
    }

    /**
     * Metodo responsavel por deslogar o usuario
     * @param Request $request
     */
    public static function setLogout($request) {
        // DESTROI A SESSAO DE LOGIN
        SessionAdminLogin::logout();
        
        // REDIRECIONA O USUARIO PARA A TELA DE LOGIN
        $request->getRouter()->redirect('/admin/login');
    }

}

?>