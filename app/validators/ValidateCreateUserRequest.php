<?php
namespace  app\validators;

use  app\utils\Response;
use  app\utils\DB;

class ValidateCreateUserRequest
{
    private $request;
    
    public function __construct( $request )
    {
        $this->request = $request;
    }

    static function make( $request )
    {
        return new static( $request );
    }

    function validate()
    {
        $username         = preg_replace('/\s+/', '', $this->request['username']);
        $password         = $this->request[ 'password' ];
        $password_confirm = $this->request[ 'password_confirm' ];
        
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

    
    
}