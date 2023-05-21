<?php

namespace App\Tests;

use App\Utils\AppRouter;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function actAs($user): void
    {
        $_SESSION[ 'username' ] = $user[ 'username' ];
        $_SESSION[ 'id' ]       = $user[ 'id' ];
    }
}
