<?php

define('APP_PATH', realpath(__DIR__ . '/../app/') . '/');
define('ROOT_PATH', realpath(__DIR__ . '/../') . '/');

require_once __DIR__ . '/../vendor/autoload.php';
// require_once __DIR__ . '/../core/Env.php';

use Core\Env;
use Core\Router;

// env
$env = new Env();
$env->load(__DIR__ . '/../.env');

// route
$router = new Router();
$router->run();
