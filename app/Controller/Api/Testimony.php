<?php

namespace App\Controller\Api;

use App\Model\Entity\Testimony as EntityTestimony;
use App\Utils\Pagination;
use \Exception;

class Testimony extends Api
{

    /**
     * Metodo responsavel por trazer os depoimentos do banco de dados
     * @param  Request
     * @param  Pagination
     * @return array
     */
    public static function getTestimonyItens($request, &$pagination)
    {
        # DEPOIMENTOS
        $itens = array();

        # QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as  qtde')->fetchObject()->qtde;

        # PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $page = $queryParams['page'] ?? 1;

        # INSTANCIA DE PAGINACAO
        $pagination = new Pagination($quantidadeTotal, $page, 5);

        # INSTANCIA DE RESULTADOS DA PAGINA
        $result = EntityTestimony::getTestimonies(null, 'id DESC', $pagination->getLimit());

        # RENDERIZA O ITEM
        while ($testimony = $result->fetchObject(EntityTestimony::class)) {
            $itens[] = array(
                'id'      => (int) $testimony->id,
                'name'    => $testimony->name,
                'message' => $testimony->message,
                'date'    => $testimony->date
            );
        }

        # RETORNA OS DEPOIMENTOS
        return $itens;
    }

    /**
     * Metodo responsavel por retornar os depoimentos na API
     * @param  Request
     * @return array
     */
    public static function getTestimonies($request)
    {
        return array(
            'testimonies' => self::getTestimonyItens($request, $pagination),
            'pagination'  => parent::getPagination($request, $pagination)
        );
    }

    /**
     * Metodo responsavel por retornar os detalhes de um depoimento
     * @param  Request
     * @param  int
     * @return array
     */
    public static function getTestimony($request, $id)
    {
        # VALIDA O ID DO DEPOIMENTO
        if (!is_numeric($id)) {
            throw new Exception("Id '" . $id . "' type is not valid ", 400);
        }

        # BUSCA O DEPOIMENTO DO BANCO DE DADOS
        $testimony = EntityTestimony::getTestimonyById($id);

        # VALIDA SE O DEPOIMENTO EXISTE
        if (!$testimony instanceof EntityTestimony) {
            throw new Exception("Testimony id '" . $id . "' not found.", 404);
        }

        # RETORNA OS DETALHES DO DEPOIMENTO
        return array(
            'id'      => (int) $testimony->id,
            'name'    => $testimony->name,
            'message' => $testimony->message,
            'date'    => $testimony->date
        );
    }

    /**
     * Metodo responsavel por cadastrar um novo depoimento
     * @param  Request
     * @return array
     */
    public static function setNewTestimony($request)
    {
        # POST VARS
        $postVars = $request->getPostVars();

        # VALIDA CAMPOS OBRIGATORIOS
        if (empty($postVars['name']) or !isset($postVars['name']) or empty($postVars['message']) or !isset($postVars['message'])) {
            throw new Exception("Fields name and message are mandatory", 400);
        }

        # NOVA INSTANCIA DE DEPOIMENTO
        $testimony = new EntityTestimony;
        $testimony->name    = $postVars['name'];
        $testimony->message = $postVars['message'];

        # EXECUTA O CADASTRO NO BANCO DE DADOS
        $testimony->cadastrar();

        # RETORNA DEPOIMENTO CADASTRADO
        return array(
            'id'      => (int) $testimony->id,
            'name'    => $testimony->name,
            'message' => $testimony->message,
            'date'    => $testimony->date
        );
    }

    /**
     * Metodo responsavel por atualizar um depoimento
     * @param  Request
     * @param  int
     * @return array
     */
    public static function setEditTestimony($request, $id)
    {
        # POST VARS
        $postVars = $request->getPostVars();

        # VALIDA CAMPOS OBRIGATORIOS
        if (empty($postVars['name']) or !isset($postVars['name']) or empty($postVars['message']) or !isset($postVars['message'])) {
            throw new Exception("Fields name and message are mandatory", 400);
        }

        # BUSCA O DEPOIMENTO DO BANCO DE DADOS
        $testimony = EntityTestimony::getTestimonyById($id);

        # VALIDA DEPOIMENTO
        if (!$testimony instanceof EntityTestimony) {
            throw new Exception("Testimony not found. Invalid id", 403);
        }

        # ATUALIZA O DEPOIMENTO
        $testimony->name    = $postVars['name'];
        $testimony->message = $postVars['message'];

        # EXECUTA A ATUALIZACAO NO BANCO DE DADOS
        $testimony->atualizar();

        # RETORNA DEPOIMENTO ATUALIZADO
        return array(
            'id'      => (int) $testimony->id,
            'name'    => $testimony->name,
            'message' => $testimony->message,
            'date'    => $testimony->date
        );
    }

    /**
     * Metodo responsavel por excluir um depoimento
     * @param  Request
     * @param  int
     * @return array
     */
    public static function setDeleteTestimony($request, $id)
    {
        # BUSCA O DEPOIMENTO DO BANCO DE DADOS
        $testimony = EntityTestimony::getTestimonyById($id);

        # VALIDA DEPOIMENTO
        if (!$testimony instanceof EntityTestimony) {
            throw new Exception("Testimony not found. Invalid id", 403);
        }

        # EXECUTA A EXCLUSAO NO BANCO DE DADOS
        $testimony->excluir();

        # RETORNA DEPOIMENTO EXCLUIDO
        return array(
            'id'      => (int) $testimony->id,
            'name'    => $testimony->name,
            'message' => $testimony->message,
            'date'    => $testimony->date
        );
    }
}
