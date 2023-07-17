<?php

use NextG\RwAdminApp\App\Router;
use NextG\RwAdminApp\Controllers\FirebaseController;
use NextG\RwAdminApp\Controllers\OtpController;
use NextG\RwAdminApp\Controllers\UserController;

require __DIR__ . '/../vendor/autoload.php';



Router::add('GET', '/users', UserController::class, 'index');
Router::add('POST', '/user', UserController::class, 'detailUser');
Router::add('GET', '/status', UserController::class, 'getAllStatus');
Router::add('POST', '/delete-user', UserController::class, 'deleteUser');
Router::add('POST', '/update-user', UserController::class, 'updateUser');
Router::add('GET', '/add-user', UserController::class, 'addUserView');
Router::add('GET', '/position-landscape', UserController::class, 'getPositionLandscape');
Router::add('GET', '/position-me', UserController::class, 'getPositionMe');
Router::add('GET', '/position-building-controll', UserController::class, 'getPositionBuildingControll');
Router::add('GET', '/position-security', UserController::class, 'getPositionSecurity');
Router::add('POST', '/save-employee', UserController::class, 'saveEmployee');



Router::add('GET', '/otp', OtpController::class, 'otpView');

// Router::add('GET', '/crashlytic', FirebaseController::class, 'crashlyticView');



Router::run();
