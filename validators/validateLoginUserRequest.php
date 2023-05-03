<?php

function validateLoginUserRequest( $request )
{
    $username = preg_replace('/\s+/', '', $request['username']) ?? null;
    $password = $request[ 'password' ] ?? null;

    if ( ! $username || ! $password )
    {
        ( new Response( 400, 'Please fill all required fields' ) )->send();
    }


    if ( ! DB::table( 'users' )->where( 'username', null, $username ) ) 
    {
        ( new Response( 404, 'User not found' ) )->send();
    }
}