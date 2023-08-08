<?php

namespace NextG\RwAdminApp\Controllers;

use NextG\RwAdminApp\App\View;
use NextG\RwAdminApp\Services\AuthServices\Impl\LoginServicesImpl;
use NextG\RwAdminApp\Services\AuthServices\LoginServices;
use NextG\RwAdminApp\Services\WablasServices\Impl\WablasServiceImpl;
use NextG\RwAdminApp\Services\WablasServices\WablasService;

class LoginController
{

    private LoginServices $loginServices;


    public function __construct()
    {
        $this->loginServices = new LoginServicesImpl();
    }
    public function index() {

        if(isset($_SESSION['user_must_log'])) {
            header('Location: users');
            return;
        }

        View::render('login/login');
    }

    public function login() {
        if(isset($_POST)) {
            $username = $_POST['username'];
            $password = $_POST['password'];
           $this->loginServices->login($username, $password);

        }
    }
}