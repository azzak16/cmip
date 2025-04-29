<?php 
namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // if (!\Core\Auth::check()) {
        //     header('Location: /login');
        //     exit;
        // }
        
        $this->view('home/index', ['title' => 'Dashboard']);
    }
}
