<?php

namespace App\Utils;

use App\Utils\Response;
use App\Utils\HtmlResponse;

class Router
{
    private $routes = [];

    public function get($path, $handler)
    {
        $this->routes[ $path ] = [ 'handler' => $handler, 'method' => 'GET' ];
    }

    public function post($path, $handler)
    {
        $this->routes[ $path ] = [ 'handler' => $handler, 'method' => 'POST' ];
    }

    public function json($data)
    {
        $_POST = $data;    
        return $this;
    }

    public function actAs($user)
    {
        if (session_status() === PHP_SESSION_NONE) 
        {

            session_start();
        }

        $_SESSION[ 'id' ]       = $user[ 'id' ]; 
        $_SESSION[ 'username' ] = $user[ 'username' ]; 

        return $this;
    }

    public function route($path)
    {
        $this->getResponse($path)->send();
    }

    public function getResponse($uri)
    {
        $path     = strtok($uri, '?');
        $viewPath = $this->getFilePath($path);
        if (! isset($this->routes[ $path ]) && ! file_exists($viewPath)) {
            return Response::make(404, 'Not found');
        }

        if (! isset($this->routes[ $path ])) {
            return HtmlResponse::make($viewPath);
        }

        return $this->executeHandler($uri);
    }

    private function getFilePath($path)
    {
        $filename = $path . '.html';
        return PUBLIC_PATH . $filename;
    }

    private function extractQueryParams($path)
    {
        $queryPosition = strpos($path, '?');
        if ($queryPosition === false) {
            return [];
        }

        $queryString = substr($path, $queryPosition + 1);
        parse_str($queryString, $queryParams);

        return $queryParams;
    }

    private function executeHandler($uri)
    {
        $path        = strtok($uri, '?');
        [ 'handler' => $handler, 'method' => $method ] = $this->routes[ $path ];

        $request = $method === 'GET' ? $this->extractQueryParams($uri) : $_POST;
        
        try {
            $res = $handler($request);
        } catch (\Exception $ex) {
            return Response::make($ex->getCode(), $ex->getMessage());
        }
        return $res;
    }
}
