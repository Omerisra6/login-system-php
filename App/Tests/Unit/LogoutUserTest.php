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

it('logs out when a user is logged in', function () {
    //Arrange
    $user = UserService::make()->addUser('omer', 'Aa123');
    $this->actAs($user);

    //Act
    $validResponse = AppRouter::router()->getResponse('/user/logout');

    //Assert
    $this->assertEquals(200, $validResponse->statusCode);
});

it('returns an error when a user is not logged in', function () {
    //Act
    $unvalidResponse = AppRouter::router()->getResponse('/user/logout');

    //Assert
    $this->assertEquals(400, $unvalidResponse->statusCode);
});
