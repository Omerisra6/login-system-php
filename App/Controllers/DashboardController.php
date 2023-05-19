<?php

namespace App\Controllers;

use App\Utils\HtmlResponse;
use App\Utils\Response;

class DashboardController
{
    public function show()
    {
        if (! isset($_SESSION[ 'id' ])) {
            return Response::make(302, '/login', true);
        }

        return HtmlResponse::make(INDEX_PATH, [ 'username' => $_SESSION[ 'username' ], 'id' => $_SESSION[ 'id' ] ]);
    }
}
