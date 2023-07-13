<?php

use NextG\RwAdminApp\App\Router;
use NextG\RwAdminApp\Controllers\UserController;

require __DIR__ . '/../vendor/autoload.php';



Router::add('GET', '/users', UserController::class, 'index');
Router::add('POST', '/user', UserController::class, 'detailUser');
Router::add('GET', '/status', UserController::class, 'getAllStatus');
Router::add('POST', '/delete-user', UserController::class, 'deleteUser');
Router::add('POST', '/update-user', UserController::class, 'updateUser');





Router::run();
