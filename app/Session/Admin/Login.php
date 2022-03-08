<?php

namespace App\Session\Admin;

class Login
{

    /**
     * Metodo responsavel por iniciar a sessao
     */
    private static function init()
    {
        # VERIFICA SE A SESSAO NAO ESTA ATIVA
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * Metodo responsavel por criar o login do usuario
     * @param  User $user
     * @return bool
     */
    public static function Login($user)
    {
        # INICIA A SESSAO
        self::init();

        # DEFINE A SESSAO DO USUARIO ADMINISTRADOR
        $_SESSION['admin']['user'] = array(
            'id'       => $user->id,
            'username' => $user->username,
            'email'    => $user->email
        );

        # SUCESSO
        return true;
    }

    /**
     * Metodo responsavel por verificar se o usuario esta logado
     * @return boolean
     */
    public static function isLogged()
    {
        # INICIA A SESSAO
        self::init();

        # RETORNA A VERIFICACAO
        return isset($_SESSION['admin']['user']['id']);
    }

    /**
     * Metodo responsavel por executar logout do usuario
     * @return boolean
     */
    public static function logout()
    {
        # INICIA A SESSAO
        self::init();

        # DESTROI A SESSAO DO USUARIO ADMINISTRADOR
        unset($_SESSION['admin']['user']);

        # SUCESSO
        return true;
    }
}
