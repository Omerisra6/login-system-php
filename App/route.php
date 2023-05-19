<?php
use App\Utils\AppRouter;

AppRouter::router()->route( $_SERVER[ 'REQUEST_URI' ] );