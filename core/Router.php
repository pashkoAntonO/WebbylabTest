<?php

namespace core;


/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 22.09.2017
 * Time: 15:43
 */
class Router
{
    private $routes = [];
    private $uri;

    public function __construct(string $query)
    {
        $this->routes = include_once(ROOT . '/config/routes.php');
        $this->uri = empty($query) ? '/' : trim($query, '/');
    }


    public function uploadPage()
    {

        foreach ($this->routes as $uriReg => $path) {

            if (preg_match("~^$uriReg$~", $this->uri)) {

                $route = preg_replace("~$uriReg~", $path, $this->uri);

                $separator = explode('@', $route);

                $controller = array_shift($separator);

                $signature = explode('/', array_shift($separator));

                $action = array_shift($signature);

                $params = $signature;

                $pathToController = ROOT . '/app/Controllers/' . $controller . '.php';

                if (file_exists($pathToController)) {

                    include_once $pathToController;
                } else {
                    View::error('Метод не существует');
                    die();
                }

                $controllerName = '\app\\Controller\\' . $controller;

                $obj = new $controllerName;

                if (method_exists($obj, $action)) {
                    $obj->$action(...$params);

                } else {
                    View::error('Метод не существует');
                    die();
                }
                die();


            }

        }

        View::error('Путь не существует');
        die();

    }


}