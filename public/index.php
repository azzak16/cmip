<?php

use Core\Config;

define('APP_PATH', realpath(__DIR__ . '/../app/') . '/');
define('PUBLIC_PATH', realpath(__DIR__ . '/../public/') . '/');
define('ROOT_PATH', realpath(__DIR__ . '/../') . '/');

require_once __DIR__ . '/../vendor/autoload.php';
require_once APP_PATH. '/Helpers/roman.php';
// require_once __DIR__ . '/../core/Env.php';

Config::loadEnv();

use Core\Env;
use Core\Router;

// env
$env = new Env();
$env->load(__DIR__ . '/../.env');

// route
$router = new Router();
$router->run();
