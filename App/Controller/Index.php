<?php
namespace App\Controller;

use VMB\Http\Controller\ActionController;

class Index extends ActionController
{
    public function index()
    {
        $this->render('index');
    }
}