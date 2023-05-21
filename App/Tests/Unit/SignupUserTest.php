<?php

namespace App\Tests\Unit;

require_once __DIR__ . '/../../../config-test.php';

use App\Services\UserService;
use App\Utils\AppRouter;
use App\Utils\DB;
use App\Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
    session_start();
});

afterEach(function () {
    DB::clear();
});

it('registers a user when all parameters are passed correctly', function () {
    //Arrange
    $validUser = ['username' => 'josh', 'password' => 'Aa123', 'password_confirm' => 'Aa123'];

    //Act
    $validSignupResponse = AppRouter::router()->json($validUser)->getResponse('/user/signup');

    //Assert
    $this->assertEquals(200, $validSignupResponse->statusCode);
});

it('returns an error when a username is not passed', function () {
    //Arrange
    $unvalidUser = [ 'password' => 'Aa123', 'password_confirm' => 'Aa123' ];

    //Act
    $unvalidResponse = AppRouter::router()->json($unvalidUser)->getResponse('/user/signup');

    //Assert
    $this->assertEquals(400, $unvalidResponse->statusCode);
});

it('returns an error when a password is not passed', function () {
    //Arrange
    $unvalidUser = [ 'username' => 'omer', 'password_confirm' => 'Aa123' ];

    //Act
    $unvalidResponse = AppRouter::router()->json($unvalidUser)->getResponse('/user/signup');

    //Assert
    $this->assertEquals(400, $unvalidResponse->statusCode);
});

it('returns an error when a password_confirm is not passed', function () {
    //Arrange
    $unvalidUser = [ 'username' => 'omer', 'password' => 'Aa123' ];

    //Act
    $unvalidResponse = AppRouter::router()->json($unvalidUser)->getResponse('/user/signup');

    //Assert
    $this->assertEquals(400, $unvalidResponse->statusCode);
});

it('returns an error when a username is not set', function () {
    //Arrange
    $unvalidUser = [ 'username' => '', 'password' => 'Aa123', 'password_confirm' => 'Aa123' ];

    //Act
    $unvalidResponse = AppRouter::router()->json($unvalidUser)->getResponse('/user/signup');

    //Assert
    $this->assertEquals(400, $unvalidResponse->statusCode);
});

it('returns an error when a password is not set', function () {
    //Arrange
    $unvalidUser = [ 'username' => 'omer', 'password' => '', 'password_confirm' => 'Aa123' ];

    //Act
    $unvalidResponse = AppRouter::router()->json($unvalidUser)->getResponse('/user/signup');

    //Assert
    $this->assertEquals(400, $unvalidResponse->statusCode);
});

it('returns an error when a password_confirm is not set', function () {
    //Arrange
    $unvalidUser = [ 'username' => 'omer', 'password' => 'Aa123', 'password_confirm' => '' ];

    //Act
    $unvalidResponse = AppRouter::router()->json($unvalidUser)->getResponse('/user/signup');

    //Assert
    $this->assertEquals(400, $unvalidResponse->statusCode);
});

it('returns an error when a username is taken', function () {
    //Arrange
    UserService::make()->addUser('josh', 'Aa123');
    $takenUsernameUser = ['username' => 'josh', 'password' => 'Aa123', 'password_confirm' => 'Aa123'];

    //Act
    $createSameUserResponse = AppRouter::router()->json($takenUsernameUser)->getResponse('/user/signup');

    //Assert
    $this->assertEquals(409, $createSameUserResponse->statusCode);
});
