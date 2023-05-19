<?php

namespace App\Tests\Unit;

require_once __DIR__ . '/../../../config-test.php';
use App\Utils\AppRouter;
use App\Services\UserService;
use App\Utils\DB;

it('returns an error when a user is not logged in', function () {
    $router = AppRouter::router();

    $username = 'josh';
    UserService::make()->addUser($username, 'Aa123');
    $userId = DB::table('users')->where('username', '===', $username)[ 0 ][ 'id' ];

    session_start();
    session_destroy();

    $getUserUri = '/user?id='.$userId;
    $unValidGetUserResponse = $router->getResponse($getUserUri);
    $this->assertEquals(400, $unValidGetUserResponse->statusCode);

    $user = [ 'username' => 'omer', 'id' => 'joshs-id' ];
    $validGetUserResponse = $router->actAs($user)->getResponse($getUserUri);
    $this->assertEquals(200, $validGetUserResponse->statusCode);
});

afterEach(function () {
    DB::clear();
    session_destroy();
});
