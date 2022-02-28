<?php

    //Validates user registeration request attributes
    function validateUserRegisterDetails( $username, $password, $password_confirm ){

        if ( ! isset( $username ) || !  isset( $password ) || ! isset( $password_confirm )) {
            header("HTTP/1.1 400 Please fill al fields");
            header("Location: /client/forms/signup.html");
            exit();
        }
    
        if( $password !== $password_confirm){
            header("HTTP/1.1 400 Passwords dont match");
            header("Location: /client/forms/signup.html");
            exit();
        }
    
        if (  DB::table( 'users' )->where( 'username', $username ) ) {
            header("HTTP/1.1 409 username is taken");
            header("Location: /client/forms/signup.html");
            exit();
        }


    }

    //Validates user login request attributes
    function validateUserLoginDetails( $username, $password ){

        if ( ! isset( $username ) || !  isset( $password ) ) {
            header("HTTP/1.1 400 Please fill al fields");
            header("Location: /client/forms/login.html");
            exit();
        }
    
    
        if ( ! DB::table( 'users' )->where( 'username', $username ) ) {
            header("HTTP/1.1 404 username does not exists");
            header("Location: /client/forms/login.html");
            exit();
        }


    }
    


?>