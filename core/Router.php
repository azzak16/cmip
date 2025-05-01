<?php 
namespace Core;

class Router
{
    private $routes = [];

    public function run()
    {
        session_start();
        require_once ROOT_PATH . 'routes/web.php';
        $router->dispatch();
    }

    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = strtok($_SERVER['REQUEST_URI'], '?');

        $base = dirname($_SERVER['SCRIPT_NAME']);
        
        $segment = $_SERVER['REQUEST_URI'];
        $segment = ltrim($segment, '/');
        $segment = explode('/', $segment);

        $uri = '/' . trim(str_replace($segment[0], '', $uri), '/');
        
        foreach ($this->routes[$method] as $route => $callback) {
            $pattern = preg_replace('/\{[^\}]+\}/', '([^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';
        
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // remove full match
                [$controller, $action] = $callback;
                $controller = new $controller();
                call_user_func_array([$controller, $action], $matches);
                return;
            }
        }
        

        // $callback = $this->routes[$method][$uri] ?? null;


        // if ($callback) {
        //     [$controller, $method] = $callback;
        //     $controller = new $controller();
        //     call_user_func([$controller, $method]);
        // } else {
        //     http_response_code(404);
        //     echo "404 Not Found";
        // }
    }
}
