<?php

namespace App\Http\Middleware;

use \Exception;
use App\Model\Entity\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuth implements MiddlewareInterface
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
        $this->auth($request);

        # CONTINUA A EXECUCAO DO MIDDLEWARE
        return $next($request);
    }

    /**
     * Metodo responsavel por validar o acesso via JWT
     * @param Request
     */
    private function auth($request)
    {
        # VERIFICA O USUARIO RECEBIDO
        if ($user = $this->getJWTAuthUser($request)) {
            $request->user = $user;
            return true;
        }

        # EMITE UM ERRO DE SENHA INVALIDA
        throw new Exception("forbidden, invalid token", 403);
    }

    /**
     * Metodo responsavel por retornar uma instancia de usuario autenticado
     * @param  Request
     * @return User
     */
    private function getJWTAuthUser($request)
    {
        # HEADERS
        $headers = $request->getHeaders();

        # TOKEN PURO JWT
        $jwt = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : '';

        try {
            # DECODIFICA JWT
            $decode = (array) JWT::decode($jwt, new Key(getenv('JWT_KEY'), getenv('JWT_ALGO')));
        } catch (Exception $e) {
            throw new Exception("invalid token", 403);
        }


        # BUSCA O USUARIO PELO EMAIL
        $email = $decode['email'] ?? '';
        $user = User::getUserByEmail($email);

        # RETORNA O USUARIO
        return ($user instanceof User) ? $user : false;
    }
}
