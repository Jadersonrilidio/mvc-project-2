<?php

namespace App\Controller\Api;

use App\Model\Entity;
use App\Utils\Pagination;
use \Exception;

class Testimony extends Api
{

    /**
     * Metodo responsavel por trazer os depoimentos do banco de dados
     * @param Request
     * @param Pagination
     * @return array
     */
    public static function getTestimonyItens($request, &$pagination)
    {
        // DEPOIMENTOS
        $itens = array();

        // QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = Entity\Testimony::getTestimonies(null, null, null, 'COUNT(*) as  qtde')->fetchObject()->qtde;

        // PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $page = $queryParams['page'] ?? 1;

        // INSTANCIA DE PAGINACAO
        $pagination = new Pagination($quantidadeTotal, $page, 5);

        // INSTANCIA DE RESULTADOS DA PAGINA
        $result = Entity\Testimony::getTestimonies(null, 'id DESC', $pagination->getLimit());

        // RENDERIZA O ITEM
        while ($testimony = $result->fetchObject(Entity\Testimony::class)) {
            $itens[] = array(
                'id' => (int) $testimony->id,
                'name' => $testimony->name,
                'message' => $testimony->message,
                'date' => $testimony->date
            );
        }

        // RETORNA OS DEPOIMENTOS
        return $itens;
    }

    // /**
    //  * Metodo responsavel por retornar um depoimento por sei id do banco de dados
    //  * @param Request
    //  * @return Entity\Testimony
    //  */
    // public static function getTestimonyById($request)
    // {
    //     // ID DO DEPOIMENTO
    //     $queryParams = $request->getQueryParams();
    //     $id = $queryParams['testimony'] ?? null;

    //     // VALIDA ID DO DEPOIMENTO NA GET
    //     if (!$id) return array();

    //     //  ENCONTRA O DEPOIMENTO NO BANCO DE DADOS
    //     $testimony = Entity\Testimony::getTestimonyById($id);

    //     // VALIDA DEPOIMENTO ENCONTRADO NO BANCO DE DADOS
    //     if (!$testimony) return array();

    //     // RETORNA O DEPOIMENTO
    //     return $testimony;
    // }

    /**
     * Metodo responsavel por retornar os depoimentos na API
     * @param Request
     * @return array
     */
    public static function getTestimonies($request)
    {
        return array(
            'testimonies' => self::getTestimonyItens($request, $pagination),
            'pagination' => parent::getPagination($request, $pagination)
        );
    }

    /**
     * Metodo responsavel por retornar os detalhes de um depoimento
     * @param Request
     * @param int
     * @return array
     */
    public static function getTestimony($request, $id)
    {
        // VALIDA O ID DO DEPOIMENTO
        if (!is_numeric($id)) {
            throw new Exception("Id '" . $id . "' type is not valid ", 400);
        }

        // BUSCA O DEPOIMENTO DO BANCO DE DADOS
        $testimony = Entity\Testimony::getTestimonyById($id);

        // VALIDA SE O DEPOIMENTO EXISTE
        if (!$testimony instanceof Entity\Testimony) {
            throw new Exception("Testimony id '" . $id . "' not found.", 404);
        }

        // RETORNA OS DETALHES DO DEPOIMENTO
        return array(
            'id' => (int) $testimony->id,
            'name' => $testimony->name,
            'message' => $testimony->message,
            'date' => $testimony->date
        );
    }
}
