<?php
namespace Core;

class Controller
{
    // public function view($path, $data = [])
    // {
    //     extract($data);
    //     require_once __DIR__ . '/../app/Views/' . $path . '.php';
    // }

    public function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    public function view($path, $data = [], $layout = '')
    {
        extract($data);
        ob_start();
        
        require APP_PATH . 'Views/' . $path . '.php';
        $content = ob_get_clean();
        
        if ($layout) {
            require_once APP_PATH . 'Views/' . $layout . '.php';
        } else {
            echo $content;
        }
    }
}
