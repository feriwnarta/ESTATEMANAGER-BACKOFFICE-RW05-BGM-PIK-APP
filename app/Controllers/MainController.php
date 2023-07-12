<?php

namespace NextG\RwAdminApp\Controllers;

use NextG\RwAdminApp\App\View;

class MainController
{
    public function index()
    {
        
        View::render('layouts/app', 'users/user');

    }
}
