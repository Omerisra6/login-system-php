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

it('not returns an error when a existing user logges in', function () {
    //Arrange
    UserService::make()->addUser('josh', 'Aa123');

    //Act
    $validLoginResponse = AppRouter::router()->getResponse('/user/login?username=josh&&password=Aa123');

    //Assert
    $this->assertEquals(200, $validLoginResponse->statusCode);
});

it('returns an error when a username is not passed', function () {
    //Arrange
    UserService::make()->addUser('josh', 'Aa123');

    //Act
    $unvalidResponse = AppRouter::router()->getResponse('/user/login?password=Aa123');

    //Assert
    $this->assertEquals(400, $unvalidResponse->statusCode);
});

it('returns an error when a password is not passed', function () {
    //Arrange
    UserService::make()->addUser('josh', 'Aa123');

    //Act
    $unvalidResponse = AppRouter::router()->getResponse('/user/login?username=josh');

    //Assert
    $this->assertEquals(400, $unvalidResponse->statusCode);
});

it('returns an error when a username is not set', function () {
    //Arrange
    UserService::make()->addUser('josh', 'Aa123');

    //Act
    $unvalidResponse = AppRouter::router()->getResponse('/user/login?password=Aa123&&username=');

    //Assert
    $this->assertEquals(400, $unvalidResponse->statusCode);
});

it('returns an error when a password is not set', function () {
    //Arrange
    UserService::make()->addUser('josh', 'Aa123');

    //Act
    $unvalidResponse = AppRouter::router()->getResponse('/user/login?password=&&username=josh');

    //Assert
    $this->assertEquals(400, $unvalidResponse->statusCode);
});


it('returns an error when a user is not found in DB', function () {
    //Arrange
    UserService::make()->addUser('josh', 'Aa123');

    //Act
    $unvalidResponse = AppRouter::router()->getResponse('/user/login?username=not-josh&&password=Aa123');

    //Assert
    $this->assertEquals(404, $unvalidResponse->statusCode);
});

it('returns an error when a wrong password is passed', function () {
    //Arrange
    UserService::make()->addUser('josh', 'Aa123');

    //Act
    $unvalidResponse = AppRouter::router()->getResponse('/user/login?username=josh&&password=Bb123');

    //Assert
    $this->assertEquals(400, $unvalidResponse->statusCode);
});
