<?php

namespace App\Utils;

class View
{

    /**
     * Variaveis padroes da View;
     * @var array
     */
    private static $vars = array();

    /**
     * Metodo responsavel por definir os dados iniciais da classe;
     * @param array
     */
    public static function init($vars = array())
    {
        self::$vars = $vars;
    }

    /**
     * Metodo responsavel por retornar o conteudo de uma view
     * @param  string
     * @return string
     */
    private static function getContentView($view)
    {
        $file = __DIR__ . '/../../resources/view/' . $view . '.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    /**
     * Metodo responsavel por retornar o conteudo renderizado de uma view
     * @param  string
     * @param  array
     * @return string
     */
    public static function render($view, $vars = array())
    {
        $contentView = self::getContentView($view);

        // MERGE DE VARIAVEIS DA VIEW
        $vars = array_merge(self::$vars, $vars);

        $values =  array_values($vars);

        $keys = array_keys($vars);
        $keys = array_map(function ($item) {
            return '{{' . $item . '}}';
        }, $keys);

        return str_replace($keys, $values, $contentView);
    }
}
