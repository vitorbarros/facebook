<?php
namespace VMB\Http;

abstract class Bootstrap
{

    private $routes;
    private $findRouts = false;

    public function __construct()
    {
        $this->initRoutes();
        $this->run($this->getUrl());
    }


    abstract protected function initRoutes();

    protected function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }

    protected function run($url)
    {

        array_walk($this->routes, function ($route) use ($url) {

            if ($url == $route['route']) {

                $class = "App\\Controller\\" . ucfirst($route['controller']);
                $controller = new $class;
                $controller->$route['action']();
                $this->findRouts = true;

            }

        });

        if (!$this->findRouts) {
            header('HTTP/1.0 404 Not Found');
            include('404.phtml');
        }

    }

    protected function getUrl()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

}