<?php

namespace App\Tests\Unit;

require_once __DIR__ . '/../../../config-test.php';
use App\Controllers\UserController;
use App\Utils\AppRouter;
use App\Utils\DB;


it( 'returns an error when a username ,password or paaword_confirm is not passed', function () {

    $router = AppRouter::router();
        
    $userWithoutUsername         = [ 'password' => 'Aa123', 'password_confirm' => 'Aa123'];
    $userWithoutPasssword        = ['username' => 'josh', 'password_confirm' => 'Aa123'];
    $userWithoutPassswordConfirm = ['username' => 'josh', 'password' => 'Aa123' ];
    $validUser                   = ['username' => 'josh', 'password' => 'Aa123', 'password_confirm' => 'Aa123'];
    
    $signupUri = '/user/signup';

    $usernameNotPassedResponse = $router->json($userWithoutUsername)->getResponse($signupUri);
    $this->assertEquals(400, $usernameNotPassedResponse->statusCode);

    $passwordNotPassedResponse = $router->json($userWithoutPasssword)->getResponse($signupUri);
    $this->assertEquals(400, $passwordNotPassedResponse->statusCode);

    $passwordConfirmNotPassedResponse = $router->json($userWithoutPassswordConfirm)->getResponse($signupUri);
    $this->assertEquals(400, $passwordConfirmNotPassedResponse->statusCode);

    $validSignupResponse = $router->json($validUser)->getResponse($signupUri);
    $this->assertEquals(200, $validSignupResponse->statusCode);

});

it( 'returns an error when a username ,password or paaword_confirm is not set', function () {
    $router = AppRouter::router();

    $userWithoutUsername         = [ 'username' => '', 'password' => 'Aa123', 'password_confirm' => 'Aa123' ];
    $userWithoutPasssword        = [ 'username' => 'josh', 'password' => '', 'password_confirm' => 'Aa123' ];
    $userWithoutPassswordConfirm = [ 'username' => 'josh', 'password' => 'Aa123', 'password_confirm' => '' ];
    $validUser                   = ['username' => 'josh', 'password' => 'Aa123', 'password_confirm' => 'Aa123'];
    
    $signupUri = '/user/signup';

    $usernameNotPassedResponse = $router->json($userWithoutUsername)->getResponse($signupUri);
    $this->assertEquals(400, $usernameNotPassedResponse->statusCode);

    $passwordNotPassedResponse = $router->json($userWithoutPasssword)->getResponse($signupUri);
    $this->assertEquals(400, $passwordNotPassedResponse->statusCode);

    $passwordConfirmNotPassedResponse = $router->json($userWithoutPassswordConfirm)->getResponse($signupUri);
    $this->assertEquals(400, $passwordConfirmNotPassedResponse->statusCode);

    $validSignupResponse = $router->json($validUser)->getResponse($signupUri);
    $this->assertEquals(200, $validSignupResponse->statusCode);
});

it( 'returns an error when a username is taken', function () {
    $router = AppRouter::router();

    $validUser = ['username' => 'josh', 'password' => 'Aa123', 'password_confirm' => 'Aa123'];
    $signupUri = '/user/signup';

    $createUserResponse = $router->json($validUser)->getResponse($signupUri);
    $this->assertEquals(200, $createUserResponse->statusCode);

    $createSameUserResponse = $router->json($validUser)->getResponse($signupUri);
    $this->assertEquals(409, $createSameUserResponse->statusCode);

});

afterEach( function(){  DB::clear(); });