<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Utils\Response;
use App\Validators\CreateUserRequest;
use App\Validators\GetLoggedUsersRequest;
use App\Validators\GetUserRequest;
use App\Validators\LoginUserRequest;
use App\Validators\LogoutUserRequest;

class UserController
{
    public static function make()
    {
        return new static();
    }

    public function create($request)
    {
        CreateUserRequest::make($request)->validate();

        UserService::make()->addUser($request[ 'username' ], $request[ 'password' ]);

        return Response::make(200, 'Signed up sucsessfully');
    }

    public function login($request)
    {
        [ 'username' => $username, 'password' => $password ] = LoginUserRequest::make($request)->validate();

        UserService::make()->loginUser($username, $password);

        return Response::make(200, _('Logged in sucsessfully'));
    }

    public function logout()
    {
        LogoutUserRequest::make()->validate();

        UserService::make()->logOutUser();

        return Response::make(200, _('Logged out sucsessfully'));
    }

    public function get($request)
    {
        GetUserRequest::make($request)->validate();

        $user = UserService::make()->getUser($request[ 'id' ]);

        return Response::make(200, $user);
    }

    public function getLogged()
    {
        GetLoggedUsersRequest::make()->validate();

        $loggedUsers = UserService::make()->getLoggedUsers();

        return Response::make(200, $loggedUsers);
    }
}
