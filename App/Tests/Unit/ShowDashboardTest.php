<?php

namespace App\Tests\Unit;

require_once __DIR__ . '/../../../config-test.php';

use App\Utils\AppRouter;
use App\Utils\DB;

it('redirects when a user is not logged in', function () {
    $router = AppRouter::router();

    $getUserUri = '/';
    $unValidGetUserResponse = $router->getResponse($getUserUri);
    $this->assertEquals(302, $unValidGetUserResponse->statusCode);

    //Login user
    $user = [ 'id' => 'UserIds', 'username' => 'Mamba24'];

    $validGetUserResponse = $router->actAs($user)->getResponse($getUserUri);
    $this->assertEquals(200, $validGetUserResponse->statusCode);
});

afterEach(function () {
    DB::clear();
    session_destroy();
});
