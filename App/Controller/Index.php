<?php
namespace App\Controller;

use Facebook\Facebook;
use Facebook\FacebookApp;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\FacebookRequest;
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
        } else {
            $this->fb->setDefaultAccessToken($_SESSION['accesses_token']);
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

        try {

            $request = $this->fb->request(
                'POST',
                '/1020778344680078/feed',
                array(
                    'message' => 'Testando a publicação no grupo através da api do face'
                )
            );

            $response = $this->fb->getClient()->sendRequest($request);
            echo '<pre>';
            print_r($response);
            exit;

        } catch (FacebookResponseException $e) {
            echo $e->getMessage();
        }
    }

}