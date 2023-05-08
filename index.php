<?php

session_start();

define( 'PUBLIC_PATH', __DIR__ . './public' );
define( 'DB_DIR', __DIR__ . '/App/DB' );

require_once( __DIR__ . '/App/autoload.php' );

require_once( __DIR__ . '/App/routes.php' );