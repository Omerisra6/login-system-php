<?php
namespace app\controllers;

use  app\utils\HtmlResponse;
use  app\utils\Response;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

class DashboardController
{
    function show()
    {
        if ( ! isset( $_SESSION[ 'id' ] ) ) 
        {
            ( new Response( 302, '/login' , true ) )->send();
        }

        $indexPath = PUBLIC_PATH . '/index.php';
        ( new HtmlResponse( $indexPath, [ 'username' => $_SESSION[ 'username' ], 'id' => $_SESSION[ 'id' ] ] ) )
        ->send();
    }
}
