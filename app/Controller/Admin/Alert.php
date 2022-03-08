<?php

namespace App\Controller\Admin;

use App\Utils\View;

class Alert
{

    /**
     * Metodo reponsavel por retornar uma mensagem de sucesso
     * @param  string $message
     * @return string
     */
    public static function getSuccess($message)
    {
        return View::render('admin/alert/status', array(
            'type'    => 'success',
            'message' => $message
        ));
    }

    /**
     * Metodo reponsavel por retornar uma mensagem de erro
     * @param  string $message
     * @return string
     */
    public static function getDanger($message)
    {
        return View::render('admin/alert/status', array(
            'type'    => 'danger',
            'message' => $message
        ));
    }

    /**
     * Metodo reponsavel por retornar uma mensagem status tipo
     * @param  string $message
     * @param  string $type
     * @return string
     */
    public static function getStatus($message, $type)
    {
        return View::render('admin/alert/status', array(
            'type'    => $type,
            'message' => $message
        ));
    }
}
