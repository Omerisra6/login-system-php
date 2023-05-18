<?php

namespace App\Utils;

use App\Utils\Response;
use App\Utils\HtmlResponse;

class Router
{
    private $routes = [];

    public function addRoute($path, $handler)
    {
        $this->routes[ $path ] = $handler;
    }

    public function route($path)
    {
        $this->getResponse($path)->send();
    }

    public function getResponse($path)
    {
        $viewPath = $this->getFilePath($path);
        if (! isset($this->routes[ $path ]) && ! file_exists($viewPath)) {
            return Response::make(404, 'Not found');
        }

        if (! isset($this->routes[ $path ])) {
            return HtmlResponse::make($viewPath);
        }

        return $this->executeHandler($path);
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

    private function executeHandler($path)
    {
        $queryParams = $this->extractQueryParams($path);
        $handler     = $this->routes[ $path ];

        try {
            $res = $handler($queryParams);
        } catch (\Exception $ex) {
            return Response::make($ex->getCode(), $ex->getMessage());
        }
        return $res;
    }
}
