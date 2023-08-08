<?php

namespace NextG\RwAdminApp\Middleware;

use NextG\RwAdminApp\Middleware\Middleware;


class AuthMiddleware implements Middleware
{

    public function before()
    {
         if (!isset($_SESSION['user_must_log'])) {
             header('Location: login');
             exit();
         }
    }
}
