<?php

namespace App\Http\Middleware;

interface MiddlewareInterface
{

    /**
     * Metodo Abstrato responsavel por executar o middleware
     * @param  Request $request
     * @param  Closure $next
     * @return Response
     */
    public function handle($request, $next);
}
