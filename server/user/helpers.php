<?php

    //Validates user registeration request attributes
    function validateUserRegisterDetails( $username, $password, $password_confirm ){

        if ( ! isset( $username ) || !  isset( $password ) || ! isset( $password_confirm )) {
            header("HTTP/1.1 400 Please fill al fields");
            exit();
        }
    
        if( $password !== $password_confirm){
            header("HTTP/1.1 400 Passwords dont match");
            exit();
        }
    
        if ( isUserExists( $username) ) {
            header("HTTP/1.1 409 username is taken");
            exit();
        }


    }

    //Validates user login request attributes
    function validateUserLoginDetails( $username, $password ){

        if ( ! isset( $username ) || !  isset( $password ) ) {
            header("HTTP/1.1 400 Please fill al fields");
            exit();
        }
    
    
        if ( ! isUserExists( $username) ) {
            header("HTTP/1.1 404 username can`t be found");
            exit();
        }


    }

    //Returns path by username
    function getUserDetailsPath( $username ){
        return "./users/" . $username . ".csv";
    }

    //Checks if a user exists
    function isUserExists( $username ){

        $userDetailsPath =  getUserDetailsPath( $username );
        return file_exists( realpath( $userDetailsPath ) ) ;
    }

    


?>