<?php

namespace App\Tests\Unit;

require_once __DIR__ . '/../../../config-test.php';
use App\Utils\AppRouter;
use App\Utils\DB;

it('returns an error when a user is not logged in', function () {
    $router = AppRouter::router();
    $getLoggedUsersUri = '/user/get-logged';
    $unValidGetLoggedUserResponse = $router->getResponse($getLoggedUsersUri);
    $this->assertEquals(400, $unValidGetLoggedUserResponse->statusCode);

    $user = [ 'username' => 'josh', 'id' => 'joshs-id' ];
    $validGetLoggedUsersResponse = $router->actAs($user)->getResponse($getLoggedUsersUri);
    $this->assertEquals(200, $validGetLoggedUsersResponse->statusCode);
});

afterEach(function () {
    DB::clear();
    session_destroy();
});
