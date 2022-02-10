<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

/**
 * O Controller e responsavel por pegar os dados do Model e inserir dentro da View para ser retornado
 */
class About extends Page
{

    /**
     * Metodo responsavel por retornar o conteudo (view) da nossa pagina about;
     * @return string
     */
    public static function getAbout()
    {
        // ORGANIZACAO 
        $obOrganization = new Organization;

        // VIEW DA HOME
        $content =  View::render('pages/about', array(
            'name' => $obOrganization->name,
            'description' => $obOrganization->description,
            'site' => $obOrganization->site,
            'header' => 'Lorem Ipsum Stuff',
            'content' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eaque ab labore reprehenderit laboriosam nemo minima, obcaecati tempore sapiente itaque, neque voluptas nostrum nulla quis cupiditate dolorem architecto accusantium! Expedita, repellat.'
        ));

        // RETORNA A VIEW DA PAGINA
        return parent::getPage('JayDev - About', $content);
    }
}

?>