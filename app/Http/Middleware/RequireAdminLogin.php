<?php

namespace App\Http\Middleware;

use App\Session\Admin\Login as SessionAdminLogin;

class RequireAdminLogin implements MiddlewareInterface
{

    /**
     * Metodo responsavel por executar o middleware
     * @param  Request $request
     * @param  Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        # VERIFICA SE O USUARIO ESTA LOGADO
        if (!SessionAdminLogin::isLogged()) {
            $request->getRouter()->redirect('/admin/login');
        }

        # CONTINUA A EXECUCAO DO MIDDLEWARE
        return $next($request);
    }
}
