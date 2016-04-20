<?php
namespace App\Controller;

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use VMB\Http\Controller\ActionController;

class Index extends ActionController
{

    /**
     * @var Facebook
     */
    private $fb;

    /**
     * @var array
     */
    private $redirectConfig;

    public function __construct()
    {
        session_start();

        $this->redirectConfig = require_once __DIR__ . '/../../config/redirect.config.php';
        $config = require_once __DIR__ . '/../../config/credentials.config.php';

        if (null === $this->fb) {
            $this->fb = new Facebook($config);
        }

        if (!isset($_SESSION['accesses_token'])) {
            header('location: /');
        }
        
    }

    public function index()
    {
        $redirect = $this->fb->getRedirectLoginHelper();
        $loginUrl = $redirect->getLoginUrl($this->redirectConfig['redirect_login']);

        $this->viewData = array('login' => $loginUrl);
        $this->render('index');
    }

    public function auth()
    {
        try {
            $helper = $this->fb->getRedirectLoginHelper();
            $_SESSION['accesses_token'] = $helper->getAccessToken();
            header('location: /group');
        } catch (FacebookResponseException $e) {
            echo $e->getMessage();
        }
    }

    public function group()
    {

        echo '<pre>';
        print_r($_SESSION);
        exit;
    }

}