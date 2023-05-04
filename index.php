<?php

session_start();

define( 'PUBLIC_PATH', __DIR__ . '.\public' );
define( 'DB_DIR', __DIR__ . '\app\DB' );

require_once( __DIR__ . '\app\autoload.php' );

require_once( __DIR__ . '\app\routes.php' );