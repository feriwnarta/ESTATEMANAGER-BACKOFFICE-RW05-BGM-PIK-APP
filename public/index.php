<?php
session_start();

use NextG\RwAdminApp\App\Router;
use NextG\RwAdminApp\Controllers\AuthController;
use NextG\RwAdminApp\Controllers\OtpController;
use NextG\RwAdminApp\Controllers\UserController;
use NextG\RwAdminApp\Middleware\AuthMiddleware;

require __DIR__ . '/../vendor/autoload.php';


Router::add('GET', '/users', UserController::class, 'index', [AuthMiddleware::class]);
Router::add('POST', '/user', UserController::class, 'detailUser', [AuthMiddleware::class]);
Router::add('GET', '/status', UserController::class, 'getAllStatus', [AuthMiddleware::class]);
Router::add('POST', '/delete-user', UserController::class, 'deleteUser', [AuthMiddleware::class]);
Router::add('POST', '/update-user', UserController::class, 'updateUser', [AuthMiddleware::class]);
Router::add('GET', '/add-user', UserController::class, 'addUserView', [AuthMiddleware::class]);
Router::add('GET', '/position-landscape', UserController::class, 'getPositionLandscape', [AuthMiddleware::class]);
Router::add('GET', '/position-me', UserController::class, 'getPositionMe', [AuthMiddleware::class]);
Router::add('GET', '/position-building-controll', UserController::class, 'getPositionBuildingControll', [AuthMiddleware::class]);
Router::add('GET', '/position-security', UserController::class, 'getPositionSecurity', [AuthMiddleware::class]);
Router::add('POST', '/save-employee', UserController::class, 'saveEmployee', [AuthMiddleware::class]);


// Authorization
Router::add('GET', '/auth', AuthController::class, 'authView', [AuthMiddleware::class]);
Router::add('GET', '/new-auth', AuthController::class, 'addAuthView', [AuthMiddleware::class]);
Router::add('POST', '/update-auth', AuthController::class, 'updateAuthAcces', [AuthMiddleware::class]);


Router::add('GET', '/otp', OtpController::class, 'otpView');

// Router::add('GET', '/crashlytic', FirebaseController::class, 'crashlyticView');



Router::run();
