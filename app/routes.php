<?php

use app\controllers\DashboardController;
use app\controllers\UserController;
use app\utils\Router;

$router          = new Router( );

//Dashboard Routes
$router->addRoute( '/', [ DashboardController::class, 'show' ]);

//User Routes
$router->addRoute( '/user/login', [ UserController::class, 'login' ] );
$router->addRoute( '/user/signup', [ UserController::class, 'create' ] );
$router->addRoute( '/user/logout', [ UserController::class, 'logout' ] );
$router->addRoute( '/user', [ UserController::class, 'get' ] );
$router->addRoute( '/user/get-logged', [ UserController::class, 'getLogged' ] );

$request_url = $_SERVER[ 'REQUEST_URI' ];
$path        = strtok( $request_url, '?' );


$router->route( $path );