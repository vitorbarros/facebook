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

        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if ($url == '/group' || $url == '/auth') {
            if (!isset($_SESSION['accesses_token'])) {
                header('location: /');
            } else {
                $this->fb->setDefaultAccessToken($_SESSION['accesses_token']);
            }
        }

    }

    public function index()
    {
        $redirect = $this->fb->getRedirectLoginHelper();
        $permissions = ['email', 'user_likes', 'user_friends', 'user_posts', 'publish_actions']; // optional
        $loginUrl = $redirect->getLoginUrl($this->redirectConfig['redirect_login'], $permissions);

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
                '/1548515625401404/feed',
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