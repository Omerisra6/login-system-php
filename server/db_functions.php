<?php

    //Creats csv file for user`s details
    function addUser( $username, $password ){

        $userDetailsPath = getUserDetailsPath( $username );
        $handle = fopen( $userDetailsPath, 'w');
        
        $hashed_password = password_hash( $password, PASSWORD_DEFAULT);
        $login_count     = 0;
        $ip              = $_SERVER['REMOTE_ADDR'];
        $user_agent      = $_SERVER['HTTP_USER_AGENT'];
        $last_action     = date("Y-m-d H:i:s");     
        $last_login      = date("Y-m-d H:i:s");  
        $register_time   = date("Y-m-d H:i:s");  
        
        $user = [ 
            $username, $hashed_password, 
            $login_count, $ip, 
            $user_agent, $last_action,
            $last_login, $register_time
        ];

        fputcsv( $handle, $user, ','); 
        fclose( $handle );

        $_SESSION[ 'username' ] = $username;
    }


    function loginUser( $username, $password){

        $user_details = getUser( $username );

        if ( ! password_verify( $password, $user_details[ 1 ] ) ){
            header("HTTP/1.1 400 Wrong password");
            exit();       
        }

        //Updates the user data on login
        updateUser( $username );

        $_SESSION[ 'username' ] = $username;
    }

    //Destroys session and marks user as offline
    function logOutUser(){

        markUserOffline();

        session_destroy();

    }

    //Gets user details from username
    function getUser( $username ){
        $user_details_path =  getUserDetailsPath( $username );
        
        return getUserFromFile( $user_details_path );
    }

    //Returns user details by file path
    function getUserFromFile( $file_path ){

        $handle = fopen( $file_path, 'r' );

        $user_details = fgetcsv( $handle ) ;
        fclose( $handle );

        return $user_details;
    }

    //Updates the user details on request
    function updateUser( $current_username = null ){

        //Sets username if it not passed
        if (! isset( $current_username ) ) {
            $current_username = $_SESSION[ 'username' ];
        }

        $user_details = getUser( $current_username );


        //if it is user login request increase login count and last login time
        if ( ! isset( $_SESSION[ 'username' ] ) ) {
            $user_details [ 2 ] = (int)$user_details[ 2 ] + 1;
            $user_details [ 6 ] =  date("Y-m-d H:i:s"); 
        }

        $user_details [ 3 ] = $_SERVER['REMOTE_ADDR'];
        $user_details [ 4 ] = $_SERVER['HTTP_USER_AGENT'];
        $user_details [ 5 ] = date("Y-m-d H:i:s");     

        putUserDetials( $current_username, $user_details );

        
    }

    //Replace old user data in new data
    function putUserDetials( $username, $new_user){

        $user_details_path =  getUserDetailsPath( $username );

        $handle = fopen( $user_details_path, 'a+' );
        file_put_contents( $user_details_path, "" );
        fputcsv( $handle, $new_user, ','); 

        fclose( $handle );
    }

    //Marks user as offline in csv file
    function markUserOffline(){

        $username = $_SESSION[ 'username' ];
        $user_details =  getUser( $username );

        $user_details[ 5 ] = 'offline';
        putUserDetials( $username, $user_details );

    }

?>