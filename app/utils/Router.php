<?php
namespace app\utils;

use app\utils\Response;
use app\utils\HtmlResponse;

class Router {

    private $routes = [];

    public function addRoute($path, $handler) 
    {
        $this->routes[ $path ] = $handler;
    }
  
    public function route( $path ) 
    {
        if ( ! isset( $this->routes[ $path ] )  ) 
        {
            $viewPath = $this->getFilePath( $path );
            
            file_exists( $viewPath )
            ? 
            ( new HtmlResponse( $viewPath ) )->send()
            :
            ( new Response( 404, 'Not found' ) )->send();
        }

        $this->executeHandler( $path );
    }

    private function getFilePath( $path )
    {
        $filename = $path . '.html';
        return PUBLIC_PATH . $filename;
    }

    private function extractQueryParams( $path )
    {
        $queryPosition = strpos( $path, '?' );
        if ( $queryPosition === false ) 
        {
            return [];
        }

        $queryString = substr( $path, $queryPosition + 1 );
        parse_str( $queryString, $queryParams );
        
        return $queryParams;
    }

    private function executeHandler( $path )
    {
        $queryParams = $this->extractQueryParams( $path );
        $handler     = $this->routes[ $path ];

        $handler( $queryParams );
    }
}
