<?php
namespace VMB\Http\Controller;

class ActionController
{
    protected $viewData;
    protected $action;

    public function __construct()
    {
        $this->viewData = new \stdClass();
    }

    public function render($action, $layout = true)
    {

        $this->action = $action;

        if ($layout == true && file_exists("../App/views/layout.phtml")) {
            include_once '../App/view/layout.phtml';
        } else {
            $this->content();
        }

    }

    public function content()
    {
        $atual = get_class($this);
        $singleClassName = strtolower(str_replace("App\\Controller\\", "", $atual));
        include_once '../App/view/' . $singleClassName . '/' . $this->action . '.phtml';
    }
}