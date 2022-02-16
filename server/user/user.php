<?php

    require_once(  __DIR__ . '/helpers.php');
    require_once( __DIR__ . '/db_functions.php');

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == "OPTIONS") {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
        header("HTTP/1.1 200 OK");
        exit();
    }

    //Handled register request
    if ( $method === "POST") {

        //Saves the post attributes
        $_POST = json_decode( file_get_contents( "php://input" ), true );

        $username         = preg_replace('/\s+/', '', $_POST['username']);
        $password         = $_POST[ 'password' ];
        $password_confirm = $_POST[ 'password_confirm' ];
        
        validateUserRegisterDetails( $username, $password, $password_confirm );

        addUser( $username, $password );

        //Successfull signup
        header("HTTP/1.1 201 Signed up sucsessfully");
        exit();
        
    }



?>