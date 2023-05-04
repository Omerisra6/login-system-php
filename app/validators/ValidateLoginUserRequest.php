<?php
namespace  app\validators;

use  app\utils\Response;
use  app\utils\DB;

class ValidateLoginUserRequest
{
    private $request;
    
    public function __construct( $request )
    {
        $this->request = $request;
    }

    function validate()
    {
        if (  ! isset( $this->request[ 'username' ] ) || ! isset( $this->request[ 'password' ] ) )
        {
            ( new Response( 400, 'Please fill all required fields' ) )->send();
        }
        
        $username = preg_replace('/\s+/', '', $this->request[ 'username' ]) ?? null;
        $password = $this->request[ 'password' ] ?? null;
    
        if ( ! $username || ! $password )
        {
            ( new Response( 400, 'Please fill all required fields' ) )->send();
        }
    
    
        if ( ! DB::table( 'users' )->where( 'username', null, $username ) ) 
        {
            ( new Response( 404, 'User not found' ) )->send();
        }
    }
}