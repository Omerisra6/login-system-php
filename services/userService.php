<?php
    require_once( './utils/DB.php' );

    function addUser( $username, $password )
    {    
        $hashed_password = password_hash( $password, PASSWORD_DEFAULT );
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

        $user_details = DB::table( 'users' )->where( 'username', null, $username );

        if ( ! password_verify( $password, $user_details[ 0 ][ 'hashed_password' ] ) )
        {
            ( new Response( 400, 'Wrong password' ) )->send();
        }

        updateUser( $user_details[ 0 ][ 'id' ] );

        $_SESSION[ 'id' ] = $user_details[ 0 ][ 'id' ];
        $_SESSION[ 'username' ] = $username;
    }

    function logOutUser()
    {
        markUserOffline();

        session_destroy();
    }

    function getLoggedUsers()
    {

        $loggedUsers = DB::table( 'users' )->where( 'last_action', '>', time() - 180 );

        updateUser();

        foreach( $loggedUsers as $index => $user )
        {
            unset( $loggedUsers[ $index ][ 'hashed_password' ] );
        }

        return $loggedUsers;
    }

    
    function updateUser( $current_id = null )
    {
    
        if ( ! isset( $current_id ) ) 
        {
            $current_id = $_SESSION[ 'id' ];
        }

        $user_details = DB::table( 'users' )->get( $current_id );

        
        if ( ! isset( $_SESSION[ 'id' ] ) ) 
        {
            $user_details[ 'login_count' ] = (int)$user_details[ 'login_count' ] + 1;
            $user_details[ 'last_login' ] =  date("Y-m-d H:i:s"); 
        }

        $user_details[ 'ip' ] = $_SERVER[ 'REMOTE_ADDR' ];
        $user_details[ 'user_agent' ] = $_SERVER[ 'HTTP_USER_AGENT' ];
        $user_details[ 'last_action' ] = time();

        DB::table( 'users' )->update( $current_id, $user_details );
    }

    //Marks user as offline in csv file
    function markUserOffline()
    {
        $id = $_SESSION[ 'id' ];
        $user_details =  DB::table( 'users' )->get( $id );

        $user_details[ 'last_action' ] = 'offline';
        DB::table( 'users' )->update( $id, $user_details );
    }