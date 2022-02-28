<?php
    require_once( './db_class.php' );

    //Creates csv file for user`s details
    function addUser( $username, $password ){
        
        $hashed_password = password_hash( $password, PASSWORD_DEFAULT);
        $login_count     = 0;
        $ip              = $_SERVER['REMOTE_ADDR'];
        $user_agent      = $_SERVER['HTTP_USER_AGENT'];
        $now             = date('Y-m-d H:i:s');     
      
        
        $user = array(
            'username' => $username, 'hashed_password' => $hashed_password,
            'login_count' => $login_count, 'ip' => $ip, 'user_agent' => $user_agent, 
            'last_action' => time(), 'last_login' => $now, 'register_time' => $now
        ); 
        
        $user_details  = DB::table( 'users' )->insert( $user );

        $_SESSION[ 'id' ]       = $user_details[ 'id' ];
        $_SESSION[ 'username' ] = $username;
    }

    function loginUser( $username, $password ){

        $user_details = DB::table( 'users' )->where( 'username', $username );
        if ( ! password_verify( $password, $user_details[ 0 ][ 'hashed_password' ] ) ){
            header("HTTP/1.1 400 Wrong password");
            header("Location: /client/forms/login.html");
            exit();       
        }

        //Updates the user data on login
        updateUser( $user_details[ 0 ][ 'id' ] );

        $_SESSION[ 'id' ] = $user_details[ 0 ][ 'id' ];
        $_SESSION[ 'username' ] = $username;
    }

    //Destroys session and marks user as offline
    function logOutUser(){

        markUserOffline();

        session_destroy();

    }

    //Returns all logged users
    function getLoggedUsers(){

        
        //Adds only user which was active in the last three minutes
        $loggedCondition = array( 'key' => 'last_action', 'operator' => '>', 'compared_value' => time() - 180 );
        $loggedUsers = DB::table( 'users' )->whereCondition( $loggedCondition );

        //Updates logged user
        updateUser();

        //Removes password from user
        foreach( $loggedUsers as $index => $user ){
            unset( $loggedUsers[ $index ][ 'hashed_password' ] );

        }

        return $loggedUsers;

    }

    //Updates the user details on request
    function updateUser( $current_id = null ){

        //Sets username if it not passed
        if ( ! isset( $current_id ) ) {
            $current_id = $_SESSION[ 'id' ];
        }

        $user_details = DB::table( 'users' )->get( $current_id );

        //if it is user login request increase login count and last login time
        if ( ! isset( $_SESSION[ 'id' ] ) ) {
            $user_details[ 'login_count' ] = (int)$user_details[ 'login_count' ] + 1;
            $user_details[ 'last_login' ] =  date("Y-m-d H:i:s"); 
        }

        $user_details[ 'ip' ] = $_SERVER['REMOTE_ADDR'];
        $user_details[ 'user_agent' ] = $_SERVER['HTTP_USER_AGENT'];
        $user_details[ 'last_action' ] = time();

        DB::table( 'users' )->update( $current_id, $user_details );

    }

    //Marks user as offline in csv file
    function markUserOffline(){

        $id = $_SESSION[ 'id' ];
        $user_details =  DB::table( 'users' )->get( $id );

        $user_details[ 'last_action' ] = 'offline';
        DB::table( 'users' )->update( $id, $user_details);
    }

