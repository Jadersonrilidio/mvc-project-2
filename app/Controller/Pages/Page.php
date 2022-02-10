<?php

namespace App\Controller\Pages;

use \App\Utils\View;

/**
 * O COntroller e responsavel por pegar os dados do Model e inserir dentro da View para ser retornado
 */
class Page
{

    /**
     * Metodo responsavel por renderizar o topo (cabecalho) da pagina
     * @return string
     */
    private static function getHeader()
    {
        return View::render('pages/header');
    }

    /**
     * Mtodo responsavel por renderizar o rodape da pagina
     */
    private static function getFooter()
    {
        return View::render('pages/footer');
    }

    /**
     * Metodo responsavel por retornar o conteudo (view) da nossa home;
     * @return string
     */
    public static function getPage($title, $content)
    {
        return View::render('pages/page', array(
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter()
        ));
    }
}
