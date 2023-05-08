<?php
namespace App\Validators;

use App\Utils\Response;
use App\Utils\DB;

class ValidateLoginUserRequest
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
    
    function validate( )
    {
        if (  ! isset( $this->request[ 'username' ] ) || ! isset( $this->request[ 'password' ] ) )
        {
            Response::make( 400, 'Please fill all required fields' )->send();
        }
        
        $username = preg_replace('/\s+/', '', $this->request[ 'username' ]) ?? null;
        $password = $this->request[ 'password' ] ?? null;
    
        if ( ! $username || ! $password )
        {
            Response::make( 400, 'Please fill all required fields' )->send();
        }
    
    
        if ( ! DB::table( 'users' )->where( 'username', null, $username ) ) 
        {
            Response::make( 404, 'User not found' )->send();
        }

        return [ 'username' => $username, 'password' => $password ];
    }
}