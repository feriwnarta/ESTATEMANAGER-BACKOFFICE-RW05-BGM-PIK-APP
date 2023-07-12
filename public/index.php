<?php

use NextG\RwAdminApp\App\Router;
use NextG\RwAdminApp\Controllers\UserController;

require __DIR__ . '/../vendor/autoload.php';



Router::add('GET', '/users', UserController::class, 'index');




Router::run();
