<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

/**
 * O Controller e responsavel por pegar os dados do Model e inserir dentro da View para ser retornado
 */
class Testimony extends Page
{

    /**
     * Metodo responsavel por retornar o conteudo (view) da nossa pagina testimony;
     * @return string
     */
    public static function getTestimonies()
    {
        // VIEW DA TESTIMONY
        $content =  View::render('pages/testimonies', array(

        ));

        // RETORNA A VIEW DA PAGINA
        return parent::getPage('JayDev - Testimony', $content);
    }
}

?>