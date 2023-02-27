<?php

namespace App\Utils;

class View
{
    private static $vars = [];

    /**
     * Define os dados iniciais da classe
     * @param array $vars
     */
    public static function init($vars = [])
    {
        self::$vars = $vars;
    }
    /**
     * Retorna o conteúdo de uma view
     * 
     * @param string $view
     * @return string
     */
    private static function getViewContent($view)
    {
        $file = __DIR__ . '/../../public/view/' . $view . '.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    /**
     * Renderiza o conteúdo de uma view
     * 
     * @param string $view
     * @param array $vars
     * @return string
     */
    public static function render($view, $vars = [])
    {
        $viewContent = self::getViewContent($view);

        $vars = array_merge(self::$vars, $vars);

        $vars_keys = array_keys($vars);
        $vars_keys = array_map(function ($key) {
            return '{{' . $key . '}}';
        }, $vars_keys);

        return str_replace($vars_keys, array_values($vars), $viewContent);
    }
}
