<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 24.09.2017
 * Time: 23:29
 */

namespace core;


class View
{

    public static function view(string $path, $movies = null): void
    {

        $view = ROOT . '/app/Views/' . $path . '.php';
        if (file_exists($view)) {

            include_once $view;
        }

    }
    public static function error(string $error): void
    {

        $view = ROOT . '/app/Views/error/error.php';
        if (file_exists($view)) {
            include_once $view;
        }

    }
}