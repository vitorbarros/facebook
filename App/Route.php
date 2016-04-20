<?php
namespace App;

use VMB\Http\Bootstrap;

class Route extends Bootstrap
{
    protected function initRoutes()
    {
        $arr['root'] = ['route' => '/', 'controller' => 'index', 'action' => 'index'];
        $this->setRoutes($arr);
    }
}