<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

/**
 * O Controller e responsavel por pegar os dados do Model e inserir dentro da View para ser retornado
 */
class Home extends Page
{

    /**
     * Metodo responsavel por retornar o conteudo (view) da nossa home;
     * @return string
     */
    public static function getHome()
    {
        // ORGANIZACAO 
        $obOrganization = new Organization;

        // VIEW DA HOME
        $content =  View::render('pages/home', array(
            'name' => $obOrganization->name
        ));

        // RETORNA A VIEW DA PAGINA
        return parent::getPage('JayDev - Home', $content);
    }
}

?>