<?php
    require(realpath("./db_functions.php"));
    require(realpath("./helpers.php"));

    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET, OPTIONS");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');
  
    session_start();
    
    //React js sends  options request before the original request
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == "OPTIONS") {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
        header("HTTP/1.1 200 OK");
        exit();
    }


    if ( ! isset( $_SESSION[ 'id' ] ) ) {
        header("HTTP/1.1 400 User must be logged in");
        exit();
    }

    //Gets the user from request username
    $user = DB::table( 'users' )->get( $_GET[ 'id' ] );
    unset( $user[ 'hashed_password' ] );

    header( "HTTP/1.1 200 user returned successfully" );
    echo( json_encode( $user ) );
    exit();
