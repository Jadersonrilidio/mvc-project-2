<?php

namespace App\Controller\Admin;

use \App\Utils\View;

/**
 * O COntroller e responsavel por pegar os dados do Model e inserir dentro da View para ser retornado
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
            'link' => URL.'/testimonies'
        ),
        'users' => array(
            'label' => 'Users',
            'link' => URL.'/users'
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

}
