<?php

namespace App\Controller\Api;

class Api
{

    /**
     * Metodo responsavel por retornar os detalhes da API
     * @param  Request
     * @return array
     */
    public static function getDetails($request)
    {
        return array(
            'name'    => 'API - JayDev',
            'version' => 'v1.0.0',
            'author'  => 'Jaderson Ilidio',
            'email'   => 'jadersonrilidio@gmail.com'
        );
    }

    /**
     * Metodo responsavel por retornar os detalhes da paginacao
     * @param  Request
     * @param  Pagination
     * @return array
     */
    protected static function getPagination($request, $pagination)
    {
        # QUERY PARAMS
        $queryParams = $request->getQueryParams();

        # PAGINAS
        $pages = $pagination->getPages();

        return array(
            'page'       => isset($queryParams['page']) ? (int) $queryParams['page'] : 1,
            'totalPages' => !empty($pages) ? count($pages) : 1
        );
    }
}
