<?php

namespace App\Tests\Unit;

require_once __DIR__ . '/../../../config-test.php';

use App\Utils\AppRouter;
use App\Utils\DB;

it('returns an error when a user is not logged in', function () {
    $router = AppRouter::router();

    $logoutUri = '/user/logout';

    //Login user
    $user = [ 'username' => 'omer', 'id' => 'Aa123' ];

    $validLogoutResponse = $router->actAs($user)->getResponse($logoutUri);
    $this->assertEquals(200, $validLogoutResponse->statusCode);

    session_start();
    $unValidLogoutResponse = $router->getResponse($logoutUri);
    $this->assertEquals(400, $unValidLogoutResponse->statusCode);
});

afterEach(function () {
    DB::clear();
    session_destroy();
});
