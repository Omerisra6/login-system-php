<?php

    require_once(  __DIR__ . '/helpers.php');
    require_once( __DIR__ . '/db_functions.php');

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET, OPTIONS");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    session_start();

    $method = $_SERVER['REQUEST_METHOD'];
    if ($method === "OPTIONS"){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
        header("HTTP/1.1 200 OK");
        exit();
    }

    //Validates that the user logged in
    if( ! isset( $_SESSION[ 'username' ] ) ){
        header("HTTP/1.1 400 User must be logged in");
        exit();
    }

    $loggedUsers = getLoggedUsers();

    //Success
    header("HTTP/1.1 200 User logged in successfully");
    exit();
?>