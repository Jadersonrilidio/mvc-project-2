<?php

namespace App\Controller\Api;

use App\Model\Entity\User;
use Firebase\JWT\JWT;
use \Exception;

class Auth extends Api
{

    /**
     * Metodo responsavel por gerar um token JWT
     * @param  Request
     * @return array
     */
    public static function generateToken($request)
    {
        # POST VARS
        $postVars = $request->getPostVars();

        # VALIDA OS CAMPOS OBRIGATORIOS
        if (!isset($postVars['email']) or !isset($postVars['password'])) {
            throw new Exception("Fields email and password are mandatory", 400);
        }

        # BUSCA USUARIO PELO EMAIL
        $user = User::getUserByEmail($postVars['email']);
        if (!$user instanceof User) {
            throw new Exception("Invalid email or password", 400);
        }

        # VALIDA A SENHA DO USUARIO
        if (!password_verify($postVars['password'], $user->password)) {
            throw new Exception("Invalid email or password", 400);
        }

        # PAYLOAD
        $payload = array(
            'email' => $user->email
        );

        // RETORNA O TOKEN GERADO
        return array(
            'token' => JWT::encode($payload, getenv('JWT_KEY'), getenv('JWT_ALGO'))
        );
    }
}
