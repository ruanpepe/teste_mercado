<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Home extends Page
{
    /**
     * Retorna a view da página principal
     * 
     * @return string
     */
    public static function getHome()
    {
        $content = View::render('pages/home');

        return parent::getPage('Página Inicial', $content);
    }
}
