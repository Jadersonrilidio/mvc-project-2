<?php

namespace App\Controller\Admin;

use App\Utils\View;
use App\Utils\Pagination;
use App\Utils\Database;
use App\Model\Entity;

class Testimony extends Page {

    /**
     * Metodo responsavel por renderizar a view de testimonies do painel admin
     * @param Request
     * @return string
     */
    public static function getTestimonies($request) {
        // CONTEUDO DA TESTIMONIES
        $content = View::render('admin/modules/testimonies/index', array(
            'rows' => self::getTestimonyRows($request, $pagination),
            'pagination' => parent::getPagination($request, $pagination),
            'status' => self::getStatus($request)
        ));
        // RETORNA A PAGINA COMPLETA
        return parent::getPanel('JayDev - Admin Testimonies', $content, 'testimonies');
    }

     /**
     * Metodo responsavel por obter a renderizacao dos itens de depoimentos para a pagina
     * @param Request
     * @param Pagination
     * @return string
     */
    private static function getTestimonyRows($request, &$pagination) {
        // DEPOIMENTOS
        $rows = '';

        // QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = Entity\Testimony::getTestimonies(null, null, null, 'COUNT(*) as  qtde')->fetchObject()->qtde;
        
        // PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $page = $queryParams['page'] ?? 1;
        
        // INSTANCIA DE PAGINACAO
        $pagination = new Pagination($quantidadeTotal, $page, 3);
        
        // INSTANCIA DE RESULTADOS DA PAGINA
        $result = Entity\Testimony::getTestimonies(null, 'id DESC', $pagination->getLimit());

        // RENDERIZA O ITEM
        while ($testimony = $result->fetchObject(Entity\Testimony::class)) {
            $rows .= View::render('admin/modules/testimonies/row', array(
                'id' => $testimony->id,
                'name' => $testimony->name,
                'message' => self::cutMessage($testimony->message),
                'date' => date('d/m/Y H:i:s', strtotime($testimony->date))
            ));
        }

        // RETORNA OS DEPOIMENTOS
        return $rows;
    }

    /**
     * Metodo responsavel por retornar e renderizar a pagina/formulario de cadastro de depoimentos
     * @param Request
     * @return string
     */
    public static function getNewTestimony($request) {
        // CONTEUDO DO FORMULARIO
        $content = View::render('admin/modules/testimonies/form', array(
            'title' => 'Cadastrar Depoimento',
            'name' => '',
            'message' => '',
            'status' => ''
        ));
        // RETORNA A PAGINA COMPLETA
        return parent::getPanel('JayDev - Admin Add Testimony', $content, 'testimonies');
    }

    /**
     * Metodo responsavel por cadastrar novo depoimento no db
     * @param Request
     * @return string
     */
    public static function insertNewTestimony($request) {
        // POST VARS
        $postVars = $request->getPostVars();

        // NOVA INSTANCIA DE DEPOIMENTO
        $testimony = new Entity\Testimony;
        $testimony->name = $postVars['name'];
        $testimony->message = $postVars['message'];

        // EXECUTA O CADASTRO NO BANCO DE DADOS
        $testimony->cadastrar();
        
        // REDIRECIONA PARA A PAGINA DE EDICAO
        $request->getRouter()->redirect('/admin/testimonies/' . $testimony->id . '/edit?status=created');
    }

    /**
     * Metodo responsavel por retornar e renderizar a pagina/formulario de edicao de depoimentos
     * @param Request
     * @param int
     * @return string
     */
    public static function getEditTestimony($request, $id) {
        // OBTEM O DEPOIMENTO DO BANCO DE DADOS
        $testimony = Entity\Testimony::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if (!$testimony instanceof Entity\Testimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        // CONTEUDO DO FORMULARIO
        $content = View::render('admin/modules/testimonies/form', array(
            'title' => 'Editar Depoimento',
            'name' => $testimony->name,
            'message' => $testimony->message,
            'status' => self::getStatus($request)
        ));

        // RETORNA A PAGINA COMPLETA
        return parent::getPanel('JayDev - Admin Edit Testimony', $content, 'testimonies');
    }

    /**
     * Metodo responsavel
     * @param Request
     * @return string
     */
    private static function getStatus($request) {
        // QUERY PARAMS
        $queryParams = $request->getQueryParams();

        // VALIDAR SATUS
        if (!isset($queryParams['status'])) return '';

        // MENSAGEMS DE STATUS
        switch ($queryParams['status']) {
            case 'created':
                return Alert::getSuccess('Testimony successfuly created!');
                break;
            case 'updated':
                return Alert::getSuccess('Testimony successfuly updated!');
                break;
            case 'deleted':
                return Alert::getSuccess('Testimony was successfuly deleted!');
                break;
        }
    }

    /**
     * Metodo responsavel por atualizar depoimentos no banco de dados
     * @param Request
     * @param int
     * @return string
     */
    public static function setEditTestimony($request, $id) {
        // OBTEM O DEPOIMENTO DO BANCO DE DADOS
        $testimony = Entity\Testimony::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if (!$testimony instanceof Entity\Testimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        // POST VARS
        $postVars = $request->getPostVars();

        // ATUALIZA A INSTANCIA DE TESTIMONY
        $testimony->name = $postVars['name'] ?? $testimony->name;
        $testimony->message = $postVars['message'] ?? $testimony->message;

        // GRAVAR A ATUALIZACAO DENTRO DO BANCO DE DADOS
        $testimony->atualizar();

        // REDIRECIONA PARA A PAGINA DE EDICAO
        $request->getRouter()->redirect('/admin/testimonies/' . $testimony->id . '/edit?status=updated');
    }


    /**
     * Metodo responsavel por retornar e renderizar o formulario de exclusao de depoimentos
     * @param Request
     * @param int
     * @return string
     */
    public static function getDeleteTestimony($request, $id) {
        // OBTEM O DEPOIMENTO DO BANCO DE DADOS
        $testimony = Entity\Testimony::getTestimonyById($id);

        // VALIDA A INSTANCIA
        if (!$testimony instanceof Entity\Testimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        // CONTEUDO DO FORMULARIO
        $content = View::render('/admin/modules/testimonies/delete', array(
            'title' => 'Deletar Depoimento',
            'name' => $testimony->name,
            'message' => $testimony->message,
            'date' => $testimony->date
        ));

        // 
        return parent::getPanel('JayDev - Delete Testimony', $content, 'testimonies');
    }

    /**
     * Metodo responsavel por atualizar depoimentos no banco de dados
     * @param Request
     * @param int
     * @return string
     */
    public static function setDeleteTestimony($request, $id) {
        // OBTEM O DEPOIMENTO DO BANCO DE DADOS
        $testimony = Entity\Testimony::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if (!$testimony instanceof Entity\Testimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        // REALIZA A EXCLUSAO DENTRO DO BANCO DE DADOS
        $testimony->excluir();

        // REDIRECIONA PARA A PAGINA DE EDICAO
        $request->getRouter()->redirect('/admin/testimonies?status=deleted');
    }





    /**
     * MY FUNCTION TO MAKE MESSAGE SHORTER ON TABLES
     * @param string
     * @return string
     */
    private static function cutMessage($message) {
        $message = wordwrap($message, 270, ' ...CUT', true);
        return explode('CUT', $message)[0];
    }

}
