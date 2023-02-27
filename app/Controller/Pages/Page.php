<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Page
{
    /**
     * Retorna a view do layout principal
     * 
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function getPage($title, $content)
    {
        return View::render('pages/page', [
            'title' => $title,
            'content' => $content,

            'header' => self::getHeader($title),
            'footer' => self::getFooter(),
        ]);
    }

    /**
     * Retorna a view do header do layout principal
     * 
     * @return string $title
     */
    public static function getHeader($title = '')
    {
        return View::render('pages/header', [
            'title' => $title
        ]);
    }

    /**
     * Retorna a view do footer do layout principal
     * 
     * @return string
     */
    public static function getFooter()
    {
        return View::render('pages/footer');
    }
}
