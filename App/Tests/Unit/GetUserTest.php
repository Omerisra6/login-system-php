<?php

namespace App\Tests\Unit;

require_once __DIR__ . '/../../../config-test.php';
use App\Utils\AppRouter;
use App\Services\UserService;
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

it('returns user when a user is logged in', function () {
    //Arrange
    $user   = UserService::make()->addUser('josh', 'Aa123');
    $userId = $user[ 'id' ];
    session_reset();

    $loggedUser = UserService::make()->addUser('omer', 'Aa123');
    $this->actAs($loggedUser);

    //Act
    $validGetUserResponse = AppRouter::router()->getResponse('/user?id='.$userId);

    //Assert
    $this->assertEquals(200, $validGetUserResponse->statusCode);
    $this->assertEquals($user, $validGetUserResponse->data);
});

it('returns an error when a user is not logged in', function () {

    //Arrange
    $userId = UserService::make()->addUser('josh', 'Aa123')[ 'id' ];
    session_reset();

    //Act
    $unValidGetUserResponse = AppRouter::router()->getResponse('/user?id='.$userId);

    //Assert
    $this->assertEquals(400, $unValidGetUserResponse->statusCode);
});
