<?php

namespace App\Utils;

use App\Controllers\DashboardController;
use App\Controllers\UserController;
use App\Utils\Router;

class AppRouter
{
    public $router;

    public function __construct()
    {
        $router = new Router();

        //Dashboard Routes
        $router->get('/', [ DashboardController::class, 'show' ]);

        //User Routes
        $router->get('/user/login', [ UserController::class, 'login' ]);
        $router->post('/user/signup', [ UserController::class, 'create' ]);
        $router->get('/user/logout', [ UserController::class, 'logout' ]);
        $router->get('/user', [ UserController::class, 'get' ]);
        $router->get('/user/get-logged', [ UserController::class, 'getLogged' ]);

        $this->router = $router;
    }

    public static function router()
    {
        return (new static())->router;
    }
}
