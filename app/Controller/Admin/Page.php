<?php

namespace App\Controller\Admin;

use \App\Utils\View;

/**
 * O COntroller e responsavel por pegar os dados do Model e inserir dentro da View para ser retornado
 */
class Page
{

    // /**
    //  * Metodo responsavel por renderizar o topo (cabecalho) da pagina
    //  * @return string
    //  */
    // private static function getHeader()
    // {
    //     return View::render('pages/header');
    // }

    // /**
    //  * Mtodo responsavel por renderizar o rodape da pagina
    //  */
    // private static function getFooter()
    // {
    //     return View::render('pages/footer');
    // }

    /**
     * Metodo responsavel por retornar o conteudo (view) da estrutura generica de pagina do painel admin;
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function getPage($title, $content)
    {
        return View::render('admin/page', array(
            'title' => $title,
            'content' => $content
            // 'header' => self::getHeader(),
            // 'footer' => self::getFooter()
        ));
    }

    // /**
    //  * Metodo responsavel por renderizar o layout de paginacao
    //  * @param Request
    //  * @param Pagination
    //  * @return string
    //  */
    // public static function getPagination($request, $pagination) {
    //     // PAGINAS
    //     $pages = $pagination->getPages();
        
    //     // VERIFICA QUANTIDADE DE PAGINAS
    //     if (count($pages) <= 1) return '';

    //     // LINKS
    //     $links = '';

    //     // URL DA NOSSA ROTA SEM OS GETS
    //     $url = $request->getRouter()->getCurrentUrl();
        
    //     // GET
    //     $queryParams = $request->getQueryParams();

    //     // RENDERIZA OS LINKS
    //     foreach ($pages as $page) {
    //         // ALTERA A PAGINA
    //         $queryParams['page'] = $page['page'];

    //         // LINKS
    //         $link = $url.'?'.http_build_query($queryParams);

    //         // RENDERIZACAO DA VIEW
    //         $links .= View::render('pages/pagination/link', array(
    //             'page'      => $page['page'],
    //             'link'      => $link,
    //             'active'    => $page['current'] ? 'active' : ''
    //         ));
    //     }
        
    //     // RENDERIZA BOX DE PAGINACAO
    //     return View::render('pages/pagination/box', array(
    //         'links'  => $links
    //     ));
    // }
}
