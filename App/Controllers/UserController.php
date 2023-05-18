<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Utils\Response;
use App\Validators\CreateUserRequest;
use App\Validators\GetUserRequest;
use App\Validators\LoginUserRequest;

class UserController
{
    public static function make()
    {
        return new static();
    }

    public function create()
    {
        CreateUserRequest::make($_POST)->validate();

        UserService::make()->addUser($_POST[ 'username' ], $_POST[ 'password' ]);

        return Response::make(200, 'Signed up sucsessfully');
    }

    public function login()
    {
        LoginUserRequest::make($_GET)->validate();
        $username = preg_replace('/\s+/', '', $_GET['username']);
        $password = $_GET[ 'password' ];

        UserService::make()->loginUser($username, $password);

        return Response::make(200, _('Logged in sucsessfully'));
    }

    public function logout()
    {
        UserService::make()->logOutUser();

        return Response::make(200, _('Logged out sucsessfully'));
    }

    public function get()
    {
        GetUserRequest::make($_GET)->validate();
        $user = UserService::make()->getUser($_GET[ 'id' ]);

        return Response::make(200, $user);
    }

    public function getLogged()
    {
        GetUserRequest::make($_GET)->validate();

        $loggedUsers = UserService::make()->getLoggedUsers();

        Response::make(200, $loggedUsers);
    }
}
