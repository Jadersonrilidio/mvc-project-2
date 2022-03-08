<?php

namespace App\Controller\Admin;

use \App\Utils\View;

class Home extends Page
{

    /**
     * Metodo responsavel por renderizar a view de home do painel admin
     * @param  Request $request
     * @return string
     */
    public static function getHome($request)
    {
        # CONTEUDO DA HOME
        $content = View::render('admin/modules/home/index', array());

        # RETORNA A PAGINA COMPLETA
        return parent::getPanel('JayDev - Admin Home', $content, 'home');
    }
}
