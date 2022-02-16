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



?>