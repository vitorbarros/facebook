<?php
namespace App;

use VMB\Http\Bootstrap;

class Route extends Bootstrap
{
    protected function initRoutes()
    {
        $arr['root'] = ['route' => '/', 'controller' => 'index', 'action' => 'index'];
        $arr['index_auth'] = ['route' => '/auth', 'controller' => 'index', 'action' => 'auth'];
        $this->setRoutes($arr);
    }
}