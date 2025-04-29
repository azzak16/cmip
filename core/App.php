<?php 
namespace Core;

use Core\Router;

class App
{
    public function run()
    {
        session_start();
        $router = new Router();
        require_once __DIR__ . '/../routes/web.php';
        $router->dispatch();
    }
}
