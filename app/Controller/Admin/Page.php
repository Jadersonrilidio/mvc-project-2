<?php

namespace App\Controller\Admin;

use \App\Utils\View;

/**
 * O Controller e responsavel por pegar os dados do Model e inserir dentro da View para ser retornado
 */
class Page {
    /**
     * Modulos disponiveis no painel
     * @var array
     */
    private static $modules = array(
        'home' => array(
            'label' => 'Home',
            'link' => URL.'/admin'
        ),
        'testimonies' => array(
            'label' => 'Testimonies',
            'link' => URL.'/admin/testimonies'
        ),
        'users' => array(
            'label' => 'Users',
            'link' => URL.'/admin/users'
        )
    );

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

    /**
     * Metodo responsavel por renderizar a view do painel com conteudos dinamicos
     * @param string $title
     * @param string $content
     * @param string $currentModule
     * @return string
     */
    public static function getPanel($title, $content, $currentModule) {
        // RENDERIZA A VIEW DO PAINEL
        $contentPanel = View::render('admin/panel', array(
            'menu' => self::getMenu($currentModule),
            'content' => $content
        ));
        
        // RETORNA A PAGINA RENDERIZADA
        return self::getPage($title, $contentPanel);
    }

    /**
     * Metodo responsavel por renderizar a view do menu do painel
     * @param string $currentModule
     * @return string
     */
    private static function getMenu($currentModule) {
        // LINKS DO MENU
        $links = '';

        // ITERA OS MODULOS
        foreach (self::$modules as $hash => $module) {
            $links .= View::render('admin/menu/link', array(
                'label' => $module['label'],
                'link' => $module['link'],
                'current' => $hash == $currentModule ? 'active text-danger' : ''
            ));
        }

        // RETORNA A RENDERIZACAO DO MENU
        return View::render('admin/menu/box', array(
            'links' => $links
        ));
    }

        /**
     * Metodo responsavel por renderizar o layout de paginacao
     * @param Request
     * @param Pagination
     * @return string
     */
    public static function getPagination($request, $pagination) {
        // PAGINAS
        $pages = $pagination->getPages();
        
        // VERIFICA QUANTIDADE DE PAGINAS
        if (count($pages) <= 1) return '';

        // LINKS
        $links = '';

        // URL DA NOSSA ROTA SEM OS GETS
        $url = $request->getRouter()->getCurrentUrl();
        
        // GET
        $queryParams = $request->getQueryParams();

        // RENDERIZA OS LINKS
        foreach ($pages as $page) {
            // ALTERA A PAGINA
            $queryParams['page'] = $page['page'];

            // LINKS
            $link = $url.'?'.http_build_query($queryParams);

            // RENDERIZACAO DA VIEW
            $links .= View::render('admin/pagination/link', array(
                'page'      => $page['page'],
                'link'      => $link,
                'active'    => $page['current'] ? 'active' : ''
            ));
        }
        
        // RENDERIZA BOX DE PAGINACAO
        return View::render('admin/pagination/box', array(
            'links'  => $links
        ));
    }

}

?>