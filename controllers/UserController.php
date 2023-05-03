<?php
    require_once(  __DIR__ . '/../validators/validateCreateUserRequest.php' );
    require_once(  __DIR__ . '/../validators/validateLoginUserRequest.php' );
    require_once( __DIR__ . '/../services/userService.php' );
    require_once( __DIR__ . '/../utils/response/response.php' );

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


    class UserController
    {
        function create()
        {
            validateCreateUserRequest( $_POST );
            
            $username = preg_replace( '/\s+/', '', $_POST[ 'username' ] );
            $password = $_POST[ 'password' ];
            

            addUser( $username, $password );

            ( new Response( 200, 'Signed up sucsessfully' ) )->send();
        }

        function login( )
        {
            validateLoginUserRequest( $_GET );

            $username = preg_replace('/\s+/', '', $_GET['username']);
            $password = $_GET[ 'password' ];

            loginUser( $username, $password );

            ( new Response( 200, 'Logged in sucsessfully' ) )->send();
        }

        function logout()
        {
            logOutUser();

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
                header("HTTP/1.1 400 User must be logged in");
                exit();
            }
        
            $loggedUsers = getLoggedUsers();
        
            ( new Response( 200, $loggedUsers ) )->send();

        }
    }
    