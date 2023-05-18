<?php

namespace App\Controllers;

use App\Validators\ValidateCreateUserRequest;
use App\Validators\ValidateLoginUserRequest;
use App\Services\UserService;
use App\Utils\Response;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


class UserController
{
    public static function make()
    {
        return new static();
    }

    public function create()
    {
        ValidateCreateUserRequest::make($_POST)->validate();

        UserService::make()->addUser($_POST[ 'username' ], $_POST[ 'password' ]);

        Response::make(200, 'Signed up sucsessfully')->send();
    }

    public function login()
    {
        ValidateLoginUserRequest::make($_GET)->validate();

        $username = preg_replace('/\s+/', '', $_GET['username']);
        $password = $_GET[ 'password' ];

        UserService::make()->loginUser($username, $password);

        Response::make(200, 'Logged in sucsessfully')->send();
    }

    public function logout()
    {
        UserService::make()->logOutUser();

        Response::make(200, 'Logged out sucsessfully')->send();
    }

    public function get()
    {
        if (! isset($_SESSION[ 'id' ])) {
            Response::make(400, 'User is not logged in')->send();
        }

        if (! isset($_GET[ 'id' ])) {
            Response::make(404, 'User not found')->send();
        }

        $user = UserService::make()->getUser($_GET[ 'id' ]);

        Response::make(200, $user)->send();
    }

    public function getLogged()
    {
        if (! isset($_SESSION[ 'id' ])) {
            Response::make(400, 'User is not logged in')->send();
        }

        $loggedUsers = UserService::make()->getLoggedUsers();

        Response::make(200, $loggedUsers)->send();
    }
}
