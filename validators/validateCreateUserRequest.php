<?php
require_once( __DIR__ . '\..\utils\response\response.php' );

function validateCreateUserRequest( $request )
{
    $username         = preg_replace('/\s+/', '', $request['username']);
    $password         = $request[ 'password' ];
    $password_confirm = $request[ 'password_confirm' ];
    
    if ( ! isset( $username ) || !  isset( $password ) || ! isset( $password_confirm )) 
    {
        ( new Response( 400, 'Please fill all required fields' ) )->send();
    }

    if( $password !== $password_confirm)
    {
        ( new Response( 400, 'Passwords don\'t match' ) )->send();
    }

    if (  DB::table( 'users' )->where( 'username', null , $username ) ) 
    {
        ( new Response( 409, 'User already exists' ) )->send();
    }
}