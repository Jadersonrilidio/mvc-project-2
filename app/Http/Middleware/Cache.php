<?php

namespace App\Http\Middleware;

use App\Utils\Cache\File as CacheFile;

class Cache implements MiddlewareInterface
{

    /**
     * Metodo responsavel por executar o middleware
     * @param  Request $request
     * @param  Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        # VERIFICA SE A REQUEST ATUAL E CACHEAVEL
        if (!$this->isCacheable($request)) return $next($request);

        # OBTER A HASH DO CACHE
        $hash = $this->getHash($request);

        # RETORNA OS DADOS DO CACHE
        return CacheFile::getCache($hash, getenv('CACHE_TIME'), function () use ($request, $next) {
            return $next($request);
        });
    }

    /**
     * Metodo responsavel por verificar se a request atual pode ser cacheada
     * @param  Request
     * @return bool
     */
    private function isCacheable($request)
    {
        # VALIDA O TEMPO DE CACHE
        if (getenv('CACHE_TIME') <= 0) return false;

        # VALIDA SE O METODO DA REQUISICAO E CACHEAVEL
        if ($request->getHttpMethod() != 'GET') return false;

        # VALIDA O HEADER DE CACHE
        $headers = $request->getHeaders();
        if (isset($headers['Cache-Control']) && $headers['Cache-Control'] == 'no-cache') return false;

        # CACHEAVEL
        return true;
    }

    /**
     * Metodo responsavel por retornar a hash do cache
     * @param  Request
     * @return string
     */
    private function getHash($request)
    {
        # URI DA ROTA
        $uri = $request->getRouter()->getUri();

        # QUERY PARAMS
        $queryParams = $request->getQueryParams();

        # ADICIONA OS QUERY PARAMS A URI DA ROTA/PAGINA
        $uri .= !empty($queryParams) ? '?' . http_build_query($queryParams) : '';
        $uri  = ltrim($uri, '/');

        # REMOVE AS BARRAS E RETORNA A HASH
        return rtrim('route-' . preg_replace('/[^0-9a-zA-Z]/', '-', $uri), '-');
    }
}
