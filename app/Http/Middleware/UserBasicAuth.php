<?php

namespace App\Http\Middleware;

use \Exception;
use App\Model\Entity\User;

class UserBasicAuth implements MiddlewareInterface
{
    /**
     * Metodo responsavel por executar o middleware
     * @param  Request $request
     * @param  Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        # REALIZA A VALIDACAO DO ACESSO VIA BASIC AUTH
        $this->basicAuth($request);

        # CONTINUA A EXECUCAO DO MIDDLEWARE
        return $next($request);
    }

    /**
     * Metodo responsavel por validar o acesso via basic auth
     * @param Request
     */
    private function basicAuth($request)
    {
        # VERIFICA O USUARIO RECEBIDO
        if ($user = $this->getBasicAuthUser()) {
            $request->user = $user;
            return true;
        }

        # EMITE UM ERRO DE SENHA INVALIDA
        throw new Exception("invalid email or password", 403);
    }

    /**
     * Metodo responsavel por retornar uma instancia de usuario autenticado
     * @return User
     */
    private function getBasicAuthUser()
    {
        # VERIFICA A EXISTENCIA DOS DADOS DE ACESSO
        if (!isset($_SERVER['PHP_AUTH_USER']) or !isset($_SERVER['PHP_AUTH_PW'])) {
            return false;
        }

        # BUSCA O USUARIO PELO EMAIL
        $user = User::getUserByEmail($_SERVER['PHP_AUTH_USER']);

        # VERIFICA A INSTANCIA
        if (!$user instanceof User) {
            return false;
        }

        # VALIDA SENHA E RETORNA O USUARIO
        return password_verify($_SERVER['PHP_AUTH_PW'], $user->password) ? $user : false;
    }
}
