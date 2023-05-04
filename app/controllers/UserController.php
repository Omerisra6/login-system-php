<?php

namespace  app\controllers;

use  app\validators\ValidateCreateUserRequest;
use  app\validators\ValidateLoginUserRequest;
use  app\services\UserService;
use  app\utils\Response;
use  app\utils\DB;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


class UserController
{

    public function create()
    {
        ( new ValidateCreateUserRequest( $_POST ) )->validate();
        
        $username = preg_replace( '/\s+/', '', $_POST[ 'username' ] );
        $password = $_POST[ 'password' ];
        

        ( new UserService() )->addUser( $username, $password );

        ( new Response( 200, 'Signed up sucsessfully' ) )->send();
    }

    public function login( )
    {
        ( new ValidateLoginUserRequest( $_GET ) )->validate();

        $username = preg_replace('/\s+/', '', $_GET['username']);
        $password = $_GET[ 'password' ];

        ( new UserService() )->loginUser( $username, $password );

        ( new Response( 200, 'Logged in sucsessfully' ) )->send();
    }

    function logout()
    {
        ( new UserService() )->logOutUser();

        ( new Response( 200, 'Logged out sucsessfully' ) )->send();
    }
    
    function get()
    {
        if ( ! isset( $_SESSION[ 'id' ] ) ) 
        {
            ( new Response( 400, 'User is not logged in' ) )->send();
        }
    
        //Gets the user from request username
        $user = DB::table( 'users' )->get( $_GET[ 'id' ] );
        unset( $user[ 'hashed_password' ] );
    
        ( new Response( 200, $user ) )->send();
    }

    function getLogged()
    {
        if( ! isset( $_SESSION[ 'id' ] ) )
        {
            ( new Response( 400, 'User is not logged in' ) )->send();
        }
    
        $loggedUsers = ( new UserService() )->getLoggedUsers();
    
        ( new Response( 200, $loggedUsers ) )->send();
    }
}
