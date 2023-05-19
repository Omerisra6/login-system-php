<?php

namespace App\Tests\Unit;

require_once __DIR__ . '/../../../config-test.php';
use App\Services\UserService;
use App\Utils\AppRouter;
use App\Utils\DB;


it( 'returns an error when a username or password is not passed', function ( ) {
    
    $router = AppRouter::router();

    UserService::make()->addUser('josh', 'Aa123');
    $usernameNotPassedUri = '/user/login?password=Aa123';
    $passwordNotPassedUri = '/user/login?username=josh';
    $validUri             = '/user/login?username=josh&&password=Aa123';

    $usernameNotPassedResponse = $router->getResponse($usernameNotPassedUri);
    $this->assertEquals(400, $usernameNotPassedResponse->statusCode);

    $passwordNotPassedResponse = $router->getResponse($passwordNotPassedUri);
    $this->assertEquals(400, $passwordNotPassedResponse->statusCode);

    $validLoginResponse = $router->getResponse($validUri);
    $this->assertEquals(200, $validLoginResponse->statusCode);

});

it( 'returns an error when a username or password is not set', function () {
    $router = AppRouter::router();

    UserService::make()->addUser('josh', 'Aa123');
    $usernameNotSetUri = '/user/login?password=Aa123&&username=';
    $passwordNotSetUri = '/user/login?username=josh&&password=';
    $validUri          = '/user/login?username=josh&&password=Aa123';

    $usernameNotSetResponse = $router->getResponse($usernameNotSetUri);
    $this->assertEquals(400, $usernameNotSetResponse->statusCode);

    $passwordNotSetResponse = $router->getResponse($passwordNotSetUri);
    $this->assertEquals(400, $passwordNotSetResponse->statusCode);

    $validLoginResponse = $router->getResponse($validUri);
    $this->assertEquals(200, $validLoginResponse->statusCode);

});

it( 'returns an error when a user is not found in DB', function () {
    $router = AppRouter::router();

    UserService::make()->addUser('josh', 'Aa123');
    $userNotExistsUri  = '/user/login?username=not-josh&&password=Aa123';
    $validUri          = '/user/login?username=josh&&password=Aa123';

    $userNotExistsResponse = $router->getResponse($userNotExistsUri);
    $this->assertEquals(404, $userNotExistsResponse->statusCode);


    $validLoginResponse = $router->getResponse($validUri);
    $this->assertEquals(200, $validLoginResponse->statusCode);

});

it( 'returns an error when a wrong password is passed', function () {
    $router = AppRouter::router();

    UserService::make()->addUser('josh', 'Aa123');
    $wrongPasswordUri  = '/user/login?username=josh&&password=Bb123';
    $validUri          = '/user/login?username=josh&&password=Aa123';

    $wrongPasswordResponse = $router->getResponse($wrongPasswordUri);
    $this->assertEquals(400, $wrongPasswordResponse->statusCode);


    $validLoginResponse = $router->getResponse($validUri);
    $this->assertEquals(200, $validLoginResponse->statusCode);

});

afterEach( function(){  DB::clear(); });