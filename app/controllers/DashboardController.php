<?php
namespace App\Controllers;

use App\Utils\HtmlResponse;
use App\Utils\Response;

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
            Response::make( 302, '/login' , true )->send();
        }

        $indexPath = PUBLIC_PATH . '/index.php';
        HtmlResponse::make( $indexPath, [ 'username' => $_SESSION[ 'username' ], 'id' => $_SESSION[ 'id' ] ] )
        ->send();
    }
}
