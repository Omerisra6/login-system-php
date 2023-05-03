<?php
session_start();

define( 'PUBLIC_PATH', __DIR__ . '\.\public' );
define( 'DB_DIR', __DIR__ . '\.\DB' );

require_once( __DIR__ .'./utils/router.php' );

$controllersPath = __DIR__ . './controllers';
$router = new Router( $controllersPath );

//Dashboard Routes
$router->addRoute( '/', 'DashboardController@show' );

//User Routes
$router->addRoute( '/user/login', 'UserController@login' );
$router->addRoute( '/user/signup', 'UserController@create' );
$router->addRoute( '/user/logout', 'UserController@logout' );
$router->addRoute( '/user', 'UserController@get' );
$router->addRoute( '/user/get-logged', 'UserController@getLogged' );

$request_url = $_SERVER[ 'REQUEST_URI' ];
$base_url    = '/';
$path        = strtok( $request_url, '?' );

$router->route( $path );
