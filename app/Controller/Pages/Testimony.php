<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Pagination;
use \App\Model\Entity;

/**
 * O Controller e responsavel por pegar os dados do Model e inserir dentro da View para ser retornado
 */
class Testimony extends Page
{
    /**
     * Metodo responsavel por obter a renderizacao dos itens de depoimentos para a pagina
     * @param Request
     * @param Pagination
     * @return string
     */
    private static function getTestimonyItems($request, &$pagination) {
        // DEPOIMENTOS
        $itens = '';

        // QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = Entity\Testimony::getTestimonies(null, null, null, 'COUNT(*) as  qtde')->fetchObject()->qtde;

        // PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $page = $queryParams['page'] ?? 1;

        // INSTANCIA DE PAGINACAO
        $pagination = new Pagination($quantidadeTotal, $page, 2);
        
        // INSTANCIA DE RESULTADOS DA PAGINA
        $result = Entity\Testimony::getTestimonies(null, 'id DESC', $pagination->getLimit());

        // RENDERIZA O ITEM
        while ($testimony = $result->fetchObject(Entity\Testimony::class)) {
            $itens .= View::render('pages/testimony/item', array(
                'name' => $testimony->name,
                'message' => $testimony->message,
                'date' => date('d/m/Y H:i:s', strtotime($testimony->date))
            ));
        }

        // RETORNA OS DEPOIMENTOS
        return $itens;
    }

    /**
     * Metodo responsavel por retornar o conteudo (view) da pagina testimony;
     * @param Request
     * @return string
     */
    public static function getTestimonies($request) {   
        // VIEW DA TESTIMONY
        $content =  View::render('pages/testimonies', array(
            'itens' => self::getTestimonyItems($request, $pagination),
            'pagination' => Parent::getPagination($request, $pagination)
        ));

        // RETORNA A VIEW DA PAGINA
        return parent::getPage('JayDev - Testimony', $content);
    }

    /**
     * Metodo responsavel por cadastrar um depoimento
     * @var Request $request
     * @return string
     */
    public static function insertTestimony($request) {
        // DADOS DO POST (NEED TO VALIDADE POST VARIABLES HERE, IF THEY REALLY CAME FROM THE FRONTEND)
        $postVars = $request->getPostVars();

        //NOVA INSTANCIA DE DEPOIMENTO
        $testimony = new Entity\Testimony;
        $testimony->name = $postVars['name'];
        $testimony->message = $postVars['message'];
        $testimony->cadastrar();

        // RETORNA A PAGINA DE LISTAGEM DE DEPOIMENTOS
        return self::getTestimonies($request);
    }
}

?>